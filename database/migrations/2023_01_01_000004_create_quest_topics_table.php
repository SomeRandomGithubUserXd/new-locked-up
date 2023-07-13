<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quest_topics', function (Blueprint $table) {
            $table->id();
            $table->string('name_ru');
            $table->string('name_en')->nullable();
            $table->string('alias');
            $table->string('h1_ru')->nullable();
            $table->string('h1_en')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();
            $table->string('description_ru')->nullable();
            $table->string('description_en')->nullable();
            $table->string('og_title_ru')->nullable();
            $table->string('og_title_en')->nullable();
            $table->string('og_description_ru')->nullable();
            $table->string('og_description_en')->nullable();
            $table->string('og_type')->nullable();
            $table->string('og_url')->nullable();
            $table->string('seo_ru')->nullable();
            $table->string('seo_en')->nullable();
            $table->string('keywords_ru')->nullable();
            $table->string('keywords_en')->nullable();
            $table->integer('ord')->default(0);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quest_topics');
    }
};
