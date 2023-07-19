<?php

use App\Models\Certificates\Certificate;
use App\Models\Checkout;
use App\Models\Lounges\Lounge;
use App\Models\Lounges\LoungeScheduleItem;
use App\Models\Orders\OrderSource;
use App\Models\Quests\Quest;
use App\Models\Sales\Sale;
use App\Models\Schedules\ScheduleItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Quest::class)->constrained()->cascadeOnDelete();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->date('date');
            $table->time('time');
            $table->integer('price');
            $table->integer('additional_players_count')->default(0);
            $table->integer('additional_players_cost')->default(0);
            $table->integer('additional_options_cost')->default(0);
            $table->foreignIdFor(Certificate::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('promo_code')->nullable();
            $table->integer('discount')->default(0);
            $table->integer('pre_paid')->default(0);
            $table->tinyInteger('pre_paid_type')->nullable();
            $table->integer('postpaid')->default(0);
            $table->tinyInteger('postpaid_type')->nullable();
            $table->integer('paid_in_cash')->default(0);
            $table->integer('paid_via_card')->default(0);
            $table->integer('paid_through_acquiring')->default(0);
            $table->integer('paid_through_aggregator')->default(0);
            $table->foreignIdFor(Checkout::class)->nullable()->constrained()->cascadeOnDelete();
            $table->integer('price_total');
            $table->string('option');
            $table->foreignIdFor(OrderSource::class)->nullable()->constrained()->cascadeOnDelete();
            $table->tinyInteger('status')->default(0);
            $table->text('comment')->nullable();
            $table->foreignIdFor(ScheduleItem::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Lounge::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(LoungeScheduleItem::class)->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
