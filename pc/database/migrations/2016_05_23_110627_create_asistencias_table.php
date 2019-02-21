<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->integer('empleado')->unsigned();
            $table->integer('tipo_uno')->unsigned();
            $table->integer('tipo_dos')->unsigned();
            $table->text('comentarios');
            $table->dateTime('created_at');
            $table->timestamp('updated_at');
            $table->primary('empleado');
            $table->foreign('empleado')
              ->references('id')
              ->on('empleados')
              ->onDelite('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('asistencias');
    }
}
