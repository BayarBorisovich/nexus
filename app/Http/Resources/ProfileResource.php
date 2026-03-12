<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Поля профиля для передачи во фронтенд.
     * Работает как для существующего профиля, так и для пустой модели (форма создания).
     */
    public function toArray(Request $request): array
    {
        return [
            'bio'             => $this->bio,
            'location'        => $this->location,
            'website'         => $this->website,
            'birthdate'       => $this->birthdate?->format('Y-m-d'),
            'social_links'    => $this->social_links ?? [],
            'interests'       => $this->interests ?? [],
            'followers_count' => $this->followers_count,
            'following_count' => $this->following_count,
            'posts_count'     => $this->posts_count,
            'avatar_url'      => $this->avatar_url,
            'created_at'      => $this->created_at?->format('d.m.Y'),
        ];
    }
}
