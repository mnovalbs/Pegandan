<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('nama_pasien');
            $table->date('tanggal_lahir');
            $table->string('usia');
            $table->enum('jenis_kelamin'['Laki-laki', 'Perempuan']);
            $table->string('id_kelurahan');
            $table->string('id_indikator');
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
        Schema::dropIfExists('pasiens');
    }
}
