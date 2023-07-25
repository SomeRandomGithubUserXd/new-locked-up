<?php

namespace App\Http\Requests\Quests;

use Illuminate\Foundation\Http\FormRequest;

class QuestTopicRequest extends FormRequest
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
            'is_active' => ['required', 'bool'],
            'alias' => ['required', 'string'],
            'og_type' => ['nullable', 'string'],
            'og_url' => ['nullable', 'string'],
            'name_ru' => ['required', 'string'],
            'name_en' => ['nullable', 'string'],
            'og_title_ru' => ['nullable', 'string'],
            'og_title_en' => ['nullable', 'string'],
            'og_description_ru' => ['nullable', 'string'],
            'og_description_en' => ['nullable', 'string'],
            'h1_ru' => ['nullable', 'string'],
            'h1_en' => ['nullable', 'string'],
            'title_ru' => ['nullable', 'string'],
            'title_en' => ['nullable', 'string'],
            'seo_ru' => ['nullable', 'string'],
            'seo_en' => ['nullable', 'string'],
            'description_ru' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'keywords_ru' => ['nullable', 'string'],
            'keywords_en' => ['nullable', 'string'],
            'position' => ['nullable', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
