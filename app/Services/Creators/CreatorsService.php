<?php

namespace App\Services\Creators;

use App\Constants\Creators;
use App\Events\ProfileApproved;
use App\Models\Creator;
use App\Models\ProfileRequest;
use App\Services\Images\ImagesService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CreatorsService
{
    public function __construct(
        private ImagesService $imagesService
    )
    {
        
    }

    public function createProfileRequest(Creator $creator, array $data): ?ProfileRequest
    {
        $changed = [];
        foreach ($creator->profileFields as $field) {
            if (
                ! array_key_exists($field, $data) or 
                ! $this->profileFieldChanged($creator, $field, $data[$field])
            ) {
                continue;
            }

            if (in_array($field, [
                'zip',
                'state', 
                'city', 
                'latitude', 
                'longitude',
            ])) { 
                $changed['location']['value']['zip'] =
                    $data['zip'];
                $changed['location']['value']['state'] =
                    $data['state'];
                $changed['location']['value']['city'] = 
                    $data['city'];
                $changed['location']['value']['latitude'] = 
                    $data['latitude'];
                $changed['location']['value']['longitude'] =    
                    $data['longitude'];
                $changed['location']['status'] = Creators::PROFILE_REQUEST_FIELD_STATUS['pending'];
                $changed['location']['comment'] = '';
            } elseif ($field == 'photos') {
                $photos = array_diff($data['photos'], $creator->photos ?? []);
                $changed['photos']['value'] = $photos;
                $changed['photos']['status'] = 
                    array_fill(0, count($photos), Creators::PROFILE_REQUEST_FIELD_STATUS['pending']);
                $changed['photos']['comment'] = 
                    array_fill(0, count($photos), '');
            } else {
                $changed[$field]['value'] = $data[$field];
                $changed[$field]['status'] = Creators::PROFILE_REQUEST_FIELD_STATUS['pending'];
                $changed[$field]['comment'] = '';
            }
        }

        $request = $changed ? $creator->profileRequests()->create($changed) : null;

        if ($request) {
            $creator->update(['profile_is_created' => true]);
        }

        return $request;
    }

    private function profileFieldChanged(Creator $creator, string $field, $value): bool
    {
        if ($field == 'photos') {
            return (bool) array_diff($value, $creator->photos ?? []);   
        }

        if ($field == 'birthday') {
            return $creator->birthday?->format('Y-m-d') != $value;
        }

        return $creator->{$field} != $value;
    }

    public function doneProfileRequest(ProfileRequest $profileRequest, array $data): ?ProfileRequest
    {
        $approved = $profileRequest->creator->is_approved;
        
        $profileRequest->update($data);

        $this->migrateDataToProfile($profileRequest);

        // if ($secondLast = $profileRequest->creator->secondLastProfileRequest()) {
        //     $this->deleteRejectedPhotos($secondLast);
        // }

        ProfileApproved::dispatch($profileRequest->creator);

        $nextProfileRequest = ProfileRequest::where('status', Creators::PROFILE_REQUEST_STATUS['undone'])
            ->whereHas('creator', function (Builder $query) use($approved) {
                $query->where('is_approved', $approved);
            })->orderBy('created_at', 'DESC')->first();

        return $nextProfileRequest;
    }

    private function migrateDataToProfile(ProfileRequest $profileRequest): void
    {
        $creator = $profileRequest->creator;

        foreach ($profileRequest->profileFields as $field) {
            if (! $profileRequest->{$field}) {
                continue;
            }

            if (is_array($profileRequest->{$field}['status'])) {
                $values = array_filter($profileRequest->{$field}['value'], function ($i) use($field, $profileRequest) {
                    return $profileRequest->{$field}['status'][$i] == Creators::PROFILE_REQUEST_FIELD_STATUS['approved'];
                }, ARRAY_FILTER_USE_KEY);
    
                $creator[$field] = array_merge($creator->{$field} ?? [], $values);
                continue;
            }

            if ($profileRequest->{$field}['status'] != Creators::PROFILE_REQUEST_FIELD_STATUS['approved']) {
                continue;
            }

            $creator[$field] = $profileRequest->{$field}['value'];
        }

        $creator->save();
    }

    private function deleteRejectedPhotos(ProfileRequest $profileRequest): void
    {
        $approved = [];
        $rejected = [];
        foreach ($this->photos['status'] ?? [] as $i => $status) {
            if ($status == Creators::PROFILE_REQUEST_FIELD_STATUS['rejected']) {
                $rejected[] = $profileRequest->photos['value'][$i];
            } else {
                $approved['value'][] = 
                    $profileRequest->photos['value'][$i];
                $approved['status'][] = 
                    $profileRequest->photos['status'][$i];
                $approved['comment'][] = 
                    $profileRequest->photos['comment'][$i];
            }
        }

        $this->imagesService->deleteByIds($rejected);

        $profileRequest->photos = $approved ?: null;
        $profileRequest->save();
    }

    public function saveNotApprovableChanges(Creator $creator, array $data): void
    {
        foreach ($creator->profileFields as $field) {
            if (! array_key_exists($field, $data)) {
                continue;
            }

            if ($field == 'photos') {
                $creator->photos = array_intersect($data['photos'], $creator->photos ?? []);
            }

            if (! $data[$field]) {
                $creator->{$field} = null;
            }
        }

        $creator->save();
    }

    public function deleteProfile(Creator $creator): void
    {
        foreach ($creator->profileFields as $field) {
            $creator->{$field} = null;
        }

        $creator->profile_is_created = false;

        $creator->save();
    }

    public function seed(): int
    {
        if (! $seed = Cache::get('seed')) {
            $seed = rand();
            Cache::put('seed', $seed, 3600 * 2);
        }

        return $seed;
    }

    public function top(int $count, array $filters): Collection
    {
        $seed = $this->seed();

        $query = Creator::with('gallery')->withCount('inFavorites')
            ->showOnSite()
            ->verified();

        if (isset($filters['s'])) {
            $query->search($filters['s']);
        }

        if (isset($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        if (isset($filters['center']) and isset($filters['radius'])) {
            $query->radius($filters['center'], $filters['radius']);
        }

        if (isset($filters['in_favorites'])) {
            $query->whereHas('inFavorites', fn (Builder $query) => $query->where('creator_id', $filters['in_favorites']));
        }
            
        return $query->orderByRaw("rand({$seed})")->limit($count)->get();
    }

    public function mainList(int $page, int $perpage, array $filters = []): Collection
    {
        $top = $this->top($perpage < 10 ? $perpage : 10, $filters);

        $seed = $this->seed();
        $limit = $page == 1 ? $perpage - $top->count() : $perpage;
        $offset = $perpage * ($page - 1) - $top->count();
        
        $query = Creator::with('gallery')->withCount('inFavorites')
            ->whereNotIn('id', $top->pluck('id')->all())
            ->showOnSite();

        if (isset($filters['s'])) {
            $query->search($filters['s']);
        }

        if (isset($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        if (isset($filters['center']) and isset($filters['radius'])) {
            $query->radius($filters['center'], $filters['radius']);
        }

        if (isset($filters['in_favorites'])) {
            $query->whereHas('inFavorites', fn (Builder $query) => $query->where('creator_id', $filters['in_favorites']));
        }
        
        $creators = $query->orderByRaw("rand({$seed})")
            ->limit($limit)
            ->offset($offset)
            ->get();

        return $page == 1 ? $top->merge($creators) : $creators;
    } 

    public function mainListTotalCount(array $filters = []): int
    {
        $query = Creator::showOnSite();

        if (isset($filters['s'])) {
            $query->search($filters['s']);
        }

        if (isset($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        if (isset($filters['center']) and isset($filters['radius'])) {
            $query->radius($filters['center'], $filters['radius']);
        }

        if (isset($filters['in_favorites'])) {
            $query->whereHas('inFavorites', fn (Builder $query) => $query->where('creator_id', $filters['in_favorites']));
        }

        return $query->count();
    } 

    public function recommends(
        int $count, 
        array $exclude = [], 
        array $filters = [], 
        int $level = 1
    ): Collection
    {        
        $query = Creator::with('gallery')->showOnSite();

        if ($exclude) {
            $query->whereNotIn('id', $exclude);
        }

        if (isset($filters['s'])) {
            $query->search($filters['s']);
        }

        if (isset($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        if (isset($filters['center']) and isset($filters['radius'])) {
            $query->radius($filters['center'], $filters['radius']);
        }
        
        $recommends = $query->inRandomOrder()->limit($count)->get();

        if ($recommends->count() < $count and $level == 1) {
            $count = $count - $recommends->count();
            $exclude = [...$exclude, ...$recommends->pluck('id')];

            $recommends = $recommends->merge($this->recommends(
                $count,  
                $exclude,
                [],
                $level + 1
            ));
        }

        return $recommends;
    } 

    public function roulettePair(array $except = []): Collection
    {
        $pair = Creator::with('gallery')
            ->select('id', 'city', 'state', DB::raw('JSON_EXTRACT(photos, CONCAT("$[", FLOOR(RAND() * JSON_LENGTH(photos)), "]")) photos'),)
            ->whereNotIn('id', $except)
            ->showOnSite()
            ->playRoulette()
            ->inRandomOrder()
            ->limit(2)
            ->get();

        return $pair;
    }

    public function topVote(int $count): Collection
    {
        return Creator::withCount('inFavorites')
            ->with('gallery')
            ->showOnSite()
            ->orderBy('votes', 'DESC')
            ->limit($count)
            ->get();
    }
}