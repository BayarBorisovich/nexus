<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Models\User;
use App\Services\AvatarService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function __construct(
        private readonly AvatarService $avatarService
    ) {}

    /**
     * Показать профиль пользователя
     */
    public function show(User $user): Response
    {
        return Inertia::render('Profile/Show', [
            'user' => [
                'id'         => $user->id,
                'name'       => $user->name,
                'username'   => $user->username,
                'email'      => $user->email,
                'avatar_url' => $user->avatar_url,
            ],
            'profile' => $user->profile ? [
                'bio'              => $user->profile->bio,
                'location'         => $user->profile->location,
                'website'          => $user->profile->website,
                'birthdate'        => $user->profile->birthdate?->format('Y-m-d'),
                'social_links'     => $user->profile->social_links ?? [],
                'interests'        => $user->profile->interests ?? [],
                'followers_count'  => $user->profile->followers_count,
                'following_count'  => $user->profile->following_count,
                'posts_count'      => $user->profile->posts_count,
                'avatar_url'       => $user->profile->avatar_url,
                'created_at'       => $user->profile->created_at->format('d.m.Y'),
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
                'id'       => $user->id,
                'name'     => $user->name,
                'email'    => $user->email,
                'username' => $user->username,
            ],
            'profile' => $user->profile ? [
                'bio'          => $user->profile->bio,
                'birthdate'    => $user->profile->birthdate?->format('Y-m-d'),
                'location'     => $user->profile->location,
                'website'      => $user->profile->website,
                'social_links' => $user->profile->social_links ?? [],
                'interests'    => $user->profile->interests ?? [],
            ] : [
                'bio'          => null,
                'birthdate'    => null,
                'location'     => null,
                'website'      => null,
                'social_links' => [],
                'interests'    => [],
            ],
        ]);
    }

    /**
     * Обновить профиль
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $profile = $user->getOrCreateProfile();

        $data = $request->validated();

        // Обновить основные данные пользователя — только переданные непустые поля
        $user->update(array_filter($request->only(['name', 'email', 'username'])));

        // Обновить данные профиля
        $profile->update([
            'bio'          => $data['bio'] ?? null,
            'birthdate'    => $data['birthdate'] ?? null,
            'location'     => $data['location'] ?? null,
            'website'      => $data['website'] ?? null,
            'social_links' => $data['social_links'] ?? [],
            'interests'    => $data['interests'] ?? [],
        ]);

        // Обработка аватара через сервис
        if ($request->hasFile('avatar')) {
            $this->avatarService->upload($user, $request->file('avatar'));
        }

        return redirect()
            ->route('profile.show', $user)
            ->with('success', 'Профиль успешно обновлён!');
    }

    /**
     * Удалить аватар пользователя
     */
    public function deleteAvatar(): RedirectResponse
    {
        $this->avatarService->delete(Auth::user());

        return back()->with('success', 'Аватар удалён!');
    }

    /**
     * Удалить аккаунт пользователя
     */
    public function destroy(User $user): RedirectResponse
    {
        // Только сам пользователь может удалить свой аккаунт
        if (Auth::id() !== $user->id) {
            abort(403);
        }

        // Удалить аватар через сервис
        $this->avatarService->delete($user);

        Auth::logout();

        // Профиль удалится каскадно если настроен onDelete cascade в миграции
        $user->delete();

        return redirect()
            ->route('login')
            ->with('success', 'Аккаунт удалён.');
    }
}
