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
            'name'     => ['nullable', 'string', 'max:255'],
            'email'    => ['nullable', 'email', 'unique:users,email,' . auth()->id()],
            'username' => ['nullable', 'string', 'unique:users,username,' . auth()->id()],

            'bio'       => ['nullable', 'string', 'max:500'],
            'birthdate' => ['nullable', 'date', 'before_or_equal:' . now()->subYears(13)->format('Y-m-d')],
            'location'  => ['nullable', 'string', 'max:255'],
            'website'   => ['nullable', 'url', 'max:255'],

            // Аватар — добавлена полная валидация
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120', // 5MB в килобайтах
                'dimensions:min_width=50,min_height=50,max_width=2000,max_height=2000',
            ],

            // Социальные ссылки — ограничены допустимые платформы
            'social_links'           => ['nullable', 'array'],
            'social_links.*.platform' => ['required', 'string', 'in:twitter,github,linkedin,instagram'],
            'social_links.*.url'      => ['required', 'url', 'max:255'],

            // Интересы — добавлен лимит количества
            'interests'   => ['nullable', 'array', 'max:10'],
            'interests.*' => ['string', 'max:50'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.unique'    => 'Этот email уже используется.',
            'username.unique' => 'Это имя пользователя уже занято.',

            'birthdate.before_or_equal' => 'Вам должно быть минимум 13 лет.',

            'website.url' => 'Укажите корректный URL.',

            'avatar.image'      => 'Файл должен быть изображением.',
            'avatar.mimes'      => 'Разрешены только форматы: JPG, PNG, WEBP.',
            'avatar.max'        => 'Размер файла не должен превышать 5MB.',
            'avatar.dimensions' => 'Размер изображения: минимум 50×50, максимум 2000×2000 пикселей.',

            'social_links.*.platform.in'       => 'Недопустимая платформа.',
            'social_links.*.url.url'            => 'Укажите корректный URL для социальной сети.',

            'interests.max' => 'Можно указать не более 10 интересов.',
        ];
    }
}
