<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_empleados', function (Blueprint $table) {
            $table->increments('id');
            /* Inicio Datos Tabla Candidatos*/
            $table->string('num_empleado',16);
            $table->string('nombre_completo',256);
            $table->string('paterno',64);
            $table->string('materno',64);
            $table->string('nombre',64);
            $table->string('turno',32);
            $table->string('area',32);
            $table->string('puesto',32);
            $table->string('sucursal',16);
            $table->string('supervisor',16);
            $table->string('tipo', 16);
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
            /* Fin Datos Tabla Candidatos*/
            /* Inicio Datos Tabla Empleado*/
            $table->string('user_ext', 16);
            $table->string('user_temp', 16);
            $table->string('user_elx', 8);
            $table->string('ip', 32);
            $table->string('grupo', 32);
            $table->date('fecha_ingreso');
            $table->date('fecha_baja');
            $table->text('motivo_baja');
            $table->string('estatus',32);
            $table->string('observaciones',128);
            /* Fin Datos Tabla Empleado*/
            /* Inicio Datos Tabla Usuario*/
            $table->boolean('active');
            /* Fin Datos Tabla Empleado*/
            /* Inicio Datos Tabla Detalle_empleados*/
            $table->date('imssPlan');
            $table->date('imssFact');
            $table->string('motivoBaja',128);
            $table->string('teamLeader',64);
            $table->string('analistaCalidad',64);
            $table->string('usuarioAuxiliar',64);
            $table->string('posicion',16);
            /* Fin Datos Tabla Detalle_empleados*/
            $table->string('movimiento',16);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('historico_empleados');
    }
}
