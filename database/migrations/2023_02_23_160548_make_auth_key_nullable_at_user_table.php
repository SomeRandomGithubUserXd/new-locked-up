<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->text('auth_key')->nullable()->change();
            $table->text('access_token')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
};
