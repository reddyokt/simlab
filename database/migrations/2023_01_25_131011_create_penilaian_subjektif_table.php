<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianSubjektifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_subjektif', function (Blueprint $table) {
            $table->id('id_penilaian');
            $table->foreignId('modul_id');
            $table->foreignId('mahasiswa_id');
            $table->foreignId('user_id');
            $table->integer('nilaisubjektif');
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
        Schema::dropIfExists('penilaian_subjektif');
    }
}
