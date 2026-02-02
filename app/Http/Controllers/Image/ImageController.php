<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048', // 2MB max
        ]);

        // Удаляем старый аватар
        auth()->user()->images()
            ->where('type', 'avatar')
            ->delete();

        // Сохраняем файл
        $path = $request->file('avatar')
            ->store('avatars/' . auth()->id(), 'public');

        // Создаем запись в БД
        $image = Image::create([
            'path' => $path,
            'type' => 'avatar',
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'url' => $image->url,
            'message' => 'Аватар обновлен'
        ]);
    }

    public function uploadPostImage(Request $request, $postId)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB max
        ]);

        $path = $request->file('image')
            ->store('posts/' . $postId, 'public');

        $image = Image::create([
            'path' => $path,
            'type' => 'post',
            'user_id' => auth()->id(),
            'imageable_type' => 'App\Models\Post',
            'imageable_id' => $postId,
        ]);

        return response()->json([
            'url' => $image->url,
            'id' => $image->id
        ]);
    }

    public function delete(Image $image)
    {
        // Проверяем, что пользователь может удалить
        if ($image->user_id !== auth()->id()) {
            abort(403);
        }

        // Удаляем файл
        Storage::disk('public')->delete($image->path);

        // Удаляем запись из БД
        $image->delete();

        return response()->json(['message' => 'Изображение удалено']);
    }
}
