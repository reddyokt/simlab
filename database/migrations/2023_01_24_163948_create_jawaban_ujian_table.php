<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanUjianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_ujian', function (Blueprint $table) {
            $table->id('id_jawaban_ujian');
            $table->foreignId('praktikum_id');
            $table->foreignId ('mahasiswa_id');
            $table->foreignId('ujian_id');
            $table->integer('nilai_ujian_lisan');
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
        Schema::dropIfExists('jawaban_ujian');
    }
}
