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
            'views' => $this->clicks_count,
            'is_active' => $this->is_enabled ? 'Да' : 'Нет',
        ];
    }

    public static function singleItem(Quest $quest): array
    {
        $performanceArtAttributes = [];
//        if($quest->is_performance_show) {
//            $performanceArtAttributes = [
//                'quest_performance_shows' => $quest->questPerformanceShows,
//                'quest_performance_loads' => $quest->questPerformanceLoads,
//                'packages_description_ru' => $quest->packages_description_ru,
//                'packages_description_en' => $quest->page_description_en,
//                'packages_example_ru' => $quest->packages_example_ru,
//                'packages_example_en' => $quest->packages_example_en,
//                'quest_performance_experiments' => $quest->questPerformanceExperiments,
//                'quest_performance_lounges' => $quest->questPerformanceLounges,
//            ];
//        }
//        dd($quest->questMeta->toArray());
        return [
            'id' => $quest->id,
            'ord' => $quest->ord ?? 0,
            'color' => '',
            'name_ru' => $quest->name_ru,
            'name_en' => $quest->name_en,
            'h1_ru' => $quest->questMeta?->h1_ru,
            'h1_en' => $quest->questMeta?->h1_ru,
            'short_description_ru' => $quest->questMeta?->short_description_ru,
            'short_description_en' => $quest->questMeta?->short_description_ru,
            'full_description_ru' => $quest->questMeta?->full_description_ru,
            'full_description_en' => $quest->questMeta?->full_description_en,
            'theme' => $quest->theme_id,
            'checkout_id' => $quest->checkout_id,
            'related_quest_ids' => $quest->relatedQuests()->pluck('quests.id'),
            'block_id' => $quest->block_id,
            'show_at_home' => (bool) $quest->show_at_home,
            'is_popular' => (bool) $quest->is_popular,
            'is_for_children' => (bool) $quest->is_for_children,
            'show_at_kids_celebration' => (bool) $quest->show_at_kids_celebration,
            'show_at_corporate_parties' => (bool) $quest->show_at_corporate_parties,
            'is_enabled' => (bool) $quest->is_enabled,
            'is_performance_show' => (bool) $quest->is_performance_show,
            'price_per_additional_player' => $quest->price_per_additional_player,
            'team_price' => $quest->team_price,
            'discount_percent' => $quest->discount_percent,
            'mins_until_slot_is_closed' => $quest->mins_until_slot_is_closed,
            'duration' => $quest->duration,
            'age_restriction' => $quest->age_restriction,
            'min_players' => $quest->min_players,
            'max_players' => $quest->max_players,
            'subway_station_ru' => $quest->questMeta?->subway_station_ru,
            'genre_ru' => $quest->questMeta?->genre_ru,
            'rating' => $quest->questMeta?->rating,
            'video_src' => $quest->questMeta?->video_src,
            'advantages' => QuestAdvantageResource::collection($quest->questAdvantages)->toArray(\request()),
            'options_block_header' => $quest->questMeta?->options_block_header,
            'options_block_subheading' => $quest->questMeta?->options_block_subheading,
            'options' => QuestOptionResource::collection($quest->questOptions)->toArray(\request()),
            'sales_block_header' => $quest->questMeta?->sales_block_header,
            'sales_block_subheading' => $quest->questMeta?->sales_block_subheading,
            'applied_sales' => $quest->news()->pluck('news.id'),
            'you_may_like_it_section_header' => $quest->questMeta?->you_may_like_it_section_header,
            'you_may_like_it_section_subheading' => $quest->questMeta?->you_may_like_it_section_subheading,
            'you_may_like_it_section_quest_ids' => [],
            'schedule_blocks_section_header' => $quest->questMeta?->schedule_blocks_section_header,
            'schedule_blocks_section_text' => $quest->questMeta?->schedule_blocks_section_text,
            'schedule_section_blocks_bottom_text' => $quest->questMeta?->schedule_section_blocks_bottom_text,
            'schedule_id' => $quest->schedule_id,
            'location_id' => $quest->location_id,
            'difficulty' => $quest->difficulty,
            'quest_topic_ids' => $quest->questTopics->pluck('id'),
            'quest_child_topic_ids' => [],
            'page_title_ru' => $quest->questMeta?->page_title_ru,
            'page_description_ru' => $quest->questMeta?->page_description_ru,
            'page_keywords_ru' => $quest->questMeta?->page_keywords_ru,
            'alias' => $quest->alias,
            'og_title' => $quest->questMeta?->og_title,
            'og_description' => $quest->questMeta?->og_description,
            'og_type' => $quest->questMeta?->og_type,
            'og_url' => $quest->questMeta?->og_url,
            'loads' => $quest->questLoad,
            'sticker_id' => $quest->sticker_id,
            ...$performanceArtAttributes
        ];
    }
}
