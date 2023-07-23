<?php

namespace App\Models\Quests;

use App\Models\News\News;
use App\Models\Schedules\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quest extends Model
{
    protected $fillable = [
        'block_id',
        'name_ru',
        'name_en',
        'alias',
        'theme_id',
        'duration',
        'price',
        'team_price',
        'price_per_additional_player',
        'discount_percent',
        'age_restriction',
        'min_players',
        'max_players',
        'max_additional_players',
        'mins_until_slot_is_closed',
        'checkout_id',
        'schedule_id',
        'quest_topic_id',
        'location_id',
        'difficulty',
        'sticker_id',
        'show_at_home',
        'is_for_children',
        'show_at_kids_celebration',
        'show_at_corporate_parties',
        'is_enabled',
        'is_performance_show',
        'is_popular',
        'clicks_count',
        'ord',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function relatedQuests(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'quests_related_quests',
            'quest_id',
            'related_quest_id',
        );
    }

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(
            News::class,
            'quests_news',
            'quest_id',
            'news_id',
        );
    }

    public function questTopics(): BelongsToMany
    {
        return $this->belongsToMany(
            QuestTopic::class,
            'quests_quest_topics',
            'quest_id',
            'quest_topic_id',
        );
    }

    public function childQuestTopics(): BelongsToMany
    {
        return $this->belongsToMany(
            ChildQuestTopic::class,
            'quests_child_quest_topics',
            'quest_id',
            'child_quest_topic_id',
        );
    }

    public function questLoad(): belongsToMany
    {
        return $this->belongsToMany(
            QuestLoad::class,
            'quests_quest_loads',
            'quest_id',
            'quest_load_id',
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

    public function questPerformanceLoads(): HasMany
    {
        return $this->hasMany(QuestPerformanceLoad::class, 'quest_id');
    }

    public function questPerformanceExperiments(): HasMany
    {
        return $this->hasMany(QuestPerformanceExperiment::class, 'quest_id');
    }

    public function questPerformanceLounges(): HasMany
    {
        return $this->hasMany(QuestPerformanceLounge::class, 'quest_id');
    }

    public function questMeta(): HasOne
    {
        return $this->hasOne(QuestMeta::class, 'quest_id');
    }
}
