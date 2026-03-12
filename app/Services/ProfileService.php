<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function __construct(
        private readonly AvatarService $avatarService
    ) {}

    /**
     * Обновить данные пользователя и его профиля
     */
    public function update(User $user, array $data, ?UploadedFile $avatar = null): void
    {
        // Обновить основные данные пользователя — только непустые переданные поля
        $userData = array_filter(Arr::only($data, ['name', 'email', 'username']));

        if (!empty($userData)) {
            $user->update($userData);
        }

        // Обновить данные профиля
        $user->getOrCreateProfile()->update(
            Arr::only($data, ['bio', 'birthdate', 'location', 'website', 'social_links', 'interests'])
        );

        // Загрузить аватар если передан
        if ($avatar) {
            $this->avatarService->upload($user, $avatar);
        }
    }

    /**
     * Удалить аватар пользователя
     */
    public function deleteAvatar(User $user): void
    {
        $this->avatarService->delete($user);
    }

    /**
     * Полное удаление аккаунта: аватар, logout, удаление юзера
     * Профиль удаляется каскадно (onDelete cascade в миграции)
     */
    public function deleteAccount(User $user): void
    {
        $this->avatarService->delete($user);

        Auth::logout();

        $user->delete();
    }
}
