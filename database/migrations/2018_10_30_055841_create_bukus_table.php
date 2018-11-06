<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBukusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_jb')->unsigned();
            $table->string('judul',100);
            $table->string('pengarang',100);
            $table->string('isbn',25)->unique();
            $table->string('thn_terbit',4);
            $table->string('penerbit',50);
            $table->integer('tersedia');
            $table->timestamps();
        });
    }

    /**
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bukus');
    }
}
