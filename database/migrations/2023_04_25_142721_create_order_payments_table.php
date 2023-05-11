<?php

use App\Models\Orders\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class);
            $table->text('id_from_provider');
            $table->string('order_number')->unique();
            $table->tinyInteger('status')->default(0);
            $table->string('link')->unique();
            $table->integer('sum');
            $table->integer('returned')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
