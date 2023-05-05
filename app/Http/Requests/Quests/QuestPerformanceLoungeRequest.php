<?php

namespace App\Http\Requests\Quests;

use Illuminate\Foundation\Http\FormRequest;

class QuestPerformanceLoungeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_ru' => ['required'],
            'name_en' => ['nullable'],
            'description_ru' => ['required'],
            'description_en' => ['nullable'],
            'advantages_ru' => ['nullable'],
            'advantages_en' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
