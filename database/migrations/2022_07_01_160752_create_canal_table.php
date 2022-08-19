<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanalTable extends Migration
{

    public function up()
    {
        Schema::create('canal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('canal');
    }
}
