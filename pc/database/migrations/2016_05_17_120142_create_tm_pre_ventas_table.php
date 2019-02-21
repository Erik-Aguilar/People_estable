<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmPreVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_pre_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dn', 16);
            $table->string('nombre', 128);
            $table->string('curp', 18);
            $table->string('ext', 8);
            $table->string('r1', 16);
            $table->string('r2', 16);
            $table->string('r3', 16);
            $table->string('agente', 10);
            $table->string('validador', 10);
            $table->boolean('active');
            $table->dateTime('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tm_pre_ventas');
    }
}
