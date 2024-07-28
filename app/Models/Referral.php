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

    public function rewaded(): bool
    {
        return ! is_null($this->referral->reward);
    }

    public function reward(float $amout): bool
    {
        $this->reward = $amout;

        return $this->save() and $this->referrer->creditMoney($amout);
    }
}
