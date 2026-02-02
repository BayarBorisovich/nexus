<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUser;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class RegisterController
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
    public function register(RegisterRequest $request, RegisterUser $registerUser): RedirectResponse
    {
        try {
            $user = $registerUser->execute($request->validated());
            Auth::login($user);

            return redirect()->intended('/dashboard')
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
