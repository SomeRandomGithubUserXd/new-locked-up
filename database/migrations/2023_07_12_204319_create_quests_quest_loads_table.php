<?php

use App\Models\Quests\Quest;
use App\Models\Quests\QuestLoad;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quests_quest_loads', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Quest::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(QuestLoad::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quests_quest_loads');
    }
};
