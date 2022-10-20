<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateC2bAlatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c2b_alat', function (Blueprint $table) {
            $table->id('id_alat');
            $table->string('nama_alat');
            $table->string('merk');
            $table->string('ukuran');
            $table->string('pabrikan');
            $table->integer('jumlah');
            $table->integer('rusak');
            $table->string('lokasi');
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
        Schema::dropIfExists('c2b_alat');
    }
}
