<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_id',
        'link',
        'clicks_limit',
        'clicks_count',
        'status',
    ];

    public function image(): BelongsTo
    {
        return $this->BelongsTo(Image::class);
    }

    public static function scopeActive(Builder $query): void
    {
        $query->where('status', true);
    }
}
