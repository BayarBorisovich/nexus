<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUserAction;
use App\Http\Controllers\Controller; // ← ДОБАВЛЕНО
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller // ← ИЗМЕНЕНО: добавлено extends Controller
{
    /**
     * Show registration form
     */
    public function showRegister(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle registration request
     */
    public function register(RegisterRequest $request, RegisterUserAction $registerUser): RedirectResponse
    {
        try {
            $user = $registerUser->execute($request->validated());
            Auth::login($user);

            return redirect()->intended(route('home'))
            ->with('success', 'Добро пожаловать! Вы успешно зарегистрировались.');

        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors([
                    'general' => 'Произошла ошибка при регистрации. Пожалуйста, попробуйте позже.'
                ]);
        }
    }
}
