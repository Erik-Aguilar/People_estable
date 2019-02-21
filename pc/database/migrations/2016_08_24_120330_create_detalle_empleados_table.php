<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->date('imssPlan');
            $table->date('imssFact');
            $table->string('motivoBaja',128);
            $table->string('teamLeader',64);
            $table->string('analistaCalidad',64);
            $table->string('usuarioAuxiliar',64);
            $table->string('posicion',16);
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
        Schema::drop('detalle_empleados');
    }
}
