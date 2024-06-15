<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway',
        'type',
        'usd_amount',
        'status',
        'details_type',
        'details_id',
        'creator_id',
    ];

    public function details(): MorphTo
    {
        return $this->morphTo();
    }
    
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }
}
