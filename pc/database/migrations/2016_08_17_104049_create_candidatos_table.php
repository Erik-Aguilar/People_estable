<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_completo',256);
            
            $table->string('paterno',64);
            $table->string('materno',64);
            $table->string('nombre',64);
            $table->string('turno',32);
            $table->string('area',32);
            $table->string('puesto',32);
            $table->string('estadoCandidato',16);
            $table->string('telefono_cel',16);
            $table->string('telefono_fijo',16);
            $table->string('email',64);
            $table->string('campaign',64);
            $table->string('experiencia',64);
            $table->string('ejec_llamada',64);
            $table->string('estatus_llamada',32);
            $table->datetime('fecha_cita');
            $table->string('ejec_entrevista',128);
            $table->string('estatus_cita',64);
            $table->string('medio_reclutamiento',64);

            $table->date('fecha_nacimiento');
            $table->string('sexo',32);
            $table->string('estado_civil',32);

            $table->string('estado',64);
            $table->string('delegacion',64);
            $table->string('colonia',64);
            $table->string('calle',64);

            $table->string('hijos',16);

            $table->integer('s_base');
            $table->integer('s_complemento');
            $table->integer('bono_asis_punt');
            $table->integer('bono_calidad');
            $table->integer('bono_productividad');
            $table->string('resultado_cita',16);
            $table->date('fecha_capacitacion');
            $table->string('estado_capacitacion',16);
            $table->string('nombre_capacitador',128);
            $table->timestamps('updated_at');
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
        Schema::drop('candidatos');
    }
}
