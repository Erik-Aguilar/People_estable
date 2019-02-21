<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObservacionesCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observaciones_candidatos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('primerDia',32);
            $table->string('segundoDia',32);
            $table->string('observaciones',256);
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
        Schema::drop('observaciones_candidatos');
    }
}
