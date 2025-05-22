<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_id',
        'amount',
        'type',
        'status',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function referral(): BelongsTo
    {
        return $this->belongsTo(Referral::class);
    }
}
