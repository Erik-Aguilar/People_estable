<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        #guarda los records del dia (retardos, faltas, descanso, asistencias, faltas por retardos)
        Schema::create('historico_asistencias', function (Blueprint $table) {
            $table->string('usuario',16);
            $table->string('nombre',128);
            $table->datetime('dia');
            $table->string('incidencia',10);
            $table->string('record',20);
            $table->string('id_asis_che',10);
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
        Schema::drop('historico_asistencias');
    }
}
