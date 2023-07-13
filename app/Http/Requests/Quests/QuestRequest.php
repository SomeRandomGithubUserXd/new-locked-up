<?php

namespace App\Http\Requests\Quests;

use Illuminate\Foundation\Http\FormRequest;

class QuestRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'show_at_home' => define_as_bool($this->show_at_home),
            'is_popular' => define_as_bool($this->is_popular),
            'is_for_children' => define_as_bool($this->is_for_children),
            'show_at_kids_celebration' => define_as_bool($this->show_at_kids_celebration),
            'show_at_corporate_parties' => define_as_bool($this->show_at_corporate_parties),
            'is_enabled' => define_as_bool($this->is_enabled),
        ]);
    }

    public function rules(): array
    {
        return [
            'ord' => ['required', 'numeric'],
            'checkout_id' => ['nullable', 'integer'],
            'theme' => ['nullable', 'integer'],
            'name_ru' => ['required', 'string'],
            'name_en' => ['nullable', 'string'],
            'h1_ru' => ['nullable', 'string'],
            'h1_en' => ['nullable', 'string'],
            'short_description_ru' => ['nullable', 'string'],
            'short_description_en' => ['nullable', 'string'],
            'related_quest_ids' => ['nullable', 'array'],
            'block_id' => ['nullable', 'integer'],
            'show_at_home' => ['nullable', 'bool'],
            'is_popular' => ['nullable', 'bool'],
            'is_for_children' => ['nullable', 'bool'],
            'show_at_kids_celebration' => ['nullable', 'bool'],
            'show_at_corporate_parties' => ['nullable', 'bool'],
            'is_enabled' => ['nullable', 'bool'],
            'price_per_additional_player' => ['nullable', 'integer'],
            'team_price' => ['nullable', 'integer'],
            'discount_percent' => ['nullable', 'integer'],
            'mins_until_slot_is_closed' => ['nullable', 'integer'],
            'duration' => ['nullable', 'integer'],
            'age_restriction' => ['nullable', 'integer'],
            'min_players' => ['nullable', 'integer'],
            'max_players' => ['nullable', 'integer'],
            'located_near_subway_station' => ['nullable', 'string'],
            'genre' => ['nullable', 'string'],
            'rating' => ['nullable'],
            'advantages' => ['nullable', 'array'],
            'options' => ['nullable', 'array'],
            'options_block_header' => ['nullable', 'string'],
            'options_block_subheading' => ['nullable', 'string'],
            'applied_sales' => ['nullable', 'array'],
            'you_may_like_it_section_header' => ['nullable', 'string'],
            'you_may_like_it_section_subheading' => ['nullable', 'string'],
            'you_may_like_it_section_quest_ids' => ['nullable', 'array'],
            'schedule_blocks_section_header' => ['nullable', 'string'],
            'schedule_blocks_section_text' => ['nullable', 'string'],
            'schedule_section_blocks_bottom_text' => ['nullable', 'string'],
            'schedule_id' => ['required', 'integer'],
            'location_id' => ['nullable', 'integer'],
            'difficulty' => ['nullable', 'integer'],
            'quest_topic_ids' => ['nullable', 'array'],
            'quest_child_topic_ids' => ['nullable', 'array'],
            'loads' => ['nullable', 'array'],
            'sticker_id' => ['nullable', 'int'],
            'packages_description_ru' => ['nullable'],
            'packages_description_en' => ['nullable'],
            'packages_example_ru' => ['nullable'],
            'packages_example_en' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
