<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHistGesbos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('hist_ges_bos',  function (Blueprint $table){
          $table->string('numprocess', 2);
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('hist_ges_bos',  function (Blueprint $table){
          $table->dropColumn('numprocess');
      });
    }
}
