<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
          $table->integer('id')->unsigned();
          //$table->timestamps();
          $table->dateTime('created_at');
          $table->timestamp('updated_at');
          $table->string('password', 60);
          $table->boolean('active');
          $table->string('area', 32)->nullable();
          $table->string('puesto', 32)->nullable();
          $table->primary('id');
          $table->foreign('id')
              ->references('id')
              ->on('empleados')
              ->onDelite('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usuarios');
    }
}
