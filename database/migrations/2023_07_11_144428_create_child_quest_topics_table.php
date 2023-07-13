<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('child_quest_topics', function (Blueprint $table) {
            $table->id();
            $table->string('name_ru');
            $table->string('name_en')->nullable();
            $table->string('slug');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_quest_topics');
    }
};
