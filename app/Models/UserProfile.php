<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'avatar',
        'bio',
        'birthdate',
        'location',
        'phone',
        'gender',
        'social_links',
        'interests',
    ];

    protected $casts = [
        'social_links' => 'array',
        'interests' => 'array',
        'birthdate' => 'date',
    ];

    // Accessor для получения полного URL аватара
    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return null;
        }

        return Storage::url($this->avatar);
    }

    // Добавляем avatar_url в JSON ответ
    protected $appends = ['avatar_url'];
}
