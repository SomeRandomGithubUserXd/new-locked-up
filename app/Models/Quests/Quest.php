<?php

namespace App\Models\Quests;

use App\Models\News\News;
use App\Models\Schedules\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quest extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'price_single',
        'price_command',
        'alias',
        'sale',
        'time',
        'ord',
        'age_limit',
        'min_players',
        'max_players',
        'video',
        'views',
        'active',
        'activated',
        'schedule_id',
        'topic_id',
        'related',
        'location_id',
        'complexity',
        'age_restriction',
        'stiker_id',
        'questimage_path',
        'questimage_base_url',
        'snippetvkimage_path',
        'snippetfbimage_path',
        'snippetfbimage_base_url',
        'snippetvkimage_base_url',
        'on_main',
        'children',
        'hits_count',
        'preview_image_path',
        'preview_image_base_url',
        'og_img_path',
        'og_img_base_url',
        'og_type',
        'og_url',
        'additional_players_quantity',
        'enabled',
        'performance',
        'name_ru',
        'name_en',
        'short_description_ru',
        'short_description_en',
        'full_description_ru',
        'full_description_en',
        'metro_ru',
        'metro_en',
        'genre_ru',
        'genre_en',
        'shedule_text_ru',
        'shedule_text_en',
        'text_above_shedule_ru',
        'text_above_shedule_en',
        'text_below_shedule_ru',
        'text_below_shedule_en',
        'page_title_ru',
        'page_title_en',
        'snippet_fb_title_ru',
        'snippet_fb_title_en',
        'snippet_fb_description_ru',
        'snippet_fb_description_en',
        'snippet_vk_title_ru',
        'snippet_vk_title_en',
        'snippet_vk_description_ru',
        'snippet_vk_description_en',
        'og_title_ru',
        'og_title_en',
        'og_description_ru',
        'og_description_en',
        'h1_ru',
        'h1_en',
        'page_description_ru',
        'page_description_en',
        'page_keywords_ru',
        'page_keywords_en',
        'color',
        'isDeleted',
        'is_child',
        'ymo_block_title_ru',
        'ymo_block_title_en',
        'ymo_block_text_ru',
        'ymo_block_text_en',
        'ymo_block_hide',
        'yml_block_title_ru',
        'yml_block_title_en',
        'yml_block_text_ru',
        'yml_block_text_en',
        'yml_block_hide',
        'act_block_title_ru',
        'act_block_title_en',
        'act_block_text_ru',
        'act_block_text_en',
        'act_block_hide',
        'alias_en',
        'schedule_preview_image_path',
        'schedule_preview_image_base_url',
        'checkout_type_id',
        'corporate',
        'close_slot_period',
        'additional_email',
        'min_players_free',
        'max_players_free',
        'is_popular',
        'rating',
        'theme_id',
        'quest_image_mobile_path',
        'quest_image_mobile_base_url',
        'is_show',
        'subtitle_ru',
        'subtitle_en',
        'packages_description_ru',
        'packages_description_en',
        'packages_example_ru',
        'packages_example_en',
        'packages_table_ru',
        'packages_table_en',
        'block_id',
        'video_preview_image_path',
        'video_preview_image_base_url',
    ];

    public $timestamps = false;

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function relatedQuests(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'quest_related_quest',
            'quest_id',
            'related_quest_id',
        );
    }

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(
            News::class,
            'quests_news',
            'quests_id',
            'news_id',
        );
    }

    public function questTopics(): BelongsToMany
    {
        return $this->belongsToMany(
            QuestTopic::class,
            'quest_has_rubrics',
            'quest_id',
            'rubrics_id',
        );
    }

    public function questChildTopics(): BelongsToMany
    {
        return $this->belongsToMany(
            QuestChildTopic::class,
            'quests_child_quest_topic',
            'quests_id',
            'child_quest_topic_id',
        );
    }

    public function questLoad(): belongsToMany
    {
        return $this->belongsToMany(
            QuestLoad::class,
            'quests_activities_package',
            'quests_id',
            'activities_package_id',
        );
    }

    public function questAdvantages(): HasMany
    {
        return $this->hasMany(QuestAdvantage::class, 'quest_id');
    }

    public function questOptions(): HasMany
    {
        return $this->hasMany(QuestOption::class, 'quest_id');
    }

    public function questPerformanceShows(): HasMany
    {
        return $this->hasMany(QuestPerformanceShow::class, 'quest_id');
    }
}
