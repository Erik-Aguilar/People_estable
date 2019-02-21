<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalidadVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('calidad_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',16);
            $table->string('dn',16);
            $table->date('fecha_venta');
            $table->date('fecha_monitoreo');
            $table->string('script',4);
            $table->string('inf_brindada',4);
            $table->string('captura_datos',4);
            $table->string('sondeo',4);
            $table->string('manejo_objeciones',4);
            $table->string('cierre_venta',4);
            $table->string('transferencia',4);
            $table->string('lenguaje',4);
            $table->string('modulacion_diccion',4);
            $table->string('manejo_llamada',4);
            $table->string('error_critico',4);
            $table->string('resultado',4);
            $table->string('observaciones',256);
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
        Schema::drop('calidad_ventas');
    }
}
