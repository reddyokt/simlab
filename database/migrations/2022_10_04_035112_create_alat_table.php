<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alat', function (Blueprint $table) {
            $table->id('id_alat');
            $table->foreignId('lokasi_id');
            $table->foreignId('lemari_id')->nullable();
            $table->enum('jenis',['c2a','c2b']);
            $table->string('kolom')->nullable();
            $table->string('baris')->nullable();
            $table->string('nama_alat');
            $table->string('merk')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('pabrikan')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('rusak')->nullable();
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
        Schema::dropIfExists('alat');
    }
}
