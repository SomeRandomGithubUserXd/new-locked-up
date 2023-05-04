<?php

namespace App\Http\Requests\Quests;

use Illuminate\Foundation\Http\FormRequest;

class QuestPerformanceLoadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_ru' => ['required'],
            'name_en' => ['nullable'],
            'time' => ['required'],
            'price_workday' => ['required'],
            'price_weekend' => ['required'],
            'description_ru' => ['nullable'],
            'description_en' => ['nullable'],
            'class_name' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
