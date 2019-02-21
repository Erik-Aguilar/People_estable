<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //esta tabla registra las incidencias del empleado
        Schema::create('incidencias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('empleado', 16);
            $table->string('usuario', 16);
            $table->string('autorizacion', 16);
            $table->string('observaciones', 16);
            $table->string('tipo', 16);
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
        Schema::drop('incidencias');
    }
}
