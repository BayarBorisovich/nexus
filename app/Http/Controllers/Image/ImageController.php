<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Загрузить аватар пользователя
     * POST /avatar
     *
     * Параметры:
     *   - avatar (file): Изображение (JPEG, PNG, GIF, WebP, макс 2MB)
     *
     * Возвращает:
     *   {
     *     "url": "http://localhost/storage/avatars/123.jpg",
     *     "message": "Аватар успешно обновлён!"
     *   }
     */
    public function uploadAvatar()
    {
        // Валидация
        request()->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = Auth::user();

        // 1. Удалить старый аватар если есть
        if ($user->profile && $user->profile->avatar) {
            Storage::disk('public')->delete($user->profile->avatar);
        }

        // 2. Сохранить новый аватар в storage/app/public/avatars/
        // Путь: avatars/123.jpg
        $path = request()->file('avatar')->store('avatars', 'public');

        // 3. Обновить запись в БД
        $user->getOrCreateProfile()->update(['avatar' => $path]);

        // 4. Вернуть ответ с URL
        return response()->json([
            'url' => asset('storage/' . $path),
            'message' => 'Аватар успешно обновлён!'
        ]);
    }

    /**
     * Удалить аватар пользователя
     * DELETE /avatar
     *
     * Возвращает:
     *   {
     *     "message": "Аватар удалён!"
     *   }
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        // 1. Проверить, что аватар существует
        if ($user->profile && $user->profile->avatar) {
            // 2. Удалить файл из хранилища
            Storage::disk('public')->delete($user->profile->avatar);

            // 3. Обновить БД (установить NULL)
            $user->profile->update(['avatar' => null]);
        }

        return response()->json([
            'message' => 'Аватар удалён!'
        ]);
    }

    /**
     * Загрузить изображение для поста (на будущее)
     * POST /image
     */
    public function uploadPostImage()
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'post_id' => 'required|integer',
        ]);

        $postId = request()->input('post_id');
        $path = request()->file('image')
            ->store('posts/' . $postId, 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
            'path' => $path,
            'message' => 'Изображение загружено!'
        ]);
    }

    /**
     * Удалить изображение (на будущее)
     * DELETE /image
     */
    public function deleteImage()
    {
        request()->validate([
            'path' => 'required|string'
        ]);

        $path = request()->input('path');

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        return response()->json([
            'message' => 'Изображение удалено!'
        ]);
    }
}
