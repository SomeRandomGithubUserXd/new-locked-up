<?php

use App\Models\Quests\Quest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->date('review_date');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('rate');
            $table->text('review');
            $table->foreignIdFor(Quest::class)->constrained()->cascadeOnDelete();
            $table->boolean('is_approved');
            $table->string('language');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
