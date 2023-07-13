<?php

use App\Models\Quests\Quest;
use App\Models\Quests\QuestTopic;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quest_quest_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Quest::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(QuestTopic::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quest_quest_topics');
    }
};
