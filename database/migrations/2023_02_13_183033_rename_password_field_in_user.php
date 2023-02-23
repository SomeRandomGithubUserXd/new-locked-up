<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePasswordFieldInUser extends Migration
{
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->renameColumn('password_hash', 'password');
        });
    }

    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
}
