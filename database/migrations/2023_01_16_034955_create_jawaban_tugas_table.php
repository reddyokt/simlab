<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_tugas', function (Blueprint $table) {
            $table->id('id_jawaban_tugas');
            $table->foreignId('tugas_id');
            $table->foreignId('mahasiswa_id');
            $table->string('file_jawaban');
            $table->integer('nilaitugaspretest')->nullable();
            $table->integer('nilaitugaspostest')->nullable();
            $table->integer('nilailaporan')->nullable();
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
        Schema::dropIfExists('jawaban_tugas');
    }
}
