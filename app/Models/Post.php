<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'images',
        'text',
        'button_number',
        'status',
        'approve_comment',
        'creator_id',
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

    public function postsOpen(): HasMany
    {
        return $this->hasMany(PostsOpen::class);
    }
}
