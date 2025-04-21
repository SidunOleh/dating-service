<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'starts_at',
        'ends_at',
        'status',
        'unsubscribed',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'unsubscribed' => 'boolean',
    ];
    
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }
}
