<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpPreVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tm_pre_ventas',  function (Blueprint $table){
            $table->string('compania', 16);
            $table->string('estatus', 16);
            $table->string('comentarios', 132);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('tm_pre_ventas',  function (Blueprint $table){
            $table->dropColumn('compania');
            $table->dropColumn('estatus');
            $table->dropColumn('comentarios');
        });
    }
}
