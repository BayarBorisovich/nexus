<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class RegisterUser
{
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $user = User::create($data);

            UserProfile::create([
                'user_id' => $user->id,
            ]);

            event(new Registered($user));

            return $user;
        });
    }

}
