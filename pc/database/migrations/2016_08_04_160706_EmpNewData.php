<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmpNewData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('empleados',  function (Blueprint $table){
          $table->integer('supervisor')->unsigned();
          $table->date('fecha_ingreso');
          $table->date('fecha_baja');
          $table->text('motivo_baja');
          $table->string('estatus',32);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('empleados',  function (Blueprint $table){
          $table->dropColumn('supervisor');
          $table->dropColumn('fecha_ingreso');
          $table->dropColumn('fecha_baja');
          $table->dropColumn('motivo_baja');
          $table->dropColumn('estatus');
      });
    }
}
