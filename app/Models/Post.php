<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Post extends Model
{
    use HasFactory, HasJsonRelationships;

    protected $fillable = [
        'images',
        'text',
        'button_number',
        'status',
        'approve_comment',
        'creator_id',
        'created_at',
    ];

    protected $casts = [
        'images' => 'json',
        'button_number' => 'integer',
    ];  

    public function imagesModels(): BelongsToJson
    {
        return $this->belongsToJson(Image::class, 'images');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }

    public function postsOpens(): HasMany
    {
        return $this->hasMany(PostsOpen::class);
    }

    public function postOpen(): HasOne
    {
        return $this->hasOne(PostsOpen::class)->where('creator_id', Auth::guard('web')->id());
    }

    public function scopeStatus(Builder $query, array $status): void
    {
        if (! $status) {
            return;
        }

        $query->whereIn('status', $status);
    }

    public function openForCurrentUser(): bool
    {
        return $this->postOpen?->post_open ?? false;
    }

    public function buttonClicked(int $number): bool
    {
        return in_array($number, $this->postOpen?->pressed_buttons ?? []);
    }
}
