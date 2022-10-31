<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokMhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelompok_mhs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_id');
            $table->foreignId('mahasiswa_id');
            $table->foreignId('periode_id');
            $table->foreignId('modul_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelompok_mhs');
    }
}
