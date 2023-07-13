<?php

use App\Models\Locations\Location;
use App\Models\Quests\QuestTopic;
use App\Models\Schedules\Schedule;
use App\Models\Sticker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('block_id')->nullable();
            $table->string('name_ru');
            $table->string('name_en')->nullable();
            $table->string('alias');
            $table->tinyInteger('theme_id')->default(1);
            $table->smallInteger('duration')->default(60);
            $table->integer('price')->default(0);
            $table->integer('team_price')->default(0);
            $table->smallInteger('age_restriction')->default(0);
            $table->smallInteger('min_players')->default(1);
            $table->smallInteger('max_players')->default(6);
            $table->smallInteger('max_additional_players')->default(2);
            $table->string('video_src')->nullable();
            $table->boolean('is_activated')->default(false);
            $table->foreignIdFor(Schedule::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(QuestTopic::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Location::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('difficulty')->default(1);
            $table->foreignIdFor(Sticker::class)->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('show_at_home')->default(false);
            $table->boolean('is_for_children')->default(false);
            $table->integer('clicks_count')->default(0);
            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_performance_show')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->smallInteger('ord')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quests');
    }
};
