<?php

namespace App\Http\Resources\Users;

use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User\User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role->getName(),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'logged_at' => $this->logged_at?->format('Y-m-d H:i:s'),
        ];
    }

    public static function singleItem(User $user): array
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'name' => $user->name,
            'surname' => $user->surname,
            'patronymic' => $user->patronymic,
            'birth_date' => $user->birth_date,
            'passport' => $user->passport,
            'phone' => $user->phone,
            'role' => $user->role,
            'location_ids' => $user->locations->pluck('id'),
            'password' => '',
            'password_confirmation' => ''
        ];
    }
}
