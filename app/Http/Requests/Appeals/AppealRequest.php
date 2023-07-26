<?php

namespace App\Http\Requests\Appeals;

use App\Models\Appeal;
use Illuminate\Foundation\Http\FormRequest;

class AppealRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
            'source' => ['nullable', 'string'],
            'form' => ['nullable', 'string'],
            'comment' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
