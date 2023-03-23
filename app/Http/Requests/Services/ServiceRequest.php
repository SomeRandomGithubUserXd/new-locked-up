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
            'price' => ['nullable', 'numeric'],
            'is_active' => ['nullable', 'bool'],
            'is_inner' => ['nullable', 'bool'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => define_as_bool($this->is_active),
            'is_inner' => define_as_bool($this->is_inner)
        ]);
    }

    public function getUnRefactoredValidatedData()
    {
        $data = $this->validated();
        $data['active'] = $data['is_active'];
        $data['inner'] = $data['is_inner'];
        unset($data['is_inner'], $data['is_active']);
        return $data;
    }

    public function authorize(): bool
    {
        return true;
    }
}
