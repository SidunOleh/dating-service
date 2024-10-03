<?php

namespace App\Models;

use App\Services\PaymentGateways\PaymentGateway;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;

class Creator extends Authenticatable
{
    use HasFactory, Notifiable, HasJsonRelationships;

    protected $fillable = [
        'email',
        'password',
        'is_banned', 
        'show_on_site',
        'play_roulette', 
        'created_by_admin',
        'photos',
        'name',
        'age',
        'gender',
        'phone',
        'description',
        'profile_email',
        'instagram',
        'telegram',
        'snapchat',
        'onlyfans',
        'whatsapp',
        'zip',
        'state',
        'city',
        'latitude',
        'longitude', 
        'first_name',
        'last_name',
        'birthday',
        'verification_photo',
        'id_photo',
        'street_photo',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_banned'=> 'boolean', 
        'show_on_site'=> 'boolean', 
        'play_roulette'=> 'boolean', 
        'created_by_admin'=> 'boolean', 
        'is_approved' => 'boolean',
        'photos' => 'array',
        'age' => 'integer',
        'latitude' => 'float',
        'longitude'=> 'float', 
        'balance' => 'float',
        'is_verified' => 'boolean',
        'birthday' => 'date',
    ];

    protected $profileFields = [
        'name',
        'age',
        'gender',
        'description',
        'photos',
        'phone',
        'profile_email',
        'instagram',
        'telegram',
        'snapchat',
        'onlyfans',
        'whatsapp',
        'first_name',
        'last_name',
        'birthday',
        'verification_photo',
        'id_photo',
        'street_photo',
        'zip',
        'state',
        'city',
        'latitude',
        'longitude',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $creator) {
            $creator->referral_code = self::generateReferralCode();
            $creator->is_approved = $creator->isApproved();
            $creator->is_verified = $creator->isVerified();
        });

        static::created(function (self $creator) {
            if (
                ($code = Cookie::get('ref') and
                $referrer = self::firstWhere('referral_code', $code)) or 
                ($from = Cookie::get('from') and 
                $referrer = self::find($from))
            ) {
                Referral::create([
                    'referrer_id' => $referrer->id,
                    'referee_id' => $creator->id,
                ]);

                Cookie::queue(Cookie::forget('ref'));
                Cookie::queue(Cookie::forget('from'));
            }
        });

        static::updating(function (self $creator) {
            $creator->is_approved = $creator->isApproved();
            $creator->is_verified = $creator->isVerified();

            if ($photos = array_diff($creator->getOriginal('photos') ?? [], $creator->photos ?? [])) {
                Image::deleteByIds($photos);
            }

            if ($creator->getOriginal('verification_photo') and ! $creator->verification_photo) {
                Image::deleteByIds([$creator->getOriginal('verification_photo')]);
            }

            if ($creator->getOriginal('street_photo') and ! $creator->street_photo) {
                Image::deleteByIds([$creator->getOriginal('street_photo')]);
            }

            if ($creator->getOriginal('id_photo') and ! $creator->id_photo) {
                Image::deleteByIds([$creator->getOriginal('id_photo')]);
            }
        });
    }

    protected function getDefaultGuardName(): string 
    { 
        return 'web';
    }

    public static function generateReferralCode(): string
    {
        do {
            $code = rand(1000000, 9999999);
        } while (self::firstWhere('referral_code', $code));
        
        
        return $code;
    }

    public function isApproved(): bool
    {
        if (
            $this->name and
            $this->age and
            $this->description and
            $this->photos and
            count($this->photos) >= 1 and
            ($this->phone or $this->telegram or $this->whatsapp) and 
            $this->zip and
            $this->state and
            $this->city and
            $this->latitude and
            $this->longitude
        ) {
            return true;
        }

        return false;
    }

    public function isVerified(): bool
    {
        if (
            $this->first_name and
            $this->last_name and
            $this->birthday and
            $this->verification_photo and
            $this->id_photo and
            $this->street_photo
        ) {
            return true;
        }

        return false;
    }

    public function location(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => [
                'zip' => $attributes['zip'],
                'state' => $attributes['state'],
                'city' => $attributes['city'],
                'latitude' => $attributes['latitude'],
                'longitude' => $attributes['longitude'],
            ],
            set: fn (mixed $value) => [
                'zip' => $value['zip'],
                'state' => $value['state'],
                'city' => $value['city'],
                'latitude' => $value['latitude'],
                'longitude' => $value['longitude'],
            ],
        );
    }

    public function gallery(): BelongsToJson
    {
        if ($this->photos) {
            $ids = implode(',', $this->photos);

            return $this->belongsToJson(Image::class, 'photos')->orderByRaw("FIELD(`id`, {$ids})");
        } else {
            return $this->belongsToJson(Image::class, 'photos');
        }
    }

    public function verificationPhoto(): belongsTo
    {
        return $this->belongsTo(Image::class, 'verification_photo');
    }

    public function idPhoto(): belongsTo
    {
        return $this->belongsTo(Image::class, 'id_photo');
    }

    public function streetPhoto(): belongsTo
    {
        return $this->belongsTo(Image::class, 'street_photo');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referralsCount(?string $interval = null): int
    {   
        $visits = $this->referrals();

        if ($interval == 'month') {
            $visits->whereRaw("YEAR(`created_at`) = " . date('Y'))
                ->whereRaw("MONTH(`created_at`) = " . date('m'));
        }

        if ($interval == 'week') {
            $visits->whereRaw("YEAR(`created_at`) = " . date('Y'))
                ->whereRaw("WEEK(`created_at`) = " . date('W') - 1);
        }

        if ($interval == 'day') {
            $visits->whereRaw('YEAR(`created_at`) = ' . date('Y'))
                ->whereRaw('MONTH(`created_at`) = ' . date('m'))
                ->whereRaw('DAY(`created_at`) = ' . date('d'));
        }

        return $visits->count();
    }

    public function referral(): HasOne
    {
        return $this->hasOne(Referral::class, 'referee_id');
    }

    public function hasEnoughMoney(float $amount): bool
    {
        return $amount <= $this->balance;
    }

    public function creditMoney(float $amount): bool
    {
        $this->balance += $amount;

        return $this->save();
    }

    public function debitMoney(float $amount): bool
    {
        if ($this->balance < $amount) {
            return false;
        }

        $this->balance -= $amount;

        return $this->save();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSub(): HasOne
    {
        return $this
            ->hasOne(Subscription::class)
            ->ofMany(['id' => 'max',], fn (Builder $query) => $query->where('status', 'active'));
    }

    public function subscribe(): Subscription
    {
        return Subscription::subscribe($this);
    }

    public function unsubscribe(): bool
    {
        return $this->activeSub->unsubscribe();
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function deposit(string $gateway, float $amount, array $data = []): Transaction
    {
        $paymentGateway = PaymentGateway::create($gateway);

        $transaction = $paymentGateway->deposit($this, $amount, $data);

        return $transaction;
    }

    public function withdraw(string $gateway, float $amount, array $data = []): Transaction
    {
        $paymentGateway = PaymentGateway::create($gateway);

        $transaction = $paymentGateway->withdraw($this, $amount, $data);

        return $transaction;
    }

    public function saveNotApprovableProfileChanges(array $data): bool
    {
        foreach ($this->profileFields as $field) {
            if (! array_key_exists($field, $data)) {
                continue;
            }

            if ($field == 'photos') {
                $this->photos = array_intersect($data['photos'], $this->photos ?? []);
            }

            if (! $data[$field]) {
                $this->{$field} = null;
            }
        }

        return $this->save();
    }

    public function createProfileRequest(array $data): ?ProfileRequest
    {
        $request = [];
        foreach ($this->profileFields as $field) {
            if (
                ! array_key_exists($field, $data) or 
                ! $this->profileFieldChanged($field, $data[$field])
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
                $request['location']['value']['zip'] =
                    $data['zip'];
                $request['location']['value']['state'] =
                    $data['state'];
                $request['location']['value']['city'] = 
                    $data['city'];
                $request['location']['value']['latitude'] = 
                    $data['latitude'];
                $request['location']['value']['longitude'] =    
                    $data['longitude'];
                $request['location']['status'] = 'pending';
                $request['location']['comment'] = '';
            } elseif ($field == 'photos') {
                $photos = array_diff($data['photos'], $this->photos ?? []);
                $request['photos']['value'] = $photos;
                $request['photos']['status'] = 
                    array_fill(0, count($photos), 'pending');
                $request['photos']['comment'] = 
                    array_fill(0, count($photos), '');
            } else {
                $request[$field]['value'] = $data[$field];
                $request[$field]['status'] = 'pending';
                $request[$field]['comment'] = '';
            }
        }

        return $request ? $this->profileRequests()->create($request) : null;
    }

    private function profileFieldChanged(string $field, $value): bool
    {
        if ($field == 'photos') {
            return (bool) array_diff($value, $this->photos ?? []);   
        }

        if ($field == 'birthday') {
            return $this->birthday?->format('Y-m-d') != $value;
        }

        return $this->{$field} != $value;
    }
    
    public function deleteProfile(): bool
    {
        foreach ($this->profileFields as $field) {
            $this->{$field} = null;
        }

        $this->profile_is_created = false;

        return $this->save();
    }

    public function profileRequests(): HasMany
    {
        return $this->hasMany(ProfileRequest::class);
    }

    public function latestProfileRequest(): HasOne
    {
        return $this->hasOne(ProfileRequest::class)->latestOfMany();
    }

    public function secondLastProfileRequest(): ?ProfileRequest
    {
        return ProfileRequest::where('creator_id', $this->id)
            ->orderBy('id', 'DESC')
            ->offset(1)
            ->limit(1)
            ->first();
    }

    public function hasUndoneProfileRequest(): bool
    {
        return (bool) $this->profileRequests()->where('status', 'undone')->first();
    }

    public static function scopeAdminSearch(Builder $query, string $q): void
    {
        $query->whereAny([
            'email',
            'name',
            'description',
            'phone',
            'profile_email',
            'instagram',
            'telegram',
            'snapchat',
            'onlyfans',
            'whatsapp',
            'zip',
            'state',
            'city',
            'first_name',
            'last_name',
        ], 'like', "%{$q}%");
    }

    public static function scopeSearch(Builder $query, string $q): void
    {
        $query->whereAny([
            'name',
            'description',
            'phone',
            'profile_email',
            'instagram',
            'telegram',
            'snapchat',
            'onlyfans',
            'whatsapp',
            'zip',
            'state',
            'city',
        ], 'like', "%{$q}%");
    }

    public static function scopeShowOnSite(Builder $query): void
    {
        $query->where('is_banned', false)
            ->where('is_approved', true)
            ->where('show_on_site', true);
    }   

    public static function scopePlayRoulette(Builder $query): void
    {
        $query->where('play_roulette', true);
    } 

    public static function scopeVerified(Builder $query): void
    {
        $query->where('is_verified', true);
    } 

    public static function scopeRadius(Builder $query, array $center, int $radius): void
    {
        $maxLat = $center['lat'] + rad2deg($radius / 1000 / 6371);
        $minLat = $center['lat'] - rad2deg($radius / 1000 / 6371);
        $maxLng = $center['lng'] + rad2deg(asin($radius / 1000 / 6371) / cos(deg2rad($center['lat'])));
        $minLng = $center['lng'] - rad2deg(asin($radius / 1000 / 6371) / cos(deg2rad($center['lat'])));

        $query->whereBetween('latitude', [$minLat, $maxLat])
            ->whereBetween('longitude', [$minLng, $maxLng])
            ->whereRaw("ST_Distance_Sphere(
                point(?, ?), 
                point(`longitude`, `latitude`)
            ) <= {$radius}", [
                $center['lng'], 
                $center['lat'],
            ]);
    } 

    public static function seed(): int
    {
        if (! $seed = Cache::get('seed')) {
            $seed = rand();
            Cache::put('seed', $seed, 3600 * 2);
        }

        return $seed;
    }

    public static function top(int $count, array $filters): Collection
    {
        $seed = self::seed();

        $query = self::with('gallery')->withCount('inFavorites')
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

    public static function mainList(int $page, int $perpage, array $filters = []): Collection
    {
        $top = self::top($perpage < 10 ? $perpage : 10, $filters);

        $seed = self::seed();
        $limit = $page == 1 ? $perpage - $top->count() : $perpage;
        $offset = $perpage * ($page - 1) - $top->count();
        
        $query = self::with('gallery')->withCount('inFavorites')
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

    public static function mainListTotalCount(array $filters = []): int
    {
        $query = self::showOnSite();

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

    public static function recommends(
        int $count, 
        array $exclude = [], 
        array $filters = [], 
        int $level = 1
    ): Collection
    {        
        $query = self::with('gallery')->showOnSite();

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

            $recommends = $recommends->merge(self::recommends(
                $count,  
                $exclude,
                [],
                $level + 1
            ));
        }

        return $recommends;
    } 

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'favorites', 'creator_id', 'favorite_id')->withTimestamps();
    }

    public function inFavorites(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'favorites', 'favorite_id', 'creator_id')->withTimestamps();
    }

    public function hasInFavorites(int $favoriteId): bool
    {
        return (bool) $this->favorites()->where('favorite_id', $favoriteId)->count();
    }

    public function visits(): HasMany
    {
        return $this->hasMany(ProfileVisit::class);
    }

    public function visitsCount(?string $interval = null): int
    {   
        $visits = $this->visits();

        if ($interval == 'month') {
            $visits->whereRaw("YEAR(`created_at`) = " . date('Y'))
                ->whereRaw("MONTH(`created_at`) = " . date('m'));
        }

        if ($interval == 'week') {
            $visits->whereRaw("YEAR(`created_at`) = " . date('Y'))
                ->whereRaw("WEEK(`created_at`) = " . date('W') - 1);
        }

        if ($interval == 'day') {
            $visits->whereRaw('YEAR(`created_at`) = ' . date('Y'))
                ->whereRaw('MONTH(`created_at`) = ' . date('m'))
                ->whereRaw('DAY(`created_at`) = ' . date('d'));
        }

        return $visits->count();
    }

    public static function roulettePair(): Collection
    {
        $pair = self::with('gallery')
            ->select('id', 'name', 'age', DB::raw('JSON_EXTRACT(photos, CONCAT("$[", FLOOR(RAND() * JSON_LENGTH(photos)), "]")) photos'),)
            ->showOnSite()
            ->playRoulette()
            ->inRandomOrder()
            ->limit(2)
            ->get();

        return $pair;
    }

    public static function topVote(int $count): Collection
    {
        return self::withCount('inFavorites')
            ->with('gallery')
            ->showOnSite()
            ->orderBy('votes', 'DESC')
            ->limit($count)
            ->get();
    }

    public function uploads(): HasMany
    {
        return $this->hasMany(Upload::class);
    }

    public function canUpload(): bool
    {
        $count = $this->uploads()
            ->whereRaw('YEAR(`created_at`) = ' . date('Y'))
            ->whereRaw('MONTH(`created_at`) = ' . date('m'))
            ->whereRaw('DAY(`created_at`) = ' . date('d'))
            ->count();

        return $count < Upload::MAX;
    }

    public function getTransactionList(): array
    {
        $transactions = $this->transactions()
            ->with('details')
            ->get();
        $list = $transactions->filter(function (Transaction $transaction) {
            if ($transaction->details instanceof PlisioInvoice) {
                return $transaction->details->received > 0;
            } else {
                return true;
            }
        });

        $withdrawalRequests = $this->withdrawalRequests()
            ->where('status', 'pending')
            ->with('concrete')
            ->get();
        foreach ($withdrawalRequests as $withdrawalRequest) {
            $list->push($withdrawalRequest);
        }

        $list = $list->sortByDesc('created_at');

        $currencies = [
            'BTC' => 'Bitcoin',
            'ETH' => 'Ethereum',
            'USDT' => 'Tether ERC-20',
            'USDT_TRX' => 'Tether TRC-20',
            'USDC' => 'USDC ERC-20',
            'DOGE' => 'Dogecoin',
            'BNB' => 'BNB Chain',
            'BCH' => 'Bitcoin Cash',
            'BUSD' => 'BUSD (BEP-20)',
        ];
        $formattedList = [];
        foreach ($list as $item) {
            if (
                $item instanceof Transaction and 
                $item->details instanceof PlisioInvoice
            ) {
                $formattedItem['type'] = 'IN';
                $formattedItem['amount'] = $item->details->received;
                $formattedItem['currency'] = $currencies[$item->details->currency];
            } elseif (
                $item instanceof Transaction and 
                $item->details instanceof PlisioWithdrawal
            ) {
                $formattedItem['type'] = 'OUT';
                $formattedItem['amount'] = $item->details->amount;
                $formattedItem['currency'] = $currencies[$item->details->currency];
            } elseif (
                $item instanceof WithdrawalRequest and 
                $item->concrete instanceof PlisioWithdrawalRequest
            ) {
                $formattedItem['type'] = 'WITHDRAWAL REQUEST';
                $formattedItem['amount'] = $item->amount;
                $formattedItem['currency'] = 'Coin';
            }

            $formattedItem['date'] = $item->created_at->format('d.m.Y');

            $formattedList[] = $formattedItem;
        }

        return $formattedList;
    }

    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(WithdrawalRequest::class);
    }
}
