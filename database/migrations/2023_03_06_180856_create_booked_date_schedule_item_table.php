<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booked_date_schedule_item', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->bigInteger('schedule_item_id');
            $table->bigInteger('order_id');
            $table->bigInteger('quest_id');
            $table->unique(['date', 'schedule_item_id', 'quest_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booked_date_schedule_item');
    }
};
