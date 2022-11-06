<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Barang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->foreignId('lokasi_id');
            $table->foreignId('sub_lokasi_id')->nullable();
            $table->string('nama_barang');
            $table->string('merk_barang')->nullable();
            $table->string('ukuran_barang')->nullable();
            $table->string('pabrik_barang')->nullable();
            $table->integer('jumlah_barang');
            $table->integer('barang_rusak')->nullable();
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
        Schema::dropIfExists('barang');
    }
}
