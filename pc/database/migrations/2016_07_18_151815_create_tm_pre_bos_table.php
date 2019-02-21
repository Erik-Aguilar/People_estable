<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmPreBosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_pre_bos', function (Blueprint $table) {
            $table->string('dn', 10);
            $table->string('tipificar', 128);
            $table->string('estatus', 128);
            $table->dateTime('actualizacion');
            $table->date('fecha');
            $table->time('hora');
            $table->string('usuario', 16);
            $table->date('alta');
            $table->date('activacion');
            $table->dateTime('created_at');
            $table->timestamp('updated_at');
            $table->date('ac_interno');
            $table->string('st_interno', 128);
            $table->string('us_p1', 16);
            $table->string('us_p2', 16);
            $table->primary('dn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tm_pre_bos');
    }
}
