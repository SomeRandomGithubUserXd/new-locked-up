<?php

use App\Models\Locations\Location;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lounge_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Location::class)->constrained()->cascadeOnDelete();
            $table->string('name_ru');
            $table->string('name_en')->nullable();
            $table->string('description_ru');
            $table->string('description_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lounge_locations');
    }
};
