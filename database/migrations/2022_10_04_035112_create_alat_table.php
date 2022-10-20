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
            $table->string('nama_alat');
            $table->string('merk');
            $table->string('ukuran');
            $table->string('pabrikan');
            $table->string('jumlah');
            $table->string('rusak');
            $table->enum('jenis',['c2a','c2b']);
            $table->foreignId('lokasi_id');
            $table->foreignId('lemari_id');
            $table->string('kolom');
            $table->string('baris');
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
