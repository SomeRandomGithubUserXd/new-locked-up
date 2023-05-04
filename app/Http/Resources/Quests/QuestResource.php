<?php

namespace App\Http\Resources\Quests;

use App\Models\Quests\Quest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Quests\Quest */
class QuestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name_ru,
            'order' => $this->ord,
            'views' => $this->hits_count,
            'is_active' => $this->activated ? 'Да' : 'Нет',
        ];
    }

    public static function singleItem(Quest $quest): array
    {
        $performanceArtAttributes = [];
        if($quest->performance) {
            $performanceArtAttributes = [
                'quest_performance_shows' => $quest->questPerformanceShows,
                'quest_performance_loads' => $quest->questPerformanceLoads,
            ];
        }
        return [
            'id' => $quest->id,
            'ord' => $quest->ord ?? 0,
            'color' => $quest->color,
            'name_ru' => $quest->name_ru,
            'name_en' => $quest->name_en,
            'h1_ru' => $quest->h1_ru,
            'h1_en' => $quest->h1_en,
            'short_description_ru' => $quest->short_description_ru,
            'short_description_en' => $quest->short_description_en,
            'full_description_ru' => $quest->full_description_ru,
            'full_description_en' => $quest->full_description_en,
            'theme' => $quest->theme_id,
            'checkout_id' => $quest->checkout_type_id,
            'related_quest_ids' => $quest->relatedQuests()->pluck('quests.id'),
            'block_id' => $quest->block_id,
            'show_at_home' => (bool) $quest->on_main,
            'is_popular' => (bool) $quest->is_popular,
            'is_for_children' => (bool) $quest->is_child,
            'show_at_kids_celebration' => (bool) $quest->children,
            'show_at_corporate_parties' => (bool) $quest->corporate,
            'enabled' => (bool) $quest->enabled,
            'is_performance_art' => (bool) $quest->performance,
            'price_per_additional_player' => $quest->price_single,
            'team_price' => $quest->price_command,
            'discount_percent' => $quest->sale,
            'mins_until_slot_is_closed' => $quest->close_slot_period,
            'duration' => $quest->time,
            'age_limit' => $quest->age_limit,
            'age_restriction' => $quest->age_restriction,
            'min_players' => $quest->min_players,
            'max_players' => $quest->max_players,
            'min_players_free' => $quest->min_players_free,
            'max_players_free' => $quest->max_players_free,
            'located_near_subway_station' => $quest->metro_ru,
            'genre' => $quest->genre_ru,
            'rating' => $quest->rating,
            'video_src' => "",
            'advantages' => QuestAdvantageResource::collection($quest->questAdvantages)->toArray(\request()),
            'options_block_header' => $quest->ymo_block_title_ru,
            'options_block_subheading' => $quest->ymo_block_text_ru,
            'options' => QuestOptionResource::collection($quest->questOptions)->toArray(\request()),
            'sales_block_header' => $quest->act_block_title_ru,
            'sales_block_subheading' => $quest->act_block_text_ru,
            'applied_sales' => $quest->news()->pluck('news.id'),
            'you_may_like_it_section_header' => $quest->yml_block_title_ru,
            'you_may_like_it_section_subheading' => $quest->yml_block_text_ru,
            'you_may_like_it_section_quest_ids' => [],
            'schedule_blocks_section_header' => $quest->shedule_text_ru,
            'schedule_blocks_section_text' => $quest->text_above_shedule_ru,
            'schedule_section_blocks_bottom_text' => $quest->text_below_shedule_ru,
            'schedule_id' => $quest->schedule_id,
            'location_id' => $quest->location_id,
            'difficulty' => $quest->complexity,
            'quest_topic_ids' => $quest->questTopics->pluck('id'),
            'quest_child_topic_ids' => $quest->questChildTopics->pluck('id'),
            'meta_title' => $quest->page_title_ru,
            'meta_description' => $quest->page_description_ru,
            'meta_keywords' => $quest->page_keywords_ru,
            'meta_url' => $quest->alias,
            'og_title' => $quest->og_title_ru,
            'og_description' => $quest->og_description_ru,
            'og_type' => $quest->og_type,
            'og_url' => $quest->og_url,
            'loads' => $quest->questLoad,
            'sticker_id' => $quest->stiker_id,
            ...$performanceArtAttributes
        ];
    }
}
