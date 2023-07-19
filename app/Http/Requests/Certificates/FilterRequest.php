<?php

namespace App\Http\Requests\Certificates;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search_string' => ['nullable', 'string'],
            'certificate_id' => ['nullable', 'int', 'exists:certificates,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
