<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Только сам пользователь может удалить свой аккаунт
     */
    public function delete(User $authUser, User $user): bool
    {
        return $authUser->id === $user->id;
    }
}
