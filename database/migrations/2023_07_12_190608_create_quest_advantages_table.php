<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quest_advantages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Quests\Quest::class)->constrained()->cascadeOnDelete();
            $table->string('name_ru');
            $table->string('name_en')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quest_advantages');
    }
};
