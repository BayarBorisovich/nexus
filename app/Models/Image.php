<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    protected $fillable = [
        'path',
        'type',
        'user_id',
        'imageable_type',
        'imageable_id'
    ];

    // Отношение с пользователем
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Полиморфное отношение (к чему привязано изображение)
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    // Получить полный URL изображения
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
