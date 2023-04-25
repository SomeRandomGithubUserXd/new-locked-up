<?php

namespace App\Http\Requests\Modals;

use Illuminate\Foundation\Http\FormRequest;

class AdvertModalRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'enabled' => define_as_bool($this->enabled),
        ]);
    }

    public function rules(): array
    {
        return [
            'title_ru' => ['nullable'],
            'title_en' => ['nullable'],
            'lead_ru' => ['nullable'],
            'lead_en' => ['nullable'],
            'text_ru' => ['nullable'],
            'text_en' => ['nullable'],
            'img_path' => ['nullable'],
            'img_base_url' => ['nullable'],
            'button_text_ru' => ['nullable'],
            'button_text_en' => ['nullable'],
            'button_url_ru' => ['nullable'],
            'button_url_en' => ['nullable'],
            'enabled' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
