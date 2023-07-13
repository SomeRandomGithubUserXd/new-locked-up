<?php

use App\Enums\AppealStatusEnum;
use App\Models\Locations\Location;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appeals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('text')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->foreignIdFor(Location::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('source_url');
            $table->string('captcha_score')->nullable();
            $table->integer('source_id');
            $table->integer('form_id');
            $table->text('admin_comment')->nullable();
            $table->integer('entity_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
};
