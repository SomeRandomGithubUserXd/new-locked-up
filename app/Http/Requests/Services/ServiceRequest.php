<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_ru' => ['required', 'string'],
            'name_en' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
            'is_active' => ['nullable', 'bool'],
            'is_internal' => ['nullable', 'bool'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => define_as_bool($this->is_active),
            'is_internal' => define_as_bool($this->is_internal)
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
