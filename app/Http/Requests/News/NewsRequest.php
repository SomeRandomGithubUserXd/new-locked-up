<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'alias_ru' => ['required'],
            'alias_en' => ['nullable'],
            'is_published' => ['required'],
            'title_ru' => ['required'],
            'title_en' => ['nullable'],
            'announce_ru' => ['required'],
            'announce_en' => ['nullable'],
            'text_ru' => ['required'],
            'text_en' => ['nullable'],
            'h1_ru' => ['required'],
            'h1_en' => ['nullable'],
            'meta_title_ru' => ['nullable'],
            'meta_title_en' => ['nullable'],
            'meta_description_ru' => ['nullable'],
            'meta_description_en' => ['nullable'],
            'meta_keywords_ru' => ['nullable'],
            'meta_keywords_en' => ['nullable'],
            'og_title_ru' => ['nullable'],
            'og_description_ru' => ['nullable'],
            'og_description_en' => ['nullable'],
            'badge_ru' => ['nullable'],
            'badge_en' => ['nullable'],
            'conditions_header_ru' => ['nullable'],
            'conditions_header_en' => ['nullable'],
            'conditions_text_ru' => ['nullable'],
            'conditions_text_en' => ['nullable'],
            'instruction_text_ru' => ['nullable'],
            'instruction_text_en' => ['nullable'],
            'book_button_link_ru' => ['nullable'],
            'book_button_link_en' => ['nullable'],
            'book_button_text_ru' => ['nullable'],
            'book_button_text_en' => ['nullable'],
            'seo_text_ru' => ['nullable'],
            'seo_text_en' => ['nullable'],
            'quests_title_ru' => ['nullable'],
            'quests_title_en' => ['nullable'],
            'quests_attached' => ['nullable', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
