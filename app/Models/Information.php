<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Information extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'surname',
        'patronymic',
        'telephone',
        'city',
        'about_me',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
