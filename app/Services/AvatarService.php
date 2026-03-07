<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AvatarService
{
    private const DISK = 'public';
    private const DIRECTORY = 'avatars';

    /**
     * Загрузить/обновить аватар пользователя.
     * Удаляет старый файл, сохраняет новый, обновляет БД.
     *
     * @return string  Публичный URL нового аватара
     */
    public function upload(User $user, UploadedFile $file): string
    {
        $profile = $user->getOrCreateProfile();

        // Удалить старый файл если есть
        $this->deleteFile($profile->avatar);

        // Сохранить новый файл
        $path = $file->store(self::DIRECTORY, self::DISK);

        // Обновить запись в БД
        $profile->update(['avatar' => $path]);

        return asset('storage/' . $path);
    }

    /**
     * Удалить аватар пользователя.
     * Удаляет файл из хранилища и обнуляет запись в БД.
     */
    public function delete(User $user): void
    {
        $profile = $user->getOrCreateProfile();

        if (! $profile->avatar) {
            return;
        }

        $this->deleteFile($profile->avatar);
        $profile->update(['avatar' => null]);
    }

    /**
     * Удалить файл из хранилища если он существует.
     */
    private function deleteFile(?string $path): void
    {
        if ($path && Storage::disk(self::DISK)->exists($path)) {
            Storage::disk(self::DISK)->delete($path);
        }
    }
}
