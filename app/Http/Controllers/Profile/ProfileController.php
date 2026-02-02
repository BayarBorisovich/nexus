<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index(): \Inertia\Response
    {
        $user = Auth::user();

        return Inertia::render('Profile/Index', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'bio' => ['nullable', 'string'],
            'birthdate' => ['nullable', 'date'],
            'location' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'gender' => ['nullable', 'in:male,female'],
            'social_links' => ['nullable', 'array'],
            'interests' => ['nullable', 'array'],
        ]);

        auth()->user()->profile()->updateOrCreate(
            ['user_id' => auth()->id()],
            $data
        );

        return back()->with('success', 'Профиль успешно обновлен!');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $user = auth()->user();

        // Удаляем старый аватар если он существует
        $oldAvatar = $user->profile->avatar ?? null;
        if ($oldAvatar && Storage::disk('public')->exists($oldAvatar)) {
            Storage::disk('public')->delete($oldAvatar);
        }

        // Сохраняем новый аватар
        $path = $request->file('avatar')->store('avatars', 'public');

        // Обновляем запись профиля
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            ['avatar' => $path]
        );

        // Получаем обновленный профиль для отправки
        $user->refresh();

        // Возвращаем JSON ответ
        return response()->json([
            'success' => 'Аватар успешно обновлен!',
            'profile' => $user->profile
        ], 200);
    }

    public function deleteAvatar()
    {
        $user = auth()->user();
        $avatar = $user->profile->avatar ?? null;

        if ($avatar && Storage::disk('public')->exists($avatar)) {
            Storage::disk('public')->delete($avatar);

            $user->profile()->update(['avatar' => null]);
        }

        $user->refresh();

        // Возвращаем JSON ответ
        return response()->json([
            'success' => 'Аватар успешно удален!',
            'profile' => $user->profile
        ], 200);
    }
}
