<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway',
        'amount',
        'status',
        'concrete_type',
        'concrete_id',
        'creator_id',
        'user_id',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function concrete(): MorphTo
    {
        return $this->morphTo();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
