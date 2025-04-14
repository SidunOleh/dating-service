<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostsOpen extends Model
{
    use HasFactory;

    protected $fillable = [
        'pressed_buttons',
        'post_open',
        'post_id',
        'creator_id',
    ];

    protected $casts = [
        'pressed_buttons' => 'json',
        'post_open' => 'boolean',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }
}
