<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_users', function (Blueprint $table) {
            //$table->increments('id');
            //$table->timestamps();
            $table->dateTime('created_at');
            $table->timestamp('updated_at');
            $table->string('area', 32)->nullable();
            $table->string('puesto', 32)->nullable();
            $table->integer('id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('active_users');
    }
}
