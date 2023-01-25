<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian', function (Blueprint $table) {
            $table->id('id_ujian');
            $table->foreignId('praktikum_id');
            $table->text('uraian_ujian');
            $table->string('soal_ujian');
            $table->enum('jenis_ujian',['Ujian Awal', 'Ujian Akhir']);
            $table->enum('is_active', ['Y','N'])->default('N');
            $table->enum('is_validated', ['Y','N'])->default('N');
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
        Schema::dropIfExists('ujian');
    }
}
