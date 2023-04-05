<?php

use App\Models\Lounges\LoungeSchedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lounge_schedule_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LoungeSchedule::class);
            $table->time('time');
            $table->smallInteger('price');
            $table->string('type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lounge_schedule_items');
    }
};
