<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalidadValidadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calidad_validadors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dn',16);
            $table->string('calidad',16);
            $table->string('validador',16);
            $table->date('fecha_val');
            $table->date('fecha_monitoreo');
            $table->string('presentacion',4);
            $table->string('aviso_priv',4);
            $table->string('escucha_activa',4);
            $table->string('captura',4);
            $table->string('manejo_objeciones',4);
            $table->string('error_critico',32);
            $table->string('comentarios',256);
            $table->string('resultado',16);
            $table->string('campaign',16);
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
        Schema::drop('calidad_validadors');
    }
}
