<?php

use App\Enums\UserRoleEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('passport')->nullable();
            $table->string('phone')->nullable();
            $table->integer('role')->default(UserRoleEnum::webmaster->value);
        });
    }

    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
};
