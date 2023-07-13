<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_aggregator')->default(false);
            $table->boolean('is_service')->default(false);
            $table->string('color')->nullable();
            $table->float('fee')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_sources');
    }
};
