<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistenciaChecadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        #toda la informacion de movimientos del empleado
        Schema::create('asistencia_checadors', function (Blueprint $table) {
            $table->increments('clave');
            $table->string('departamento', 50);
            $table->string('nombre', 128);
            $table->datetime('fecha_movimiento');
            $table->datetime('entrada');
            $table->datetime('salida_comida');
            $table->datetime('entrada_comida');
            $table->datetime('salida');
            $table->string('horas_laboradas', 2);
            $table->string('horas_extras1', 2);
            $table->string('horas_extras2', 2);
            $table->string('horas_extras3', 2);
            $table->string('retardo_comida', 10);
            $table->string('incidencia_checador', 50);
            $table->string('mensaje', 50);
            $table->string('motivo', 50);
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
        Schema::drop('asistencia_checadors');
    }
}
