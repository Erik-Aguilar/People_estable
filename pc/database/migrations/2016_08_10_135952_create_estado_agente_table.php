<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoAgenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_agentes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_completo',256);
            $table->string('user_ext');
            $table->datetime('fecha_hora');
            $table->string('estado');
            $table->timestamp('updated_at');
            $table->dateTime('created_at');
            #$table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estado_agentes', function (Blueprint $table) {
            //
        });
    }
}
