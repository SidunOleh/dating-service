<?php

namespace App\Models;

use App\Constants\Referral as ConstantsReferral;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referee_id',
    ];

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(Creator::class, 'referrer_id');
    }

    public function referee(): BelongsTo
    {
        return $this->belongsTo(Creator::class, 'referee_id');
    }

    public function referralRewards(): HasMany
    {
        return $this->hasMany(ReferralReward::class);
    }

    public function referralRewardsCompleted(): HasMany
    {
        return $this->hasMany(ReferralReward::class, 'referral_id')->where('status', ConstantsReferral::REWARD_STATUS['completed']);
    }
}
