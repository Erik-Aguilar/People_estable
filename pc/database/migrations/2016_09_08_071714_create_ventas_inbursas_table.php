<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasInbursasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_inbursas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('telefono',16);
            $table->string('ap_paterno',32);
            $table->string('ap_materno',32);
            $table->string('nombre',32);
            $table->date('fecnacaseg');
            $table->string('sexo',16);
            $table->string('edo_civil',16);
            $table->string('nomconyuge',64);
            $table->date('fecnaccony');
            $table->string('autoriza',32);
            $table->string('parentesco',32);
            $table->string('correo',64);
            $table->string('orig_alta',64);
            $table->string('estatus',16);
            $table->date('fecha_capt');
            $table->string('direccion',64);
            $table->string('vialidad',64);
            $table->string('vivienda',64);
            $table->string('numint',16);
            $table->string('piso',16);
            $table->string('asentamien',64);
            $table->string('colonia',64);
            $table->string('codpos',64);
            $table->string('ciudad',64);
            $table->string('estado',64);
            $table->string('calle_1',64);
            $table->string('calle_2',64);
            $table->string('ref_1',64);
            $table->string('ref_2',64);
            $table->string('rvt',64);
            $table->string('validador',64);
            $table->string('turno',32);
            $table->time('hora_ini');
            $table->time('hora_fin');
            $table->string('num_pisos',16);
            $table->string('cubierta',64);
            $table->string('tipofuente',32);
            $table->string('linea_mar',32);
            $table->integer('usuario');
            $table->timestamp('actualizacion');
            $table->integer('estatus_people');
            $table->string('estatus_people_1',32);
            $table->string('estatus_people_2',32);
            #$table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ventas_inbursas');
    }
}
