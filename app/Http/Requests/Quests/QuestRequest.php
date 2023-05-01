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
            'enabled' => define_as_bool($this->enabled),
        ]);
    }

    public function rules(): array
    {
        return [
            'ord' => ['required', 'numeric'],
            'color' => ['nullable'],
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
            'enabled' => ['nullable', 'bool'],
            'price_per_additional_player' => ['nullable', 'integer'],
            'team_price' => ['nullable', 'integer'],
            'discount_percent' => ['nullable', 'integer'],
            'mins_until_slot_is_closed' => ['nullable', 'integer'],
            'duration' => ['nullable', 'integer'],
            'age_limit' => ['nullable', 'integer'],
            'age_restriction' => ['nullable', 'integer'],
            'min_players' => ['nullable', 'integer'],
            'max_players' => ['nullable', 'integer'],
            'min_players_free' => ['nullable', 'integer'],
            'max_players_free' => ['nullable', 'integer'],
            'located_near_subway_station' => ['nullable', 'string'],
            'genre' => ['nullable', 'string'],
            'rating' => ['nullable', 'integer'],
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
            'schedule_id' => ['nullable', 'integer'],
            'location_id' => ['nullable', 'integer'],
            'difficulty' => ['nullable', 'integer'],
            'quest_topic_ids' => ['nullable', 'array'],
            'quest_child_topic_ids' => ['nullable', 'array'],
            'loads' => ['nullable', 'array'],
        ];
    }

    public function getUnRefactoredValidatedData()
    {
        // TODO: Refactor when DB will be restructured
        $edited = [
            'checkout_type_id' => 'checkout_id',
            'theme_id' => 'theme',
            'on_main' => 'show_at_home',
            'is_child' => 'is_for_children',
            'children' => 'show_at_kids_celebration',
            'corporate' => 'show_at_corporate_parties',
            'price_single' => 'price_per_additional_player',
            'price_command' => 'team_price',
            'sale' => 'discount_percent',
            'close_slot_period' => 'mins_until_slot_is_closed',
            'time' => 'duration',
            'metro_ru' => 'located_near_subway_station',
            'genre_ru' => 'genre',
            'ymo_block_title_ru' => 'options_block_header',
            'ymo_block_text_ru' => 'options_block_subheading',
            'yml_block_title_ru' => 'you_may_like_it_section_header',
            'yml_block_text_ru' => 'you_may_like_it_section_subheading',
            'text_above_shedule_ru' => 'schedule_blocks_section_header',
            'text_below_shedule_ru' => 'schedule_section_blocks_bottom_text',
            'complexity' => 'difficulty',
            'page_title_ru' => 'meta_title',
            'page_description_ru' => 'meta_description',
            'page_keywords_ru' => 'meta_keywords',
            'alias' => 'meta_url',
            'og_title_ru' => 'og_title',
            'og_description_ru' => 'og_description',
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
