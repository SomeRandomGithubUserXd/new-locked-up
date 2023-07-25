<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['nullable', 'unique:users'],
            'email' => ['required', 'email', 'max:254', 'unique:users'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'name' => ['nullable'],
            'surname' => ['nullable'],
            'patronymic' => ['nullable'],
            'birth_date' => ['nullable', 'date'],
            'passport' => ['nullable'],
            'phone' => ['nullable'],
            'role' => ['required'],
            'location_ids' => ['nullable', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
