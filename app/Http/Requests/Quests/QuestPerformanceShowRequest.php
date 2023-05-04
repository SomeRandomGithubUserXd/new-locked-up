<?php

namespace App\Http\Requests\Quests;

use Illuminate\Foundation\Http\FormRequest;

class QuestPerformanceShowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_ru' => ['required'],
            'name_en' => ['nullable'],
            'time_ru' => ['required'],
            'time_en' => ['nullable'],
            'description_ru' => ['nullable'],
            'description_en' => ['nullable'],
            'program_ru' => ['nullable'],
            'program_en' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
