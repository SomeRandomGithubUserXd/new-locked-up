<?php

namespace App\Http\Requests\Certificates;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'certificate_id' => ['nullable', 'int', 'exists:certificates_data,id']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}