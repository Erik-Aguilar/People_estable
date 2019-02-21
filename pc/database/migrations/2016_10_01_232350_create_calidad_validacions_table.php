<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalidadValidacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('calidad_validacions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',16);
            $table->string('dn',16);
            $table->date('fecha_validacion');
            $table->date('fecha_monitoreo');
            $table->string('nombre_operador',16);
            $table->string('nombre_supervisor',16);
            $table->string('nombre_validador',16);
            $table->string('por_validacion',4);
            $table->string('validacion_exitosa',4);
            $table->string('saludo_motivo',4);
            $table->string('manejo_objeciones',4);
            $table->string('validacion_datos',4);
            $table->string('escucha_activa',4);
            $table->string('aviso_privacidad',4);
            $table->string('manejo_llamada',4);
            $table->string('error_critico',4);
            $table->string('resultado',4);
            $table->string('observaciones',256);
            $table->string('dictamen',32);
            $table->string('campaign',16);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('calidad_validacions');
    }
}
