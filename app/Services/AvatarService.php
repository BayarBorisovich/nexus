<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;

class AvatarService
{
    private const DIRECTORY = 'avatars';

    public function __construct(
        private readonly ImageService $imageService
    ) {}

    /**
     * Загрузить/обновить аватар пользователя.
     * Удаляет старый файл, сохраняет новый, обновляет БД.
     */
    public function upload(User $user, UploadedFile $file): void
    {
        $profile = $user->getOrCreateProfile();

        $path = $this->imageService->replace(
            $profile->avatar,
            $file,
            self::DIRECTORY
        );

        $profile->update(['avatar' => $path]);
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

        $this->imageService->delete($profile->avatar);

        $profile->update(['avatar' => null]);
    }
}
