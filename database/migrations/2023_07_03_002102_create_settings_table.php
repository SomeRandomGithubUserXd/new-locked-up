<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('show_lang_selector')->default(false);
            $table->text('vk_widget_text')->nullable();
            $table->text('vk_widget_text_en')->nullable();
            $table->string('vk_community_link')->nullable();
            $table->string('fb_link')->nullable();
            $table->string('inst_link')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('main_questions_email')->nullable();
            $table->string('ads_email')->nullable();
            $table->string('commercial_email')->nullable();
            $table->string('copyrights')->nullable();
            $table->string('copyrights_en')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_formatted')->nullable();
            $table->string('address')->nullable();
            $table->string('address_en')->nullable();
            $table->string('ceo_text')->nullable();
            $table->string('ceo_text_en')->nullable();
            $table->boolean('auto_enable_christmas_schedule')->default(false);
            $table->boolean('acquiring_enabled')->default(false);
            $table->boolean('certificates_acquiring_enabled')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
