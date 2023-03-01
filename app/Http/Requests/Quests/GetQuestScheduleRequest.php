<?php

namespace App\Http\Requests\Quests;

use Illuminate\Foundation\Http\FormRequest;

class GetQuestScheduleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['nullable', 'date']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
