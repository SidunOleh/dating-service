<?php

namespace App\Http\Controllers\Admin\Creators;

use App\Events\CreatorInactivated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Creators\UpdateRequest;
use App\Models\Creator;
use App\Models\ZipCode;
use App\Services\Images\ImagesService;

class UpdateController extends Controller
{
    public function __construct(
        public ImagesService $imagesService
    )
    {
        
    }

    public function __invoke(Creator $creator, UpdateRequest $request)
    {
        $validated = $request->validated();

        if ($validated['is_banned'] and ! $creator->is_banned) {
            CreatorInactivated::dispatch($creator);
        }

        if ($zip = ZipCode::firstWhere('zip', $validated['zip'])) {
            $validated['state'] = $zip->state;
            $validated['city'] = $zip->city;
            $validated['latitude'] = $zip->latitude;
            $validated['longitude'] = $zip->longitude;
        } else {
            $validated['state'] = null;
            $validated['city'] = null;
            $validated['latitude'] = null;
            $validated['longitude'] = null;
        }

        $deletedPhotos = array_diff(
            $creator->photos ?? [],
            $validated['photos'] ?? []
        );
        $this->imagesService->deleteByIds($deletedPhotos);

        $creator->update($validated);

        return response(['message' => 'OK',]);
    }
}
