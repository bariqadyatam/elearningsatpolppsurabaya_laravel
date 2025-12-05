<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('kategori_materis', function (Blueprint $table) {
            $table->string('keterangan')->nullable()->after('nama');
        });
    }

    public function down()
    {
        Schema::table('kategori_materis', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }

};
