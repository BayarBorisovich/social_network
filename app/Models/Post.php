<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'content',
    ];

    protected $withCount = ['like']; // считает лайки постов

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_post_likes', 'user_id', 'post_id');
    }

    public function like() // передаю в $withCount
    {
        return $this->hasMany(UserPostLike::class);
    }
}
