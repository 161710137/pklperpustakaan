<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePinjamkblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjamkbls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nopjkb',10);
            $table->integer('id_agt');
            $table->integer('id_buku');
            $table->date('tgl_pjm');
            $table->date('tgl_hrs_kbl');
            $table->double('denda');
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
        Schema::dropIfExists('pinjamkbls');
    }
}
