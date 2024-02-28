<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        '_token',
        'name',
        'surname',
        'patronymic',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'gender',
        'about_of_me',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function image(): HasMany
    {
        return $this->hasMany(Image::class);
    }
    public function post(): HasMany
    {
        return $this->hasMany(Post::class);
    }


    public function usersLike(): HasMany // достаем лайки
    {
        return $this->hasMany(UserPostLike::class);
    }

    public function likeIt(): BelongsToMany // ставим лайки
    {
        return $this->belongsToMany(Post::class, 'user_post_likes', 'user_id', 'post_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }

    public function friendPosts(): HasManyThrough
    {
        return $this->hasManyThrough(Post::class, Friend::class, 'user_id', 'user_id', 'id', 'friend_id');
    }
}
