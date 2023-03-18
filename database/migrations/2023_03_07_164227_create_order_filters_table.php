<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_filters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->json('quest_ids')->nullable();
            $table->bigInteger('order_id')->nullable();
            $table->json('source_ids')->nullable();
            $table->json('statuses')->nullable();
            $table->json('promo_code_ids')->nullable();
            $table->boolean('with_options_only')->default(false);
            $table->string('order_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filters');
    }
};
