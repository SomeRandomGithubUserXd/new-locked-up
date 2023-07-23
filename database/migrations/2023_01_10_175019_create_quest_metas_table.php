<?php

use App\Models\Quests\Quest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quest_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Quest::class);
            $table->string('video_src')->nullable();
            $table->decimal('rating')->default(5);
            $table->string('short_description_ru')->nullable();
            $table->string('short_description_en')->nullable();
            $table->text('full_description_ru')->nullable();
            $table->text('full_description_en')->nullable();
            $table->string('subway_station_ru')->nullable();
            $table->string('subway_station_en')->nullable();
            $table->string('genre_ru')->nullable();
            $table->string('genre_en')->nullable();
            $table->text('schedule_text_ru')->nullable();
            $table->text('schedule_text_en')->nullable();
            $table->text('text_above_schedule_ru')->nullable();
            $table->text('text_above_schedule_en')->nullable();
            $table->text('text_below_schedule_ru')->nullable();
            $table->text('text_below_schedule_en')->nullable();
            $table->text('page_title_ru')->nullable();
            $table->text('page_title_en')->nullable();
            $table->string('h1_ru')->nullable();
            $table->string('h1_en')->nullable();
            $table->text('page_description_ru')->nullable();
            $table->text('page_description_en')->nullable();
            $table->text('page_keywords_ru')->nullable();
            $table->text('page_keywords_en')->nullable();
            $table->string('options_block_header')->nullable();
            $table->string('options_block_subheading')->nullable();
            $table->string('you_may_like_it_section_header')->nullable();
            $table->string('you_may_like_it_section_subheading')->nullable();
            $table->string('schedule_blocks_section_header')->nullable();
            $table->string('schedule_blocks_section_text')->nullable();
            $table->string('schedule_section_blocks_bottom_text')->nullable();
            $table->string('sales_block_header')->nullable();
            $table->string('sales_block_subheading')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_type')->nullable();
            $table->string('og_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quest_meta');
    }
};
