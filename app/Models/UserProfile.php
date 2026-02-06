<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'avatar',              // ← АВАТАР СОХРАНЯЕТСЯ ЗДЕСЬ
        'birthdate',
        'location',
        'website',
        'social_links',
        'interests',
        'followers_count',
        'following_count',
        'posts_count',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'social_links' => 'array',
        'interests' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Отношение с пользователем
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить URL аватара - ГЛАВНЫЙ МЕТОД
     * Возвращает либо путь к загруженному файлу, либо дефолтный SVG
     */
    public function getAvatarUrlAttribute(): string
    {
        // Если аватар загружен
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        // Дефолтный SVG аватар (если нет загруженного)
        return 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Crect width="200" height="200" fill="%23E5E7EB"/%3E%3Ccircle cx="100" cy="70" r="30" fill="%23A3A3A3"/%3E%3Cpath d="M 50 180 Q 50 130 100 130 Q 150 130 150 180" fill="%23A3A3A3"/%3E%3C/svg%3E';
    }
}
