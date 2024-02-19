<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'content',
    ];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_post_likes', 'user_id', 'post_id');
    }
}
