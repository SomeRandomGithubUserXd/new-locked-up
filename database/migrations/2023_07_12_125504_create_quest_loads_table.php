<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quest_loads', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('page_id');
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();
            $table->integer('price_ru')->nullable();
            $table->integer('price_en')->nullable();
            $table->text('services_ru')->nullable();
            $table->text('services_en')->nullable();
            $table->text('advantages_ru')->nullable();
            $table->text('advantages_en')->nullable();
            $table->text('button_text_ru')->nullable();
            $table->text('button_text_en')->nullable();
            $table->boolean('is_hidden');
            $table->string('title_fdp_ru');
            $table->string('title_fdp_en')->nullable();
            $table->string('type_fdp_ru');
            $table->string('type_fdp_en')->nullable();
            $table->text('description_fdp_ru')->nullable();
            $table->text('description_fdp_en')->nullable();
            $table->string('short_description_fdp_ru')->nullable();
            $table->string('short_description_fdp_en')->nullable();
            $table->text('text_ru')->nullable();
            $table->text('text_en')->nullable();
            $table->integer('price_weekend_ru');
            $table->integer('price_weekend_en')->nullable();
            $table->integer('ord')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quest_loads');
    }
};
