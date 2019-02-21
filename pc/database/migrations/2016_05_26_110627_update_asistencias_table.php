<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asistencias',  function (Blueprint $table){
            $table->dropForeign('asistencias_empleado_foreign');
            $table->dropPrimary('empleado');
            /*$table->primary(['empleado','created_at']);*/
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asistencias',  function (Blueprint $table){
            /*$table->dropPrimary(['empleado','created_at']);*/
            $table->primary('empleado');
            $table->foreign('empleado')
              ->references('id')
              ->on('empleados')
              ->onDelite('cascade');
        });
    }
}
