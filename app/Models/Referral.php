<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referee_id',
        'reward',
    ];

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(Creator::class, 'referrer_id');
    }

    public function referee(): BelongsTo
    {
        return $this->belongsTo(Creator::class, 'referee_id');
    }

    public function rewarded(): bool
    {
        return ! is_null($this->reward);
    }

    public function reward(float $amout): void
    {
        $this->referrer->creditMoney($amout);
        
        $this->update(['reward' => $amout]);
    }
}
