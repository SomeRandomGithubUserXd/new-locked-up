<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('alias_ru');
            $table->string('alias_en')->nullable();
            $table->boolean('is_published');
            $table->string('title_ru');
            $table->string('title_en')->nullable();
            $table->string('announce_ru');
            $table->string('announce_en')->nullable();
            $table->string('text_ru');
            $table->string('text_en')->nullable();
            $table->string('h1_ru');
            $table->string('h1_en')->nullable();
            $table->string('meta_title_ru')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->string('meta_description_ru')->nullable();
            $table->string('meta_description_en')->nullable();
            $table->string('meta_keywords_ru')->nullable();
            $table->string('meta_keywords_en')->nullable();
            $table->string('og_title_ru')->nullable();
            $table->string('og_description_ru')->nullable();
            $table->string('og_description_en')->nullable();
            $table->text('badge_ru')->nullable();
            $table->text('badge_en')->nullable();
            $table->text('conditions_header_ru')->nullable();
            $table->text('conditions_header_en')->nullable();
            $table->text('conditions_text_ru')->nullable();
            $table->text('conditions_text_en')->nullable();
            $table->text('instruction_text_ru')->nullable();
            $table->text('instruction_text_en')->nullable();
            $table->text('book_button_link_ru')->nullable();
            $table->text('book_button_link_en')->nullable();
            $table->text('book_button_text_ru')->nullable();
            $table->text('book_button_text_en')->nullable();
            $table->text('seo_text_ru')->nullable();
            $table->text('seo_text_en')->nullable();
            $table->text('quests_title_ru')->nullable();
            $table->text('quests_title_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
