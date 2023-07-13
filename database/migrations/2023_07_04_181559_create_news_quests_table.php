<?php

use App\Models\News\News;
use App\Models\Quests\Quest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('news_quests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(News::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Quest::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_quests');
    }
};
