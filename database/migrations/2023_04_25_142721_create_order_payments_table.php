<?php

use App\Enums\Acquiring\AcquiringCurrencyEnum;
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
            $table->text('id_from_provider')->nullable();
            $table->string('order_number')->nullable()->unique();
            $table->tinyInteger('type')->default(0);
            $table->boolean('payment_option')->default(0);
            $table->date('date')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('link')->nullable()->unique();
            $table->integer('sum')->default(0);
            $table->tinyInteger('currency')->default(0);
            $table->integer('returned')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
