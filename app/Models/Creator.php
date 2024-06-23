<?php

namespace App\Models;

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

class Creator extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'full_address',
        'country',
        'region',
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

    protected $approvable = [
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
        'full_address',
        'country',
        'region',
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
                $code = Cookie::get('ref') and
                $referrer = self::firstWhere('referral_code', $code)
            ) {
                Referral::create([
                    'referrer_id' => $referrer->id,
                    'referee_id' => $creator->id,
                ]);

                Cookie::queue(Cookie::forget('ref'));
            }
        });

        static::updating(function (self $creator) {
            $creator->is_approved = $creator->isApproved();
            $creator->is_verified = $creator->isVerified();
        });
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
            ($this->phone or $this->telegram or $this->whatsapp)
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

    public function photos(): Collection
    {
        return Image::getByIds($this->photos ?? []);
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

    public function referral(): HasOne
    {
        return $this->hasOne(Referral::class, 'referee_id');
    }

    public function hasEnoughMoney(float $amount): bool
    {
        return $this->balance >= $amount;
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

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->ofMany(
            ['id' => 'max',], 
            fn (Builder $query) => $query->where('status', 'active')
        );
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function createProfileRequest(array $data): ?ProfileRequest
    {
        $request = [];
        foreach ($this->approvable as $field) {
            if (
                ! array_key_exists($field, $data) or 
                ! $this->fieldChanged($field, $data[$field])
            ) {
                continue;
            }

            if (in_array($field, [
                'full_address', 
                'country', 
                'region', 
                'city', 
                'latitude', 
                'longitude',
            ])) {
                $request['location']['value']['full_address'] = 
                    $data['full_address'];
                $request['location']['value']['country'] = 
                    $data['country'];
                $request['location']['value']['region'] =
                    $data['region'];
                $request['location']['value']['city'] = 
                    $data['city'];
                $request['location']['value']['latitude'] = 
                    $data['latitude'];
                $request['location']['value']['longitude'] =    
                    $data['longitude'];
                $request['location']['status'] = 'pending';
                $request['location']['comment'] = '';
                $request['location']['show_rejected'] = true;
            } elseif ($field == 'photos') {
                $photos = array_diff($data['photos'], $this->photos ?? []);
                $request['photos']['value'] = $photos;
                $request['photos']['status'] = 
                    array_fill(0, count($photos), 'pending');
                $request['photos']['comment'] = 
                    array_fill(0, count($photos), '');
                $request['photos']['show_rejected'] = 
                    array_fill(0, count($photos), true);
            } else {
                $request[$field]['value'] = $data[$field];
                $request[$field]['status'] = 'pending';
                $request[$field]['comment'] = '';
                $request[$field]['show_rejected'] = true;
            }
        }

        return $request ? $this->profileRequests()->create($request) : null;
    }

    private function fieldChanged(string $field, $value): bool
    {
        if ($field == 'birthday') {
            return $this->birthday?->format('Y-m-d') != $value;
        }

        if ($field == 'photos') {
            return (bool) array_diff($value, $this->photos ?? []);   
        }

        return $this->{$field} != $value;
    }

    public function profileRequests(): HasMany
    {
        return $this->hasMany(ProfileRequest::class);
    }

    public function latestProfileRequest(): HasOne
    {
        return $this->hasOne(ProfileRequest::class)->latestOfMany();
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
            'full_address',
            'country',
            'region',
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
            'full_address',
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
        $radians = $radius / 1000 / 6371;

        $latMin = $center['lat'] - $radians * (180 / pi());
        $latMax = $center['lat'] + $radians * (180 / pi());
        $lngMin = $center['lng'] - $radians * (180 / pi()) / cos($center['lng'] * pi() / 180);
        $lngMax = $center['lng'] + $radians * (180 / pi()) / cos($center['lng'] * pi() / 180);

        $query->whereBetween('latitude', [$latMin, $latMax])
            ->whereBetween('longitude', [$lngMin, $lngMax])
            ->whereRaw("ST_Distance_Sphere(
                point({$center['lng']}, {$center['lat']}), 
                point(`longitude`, `latitude`)
            ) <= {$radius}");
    } 

    public static function seed(): int
    {
        if (! $seed = Cache::get('seed')) {
            $seed = rand();
            Cache::put('seed', $seed, 60);
        }

        return $seed;
    }

    public static function top(int $count, array $filters): Collection
    {
        $seed = self::seed();

        $query = self::showOnSite()->verified();

        if (isset($filters['s'])) {
            $query->search($filters['s']);
        }

        if (isset($filters['center']) and isset($filters['radius'])) {
            $query->radius($filters['center'], $filters['radius']);
        }
            
        return $query->orderByRaw("rand({$seed})")->limit($count)->get();
    }

    public static function mainList(int $page, int $perpage, array $filters = []): Collection
    {
        $top = self::top($perpage < 10 ? $perpage : 10, $filters);

        $seed = self::seed();
        $limit = $page == 1 ? $perpage - $top->count() : $perpage;
        $offset = $perpage * ($page - 1) - $top->count();
        
        $query = self::whereNotIn('id', $top->pluck('id')->all())->showOnSite();

        if (isset($filters['s'])) {
            $query->search($filters['s']);
        }

        if (isset($filters['center']) and isset($filters['radius'])) {
            $query->radius($filters['center'], $filters['radius']);
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

        if (isset($filters['center']) and isset($filters['radius'])) {
            $query->radius($filters['center'], $filters['radius']);
        }

        return $query->count();
    } 

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'favorites', 'creator_id', 'favorite_id')->withTimestamps();
    }

    public function hasInFavorites(int $favoriteId): bool
    {
        return (bool) $this->favorites()->where('favorite_id', $favoriteId)->count();
    }

    public static function makeVerificationCode(): int
    {
        return rand(100000, 999999);
    }
}
