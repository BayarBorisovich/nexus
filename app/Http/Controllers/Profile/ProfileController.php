<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Показать профиль пользователя
     */
    public function show(User $user): Response
    {
        return Inertia::render('Profile/Show', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'avatar_url' => $user->avatar_url,
            ],
            'profile' => $user->profile ? [
                'bio' => $user->profile->bio,
                'location' => $user->profile->location,
                'website' => $user->profile->website,
                'birthdate' => $user->profile->birthdate?->format('Y-m-d'),
                'social_links' => $user->profile->social_links ?? [],
                'interests' => $user->profile->interests ?? [],
                'followers_count' => $user->profile->followers_count,
                'following_count' => $user->profile->following_count,
                'posts_count' => $user->profile->posts_count,
                'avatar_url' => $user->profile->avatar_url,
                'created_at' => $user->profile->created_at->format('d.m.Y'),
            ] : null,
            'isOwnProfile' => Auth::check() && Auth::id() === $user->id,
        ]);
    }

    /**
     * Форма редактирования профиля
     */
    public function edit(): Response
    {
        $user = Auth::user();
        $user->load('profile');

        return Inertia::render('Profile/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
            ],
            'profile' => $user->profile ? [
                'bio' => $user->profile->bio,
                'birthdate' => $user->profile->birthdate?->format('Y-m-d'),
                'location' => $user->profile->location,
                'website' => $user->profile->website,
                'social_links' => $user->profile->social_links ?? [],
                'interests' => $user->profile->interests ?? [],
            ] : [
                'bio' => null,
                'birthdate' => null,
                'location' => null,
                'website' => null,
                'social_links' => [],
                'interests' => [],
            ],
        ]);
    }

    /**
     * Обновить профиль
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $profile = $user->getOrCreateProfile();

        $data = $request->validated();

        // Обновить основные данные пользователя
        $user->update($request->only(['name', 'email', 'username']));

        // Обновить профиль
        $profile->update([
            'bio' => $data['bio'] ?? null,
            'birthdate' => $data['birthdate'] ?? null,
            'location' => $data['location'] ?? null,
            'website' => $data['website'] ?? null,
            'social_links' => $data['social_links'] ?? [],
            'interests' => $data['interests'] ?? [],
        ]);

        return redirect()->route('profile.show', $user)->with('success', 'Профиль успешно обновлён!');
    }

    /**
     * Загрузить аватар
     */
    public function uploadAvatar(): Response
    {
        $request = request();
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->getOrCreateProfile();

        // Удалить старый аватар
        if ($profile->avatar && Storage::disk('public')->exists($profile->avatar)) {
            Storage::disk('public')->delete($profile->avatar);
        }

        // Загрузить новый
        $path = $request->file('avatar')->store('avatars', 'public');
        $profile->update(['avatar' => $path]);

        return back()->with('success', 'Аватар успешно обновлён!');
    }

    /**
     * Удалить аватар
     */
    public function deleteAvatar()
    {
        $user = Auth::user();
        $profile = $user->getOrCreateProfile();

        if ($profile->avatar && Storage::disk('public')->exists($profile->avatar)) {
            Storage::disk('public')->delete($profile->avatar);
            $profile->update(['avatar' => null]);
        }

        return back()->with('success', 'Аватар удалён!');
    }
}
