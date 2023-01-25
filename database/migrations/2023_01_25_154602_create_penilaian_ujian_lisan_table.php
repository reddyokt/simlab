<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianUjianLisanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_ujian_lisan', function (Blueprint $table) {
            $table->id('id_penilaian_ujian_lisan');
            $table->foreignid('praktikum_id');
            $table->foreignId('mahasiswa_id');
            $table->integer('nilai_ujian_lisan');
            $table->foreignId('user_id');
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
        Schema::dropIfExists('penilaian_ujian_lisan');
    }
}
