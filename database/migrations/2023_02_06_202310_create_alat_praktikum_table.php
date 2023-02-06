<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlatPraktikumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alat_praktikum', function (Blueprint $table) {
            $table->id('id_alat_praktikum');
            $table->foreignId('kategori_alat_id');
            $table->foreignId('lokasi_id');
            $table->foreignId('lemari_id');
            $table->string('nama_alat');
            $table->string('merk')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('pabrikan')->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('kolom')->nullable();
            $table->integer('baris')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('alat_praktikum');
    }
}
