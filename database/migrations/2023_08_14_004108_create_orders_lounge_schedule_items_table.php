<?php

use App\Models\Lounges\Lounge;
use App\Models\Lounges\LoungeScheduleItem;
use App\Models\Orders\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders_lounge_schedule_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Lounge::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(LoungeScheduleItem::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders_lounge_schedule_items');
    }
};
