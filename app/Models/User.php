<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public function friends(): HasMany
    {
        return $this->hasMany(Friend::class);
    }
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function post(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'user_post_likes', 'user_id', 'post_id');
    }
}
