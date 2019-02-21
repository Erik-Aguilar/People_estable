<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsFromEmpleados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('empleados',  function (Blueprint $table){
            $table->string('turno', 32);
            $table->string('grupo', 32);
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
            $table->dropColumn('turno');
            $table->dropColumn('grupo');
        });
    }
}
