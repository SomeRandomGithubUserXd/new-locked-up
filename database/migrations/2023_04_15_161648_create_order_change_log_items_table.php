<?php

use App\Models\Orders\Order;
use App\Models\User\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_change_log_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class);
            $table->foreignIdFor(User::class);
            $table->string('change_event');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_change_log_items');
    }
};
