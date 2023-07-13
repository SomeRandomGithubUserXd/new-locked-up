<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quest_quest_loads', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Quests\Quest::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Quests\QuestLoad::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quest_quest_loads');
    }
};
