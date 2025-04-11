<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BalancesTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'to',
        'amount',
        'creator_id',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }
}
