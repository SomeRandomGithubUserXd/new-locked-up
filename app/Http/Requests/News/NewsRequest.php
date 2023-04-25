<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'is_published' => (bool)$this->is_published,
        ]);
    }

    public function rules(): array
    {
        return [
            'alias' => ['nullable'],
            'image_path' => ['nullable'],
            'image_base_url' => ['nullable'],
            'is_published' => ['required', 'bool'],
            'created_by' => ['nullable', 'integer'],
            'updated_by' => ['nullable', 'integer'],
            'breadcrums_point_name' => ['nullable'],
            'og_img_path' => ['nullable'],
            'og_img_base_url' => ['nullable'],
            'og_type' => ['nullable'],
            'og_url' => ['nullable'],
            'title_ru' => ['nullable'],
            'title_en' => ['nullable'],
            'meta_title_ru' => ['nullable'],
            'meta_title_en' => ['nullable'],
            'og_title_ru' => ['nullable'],
            'og_title_en' => ['nullable'],
            'og_description_ru' => ['nullable'],
            'og_description_en' => ['nullable'],
            'announce_ru' => ['nullable'],
            'announce_en' => ['nullable'],
            'text_ru' => ['nullable'],
            'text_en' => ['nullable'],
            'h1_ru' => ['nullable'],
            'h1_en' => ['nullable'],
            'meta_description_ru' => ['nullable'],
            'meta_description_en' => ['nullable'],
            'meta_keywords_ru' => ['nullable'],
            'meta_keywords_en' => ['nullable'],
            'alias_en' => ['nullable'],
            'badge_ru' => ['nullable'],
            'badge_en' => ['nullable'],
            'conditions_text_ru' => ['nullable'],
            'conditions_text_en' => ['nullable'],
            'instruction_text_ru' => ['nullable'],
            'instruction_text_en' => ['nullable'],
            'book_button_link_ru' => ['nullable'],
            'book_button_link_en' => ['nullable'],
            'seo_text_ru' => ['nullable'],
            'seo_text_en' => ['nullable'],
            'quests_title_ru' => ['nullable'],
            'quests_title_en' => ['nullable'],
            'conditions_header_ru' => ['required'],
            'conditions_header_en' => ['required'],
            'book_button_text_ru' => ['required'],
            'book_button_text_en' => ['required'],
        ];
    }

    public function getUnRefactoredValidatedData()
    {
        // TODO: Refactor when DB will be restructured
        $edited = [
            'is_published' => 'published',
        ];
        $data = $this->validated();
        foreach ($edited as $key => $value) {
            if (isset($data[$value])) {
                $data[$key] = $data[$value];
            }
            unset($data[$value]);
        }
        return $data;
    }

    public function authorize(): bool
    {
        return true;
    }
}
