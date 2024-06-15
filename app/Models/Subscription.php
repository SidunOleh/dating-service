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
        'name',
        'starts_at',
        'ends_at',
        'status',
        'auto_resume',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'auto_resume' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }

    public function activate(): bool
    {
        return $this->update(['status' => 'active',]);
    }

    public function cancel(): bool
    {
        return $this->update(['status' => 'inactive',]);
    }

    public function expired(): bool
    {
        return ! $this->ends_at->gt(now());
    }

    public function resume(): bool
    {
        $this->ends_at = $this->ends_at->addMonths(1);

        return $this->save();
    }
}
