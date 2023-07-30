<?php

namespace App\Http\Requests\Locations;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_ru' => ['required', 'string'],
            'name_en' => ['nullable', 'string'],
            'address_ru' => ['required', 'string'],
            'address_en' => ['nullable', 'string'],
            'show_at_kids_page' => ['nullable', 'bool'],
            'show_at_corporate_parties_page' => ['nullable', 'bool'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'maps' => ['nullable'],
            'latitude' => ['required', 'string'],
            'longitude' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'show_at_kids_page' => define_as_bool($this->show_at_kids_page),
            'show_at_corporate_parties_page' => define_as_bool($this->show_at_corporate_parties_page)
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
