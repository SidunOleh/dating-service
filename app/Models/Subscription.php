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

    public const PRICE = 5;

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }

    public function activate(): bool
    {
        return $this->update(['status' => 'active',]);
    }

    public function inactivate(): bool
    {
        return $this->update(['status' => 'inactive',]);
    }

    public function expired(): bool
    {
        return ! $this->ends_at->gt(now());
    }

    public function unsubscribe(): bool
    {
        return $this->update(['unsubscribed' => true,]);
    }

    public function resume(): bool
    {
        $this->ends_at = $this->ends_at->addMonths(1);

        return $this->save();
    }
}
