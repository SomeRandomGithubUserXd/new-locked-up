<?php

use App\Models\Checkout;
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
            $table->smallInteger('duration')->default(120);
            $table->integer('price')->default(0);
            $table->integer('team_price')->default(0);
            $table->integer('price_per_additional_player')->default(0);
            $table->integer('discount_percent')->default(0);
            $table->smallInteger('age_restriction')->default(0);
            $table->smallInteger('min_players')->default(1);
            $table->smallInteger('max_players')->default(6);
            $table->smallInteger('max_additional_players')->default(2);
            $table->integer('mins_until_slot_is_closed')->default(1200);
            $table->foreignIdFor(Checkout::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Schedule::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(QuestTopic::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Location::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('difficulty')->default(1);
            $table->foreignIdFor(Sticker::class)->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('show_at_home')->default(false);
            $table->boolean('is_for_children')->default(false);
            $table->boolean('show_at_kids_celebration')->default(false);
            $table->boolean('show_at_corporate_parties')->default(false);
            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_performance_show')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->integer('clicks_count')->default(0);
            $table->smallInteger('ord')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quests');
    }
};
