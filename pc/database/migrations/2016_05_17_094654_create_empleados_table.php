<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
          $table->integer('id')->unsigned();
          $table->string('nombre_completo', 256);
          $table->string('nombre', 64);
          $table->string('paterno', 64);
          $table->string('materno', 64);
          $table->string('user_ext', 16);
          $table->string('user_temp', 16);
          $table->string('user_elx', 8);
          $table->string('ip', 32);
          $table->dateTime('created_at');
          $table->timestamp('updated_at');
          $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('empleados');
    }
}
