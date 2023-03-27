<?php

namespace App\Http\Requests\Quests;

use Illuminate\Foundation\Http\FormRequest;

class ChildQuestTopicRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'active' => define_as_bool($this->active),
        ]);
    }

    public function rules(): array
    {
        return [
            'name_ru' => ['nullable', 'string'],
            'name_en' => ['nullable', 'string'],
            'slug' => ['nullable', 'string'],
            'active' => ['required', 'bool'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
