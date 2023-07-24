<?php

namespace App\Http\Requests\Quests;

use Illuminate\Foundation\Http\FormRequest;

class ChildQuestTopicRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => define_as_bool($this->is_active),
        ]);

    }

    public function rules(): array
    {
        return [
            'name_ru' => ['required', 'string'],
            'name_en' => ['nullable', 'string'],
            'slug' => ['nullable', 'string'],
            'is_active' => ['required', 'bool'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
