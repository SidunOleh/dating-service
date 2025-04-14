<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balance2Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'creator_id',
        'comment',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }
}
