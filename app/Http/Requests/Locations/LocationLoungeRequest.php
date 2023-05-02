<?php

namespace App\Http\Requests\Locations;

use Illuminate\Foundation\Http\FormRequest;

class LocationLoungeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_ru' => ['required'],
            'name_en' => ['nullable'],
            'description_ru' => ['required'],
            'description_en' => ['nullable'],
//            'gallery_id' => ['nullable', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
