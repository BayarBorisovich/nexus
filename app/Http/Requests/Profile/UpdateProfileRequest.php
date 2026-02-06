<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'unique:users,email,' . auth()->id()],
            'username' => ['nullable', 'string', 'unique:users,username,' . auth()->id()],
            'bio' => ['nullable', 'string', 'max:500'],
            'birthdate' => ['nullable', 'date', 'before_or_equal:' . now()->subYears(13)->format('Y-m-d')],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'social_links' => ['nullable', 'array'],
            'social_links.*.platform' => ['nullable', 'string', 'max:50'],
            'social_links.*.url' => ['nullable', 'url'],
            'interests' => ['nullable', 'array'],
            'interests.*' => ['nullable', 'string', 'max:50'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'Этот email уже используется.',
            'username.unique' => 'Это имя пользователя уже занято.',
            'birthdate.before_or_equal' => 'Вам должно быть минимум 13 лет.',
            'website.url' => 'Укажите корректный URL.',
        ];
    }
}
