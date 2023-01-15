<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembermodulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membermodul', function (Blueprint $table) {
            $table->id('id_membermodul');
            $table->foreignId('modul_id');
            $table->foreignId('alat_id')->nullable();
            $table->foreignId('bahan_id')->nullable();
            $table->integer('jumlah_bahan')->nullable();
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
        Schema::dropIfExists('membermodul');
    }
}
