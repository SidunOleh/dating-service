<?php

namespace App\Models;

use App\Constants\Balances;
use App\Constants\Posts;
use App\Constants\Subscriptions;
use App\Constants\Transactions;
use App\Constants\Uploads;
use App\Notifications\ResetPassword;
use App\Services\ReferralSystem\ReferralSystem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
        'profile_is_created',
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
        'twitter',
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
        'balance_2' => 'float',
        'balance_2_auto' => 'float',
        'is_verified' => 'boolean',
        'birthday' => 'date',
    ];

    public $profileFields = [
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
        'twitter',
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
            $creator->balance_2_auto = Balances::AUTO_CREDIT_AMOUNT;
        });

        static::created(function (self $creator) {
            app()->make(ReferralSystem::class)->createReferral($creator);
        });

        static::updating(function (self $creator) {
            $creator->is_approved = $creator->isApproved();
            $creator->is_verified = $creator->isVerified();
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

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSub(): HasOne
    {
        return $this
            ->hasOne(Subscription::class)
            ->ofMany(['id' => 'max',], fn (Builder $query) => $query->where('status', Subscriptions::STATUS['active']));
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
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
            'id',
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

    public function uploads(): MorphMany
    {
        return $this->morphMany(Upload::class, 'user');
    }

    public function canUpload(): bool
    {
        $count = $this->uploads()
            ->whereRaw('YEAR(`created_at`) = ' . date('Y'))
            ->whereRaw('MONTH(`created_at`) = ' . date('m'))
            ->whereRaw('DAY(`created_at`) = ' . date('d'))
            ->count();

        return $count < Uploads::MAX;
    }

    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(WithdrawalRequest::class);
    }

    public function sendPasswordResetNotification($token): void
    {
        $url = url('/') . "?token={$token}&email={$this->email}";
    
        $this->notify(new ResetPassword($url));
    }

    protected function balance2Total(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return $attributes['balance_2'] + $attributes['balance_2_auto'];
            },
        );
    }

    public function balance2Transactions(): HasMany
    {
        return $this->hasMany(Balance2Transaction::class);
    }

    public function hasEnoughMoney(float $amount, string $balance = 'balance'): bool
    {
        return $amount <= $this->{$balance};
    }

    public function debitMoney(float $amount, string $balance = 'balance'): void
    {
        $this->{$balance} -= $amount;
        $this->save();
    }

    public function creditMoney(float $amount, string $balance = 'balance'): void
    {
        $this->{$balance} += $amount;
        $this->save();
    }

    public function postInPending(): HasOne
    {
        return $this
            ->hasOne(Post::class)
            ->ofMany(['id' => 'max',], fn (Builder $query) => $query->where('status', Posts::STATUS['pending']));
    }

    public function lastPost(): HasOne
    {
        return $this->hasOne(Post::class)->latestOfMany();
    }

    public function withdrawalRequestInPending(): HasOne
    {
        return $this
            ->hasOne(WithdrawalRequest::class)
            ->ofMany(['id' => 'max',], fn (Builder $query) => $query->where('status', Transactions::WITHDRAWAL_REQUEST_STATUS['pending']));
    }

    public function referralRewards(): HasManyThrough
    {
        return $this->hasManyThrough(
            ReferralReward::class,
            Referral::class,
            'referrer_id',
            'referral_id',
        );
    }
}
