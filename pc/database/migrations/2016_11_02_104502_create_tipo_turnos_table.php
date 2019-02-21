<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        #lleva un registro de asistencia del empleado por puesto
        Schema::create('tipo_turnos', function (Blueprint $table) {
            $table->increments('id_tipo_turno');
            $table->string('puesto',50);
            $table->datetime('hora_entrada');
            $table->datetime('hora_salida');
            $table->datetime('tolerancia');
            $table->string('descanso1',4);
            $table->string('descanso2',4);
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
        Schema::drop('tipo_turnos');
    }
}
