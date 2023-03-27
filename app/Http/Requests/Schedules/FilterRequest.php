<?php

namespace App\Http\Requests\Schedules;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['nullable', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
