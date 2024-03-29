<?php

use App\Models\Quests\Quest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quests_related_quests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Quest::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('related_quest_id')
                ->references('id')
                ->on('quests')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quests_related_quests');
    }
};
