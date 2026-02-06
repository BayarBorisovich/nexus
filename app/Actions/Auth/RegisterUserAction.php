<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            UserProfile::create([
                'user_id' => $user->id,
            ]);

            event(new Registered($user));

            return $user;
        });
    }
}
