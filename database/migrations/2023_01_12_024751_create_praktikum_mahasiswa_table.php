<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePraktikumMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('praktikum_mahasiswa', function (Blueprint $table) {
            $table->id('id_praktikum_mahasiswa');
            $table->foreignId('mahasiswa_id');
            $table->foreignId('praktikum_id');
            $table->foreignId('kelompok_id')->nullable();
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
        Schema::dropIfExists('praktikum_mahasiswa');
    }
}
