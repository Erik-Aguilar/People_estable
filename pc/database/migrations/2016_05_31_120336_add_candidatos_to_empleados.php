<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCandidatosToEmpleados extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        /* nombre completo
          cel.
          Tel fijo
          direccion
          fecha de nacimiento
          puesto
          area
         */
        Schema::table('empleados',  function (Blueprint $table){
            $table->string('tipo', 16);
            $table->string('telefono', 16);
            $table->string('celular', 16);
            $table->text('direccion');
            $table->date('fecha_nacimiento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('empleados',  function (Blueprint $table){
            $table->dropColumn('tipo');
            $table->dropColumn('telefono');
            $table->dropColumn('celular');
            $table->dropColumn('direccion');
            $table->dropColumn('fecha_nacimiento');
        });
    }

}
