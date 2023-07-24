<?php

use App\Enums\Certificates\CertificateStatusEnum;
use App\Models\Certificates\Certificate;
use App\Models\Checkout;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('person_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->string('customer_address');
            $table->integer('price');
            $table->integer('delivery_cost')->default(0);
            $table->integer('paid_cash')->default(0);
            $table->integer('paid_card')->default(0);
            $table->integer('paid_online')->default(0);
            $table->dateTime('expires_at');
            $table->tinyInteger('status')->default(0);
            $table->text('comment')->nullable();
            $table->foreignIdFor(Checkout::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Certificate::class)->constrained()->cascadeOnDelete();
            $table->integer('discount')->default(0);
            $table->boolean('is_all_cost')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('person_certificates');
    }
};
