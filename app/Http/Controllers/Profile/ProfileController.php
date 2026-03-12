<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService
    ) {}

    /**
     * Показать профиль пользователя
     */
    public function show(User $user): Response
    {
        $user->load('profile');

        return Inertia::render('Profile/Show', [
            'user'         => (new UserResource($user))->resolve(),
            'profile'      => $user->profile ? (new ProfileResource($user->profile))->resolve() : null,
            'isOwnProfile' => Auth::id() === $user->id,
        ]);
    }

    /**
     * Форма редактирования профиля
     */
    public function edit(): Response
    {
        $user = Auth::user();
        $user->load('profile');

        $profile = $user->profile; // Это модель Profile или null

        return Inertia::render('Profile/Edit', [
            'user'    => (new UserResource($user))->resolve(),
            'profile' => $profile
                ? (new ProfileResource($profile))->resolve()
                : [
                    'bio'          => null,
                    'location'     => null,
                    'website'      => null,
                    'birthdate'    => null,
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

        $this->profileService->update(
            $user,
            $request->validated(),
            $request->file('avatar')
        );

        return redirect()
            ->route('profile.show', $user)
            ->with('success', 'Профиль успешно обновлён!');
    }

    /**
     * Удалить аватар пользователя
     */
    public function deleteAvatar(): RedirectResponse
    {
        $this->profileService->deleteAvatar(Auth::user());

        return back()->with('success', 'Аватар удалён!');
    }

    /**
     * Удалить аккаунт пользователя
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $this->profileService->deleteAccount($user);

        return redirect()
            ->route('login')
            ->with('success', 'Аккаунт удалён.');
    }
}
