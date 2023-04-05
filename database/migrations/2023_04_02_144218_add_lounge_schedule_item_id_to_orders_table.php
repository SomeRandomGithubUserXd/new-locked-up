<?php

use App\Models\Lounges\LoungeSchedule;
use App\Models\Lounges\LoungeScheduleItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignIdFor(LoungeScheduleItem::class)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
