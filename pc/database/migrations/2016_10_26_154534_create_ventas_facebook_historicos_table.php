<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasFacebookHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_facebook_historicos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dn',16);
            $table->string('paterno',32);
            $table->string('materno',32);
            $table->string('nombre',32);
            $table->string('operador',32);
            $table->string('sipdv',32);
            $table->string('no_prospecto',32);
            $table->time('llamada');
            $table->string('nip',32);
            $table->string('curp',32);
            $table->string('estatus',32);
            $table->string('ref1',32);
            $table->string('ref2',32);
            $table->string('operador_encuesta',32);
            $table->string('comentarios',256);
            $table->date('fecha');
            $table->string('visto',32);
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
        Schema::drop('ventas_facebook_historicos');
    }
}
