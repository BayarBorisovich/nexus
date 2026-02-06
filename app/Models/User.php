<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Отношение с профилем
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Получить или создать профиль
     */
    public function getOrCreateProfile(): UserProfile
    {
        return $this->profile ?? $this->profile()->create();
    }

    /**
     * Получить URL аватара пользователя
     * Делегирует к профилю, если он существует
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->profile?->avatar_url ?? 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Crect width="200" height="200" fill="%23E5E7EB"/%3E%3Ccircle cx="100" cy="70" r="30" fill="%23A3A3A3"/%3E%3Cpath d="M 50 180 Q 50 130 100 130 Q 150 130 150 180" fill="%23A3A3A3"/%3E%3C/svg%3E';
    }
}
