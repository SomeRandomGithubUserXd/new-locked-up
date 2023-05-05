<?php

namespace App\Http\Requests\Quests;

use Illuminate\Foundation\Http\FormRequest;

class QuestPerformanceExperimentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_ru' => ['required'],
            'name_en' => ['nullable'],
            'description_ru' => ['nullable'],
            'description_en' => ['nullable'],
            'full_description_ru' => ['nullable'],
            'full_description_en' => ['nullable'],
            'time_ru' => ['required'],
            'time_en' => ['nullable'],
            'price' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
