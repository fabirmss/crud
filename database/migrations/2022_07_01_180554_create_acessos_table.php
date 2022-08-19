<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcessosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acessos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('minutos');
            $table->dateTime('date');
            $table->unsignedBigInteger('idcanal');
            $table->unsignedBigInteger('idcliente');
            $table->timestamps();

            $table->foreign('idcliente')->references('id')->on('cliente');
            $table->foreign('idcanal')->references('id')->on('canal');
        });
    }


    public function down()
    {
        Schema::dropIfExists('acessos');
    }
}
