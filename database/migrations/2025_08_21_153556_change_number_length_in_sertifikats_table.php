<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->string('number', 50)->change(); // bisa muat sampai 50 karakter
        });
    }

    public function down()
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->string('number', 11)->change(); // balik ke 11 kalau rollback
        });
    }
};
