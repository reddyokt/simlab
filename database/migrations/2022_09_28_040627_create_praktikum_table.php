<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePraktikumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('praktikum', function (Blueprint $table) {
            $table->id('id_praktikum');
            $table->string('nama_kelas');
            $table->foreignId('periode_id');
            $table->foreignId('dosen_id');
            $table->foreignId('kelas_id');
            $table->foreignId('asisten_id');
            $table->enum('is_active',['Y','N']);
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
        Schema::dropIfExists('praktikum');
    }
}
