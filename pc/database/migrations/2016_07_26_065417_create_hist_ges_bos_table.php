<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistGesBosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hist_ges_bos', function (Blueprint $table) {
          $table->string('dn', 10);
          $table->string('estatus', 128);
          $table->string('usuario', 16);
          $table->text('obs');
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
        Schema::drop('hist_ges_bos');
    }
}
