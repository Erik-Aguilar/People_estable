<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">
                <?php echo e(Form::open(['action' => 'RhController@verCandidato',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=> "formulario"
                            ])); ?>


                <div class="row">
                    <div class="col-md-10 col-md-push-2">
                        <h3>
                            <?php echo e($user[0]->nombre); ?> <?php echo e($user[0]->paterno); ?> <?php echo e($user[0]->materno); ?>

                        </h3>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <?php echo e(Form::text('id',$user[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-pull-10">
                        <img src="<?php echo e(asset('storage/1.jpg')); ?>" class="img-responsive" style="width: 150px; height: 120px;">
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <?php echo e(Form::label('Nombre(s) *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->nombre,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Apellido Paterno *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('paterno',$user[0]->paterno,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Apellido Materno','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('materno',$user[0]->materno,array('class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>



                <div class="form-group">
                    <?php echo e(Form::label('En caso de emergencia llamar a','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nom_emergencia1',$user[0]->nom_emergencia1,array('class'=>"form-control", 'placeholder'=>"Nombre del Contacto Emergencia 1"))); ?>                
                        <?php echo e(Form::number('emergencia1',$user[0]->emergencia1,array('class'=>"form-control", 'placeholder'=>"Telefono 1"))); ?>

                        <?php echo e(Form::text('nom_emergencia2',$user[0]->nom_emergencia2,array('class'=>"form-control", 'placeholder'=>"Nombre del Contacto Emergencia 2"))); ?>

                        <?php echo e(Form::number('emergencia2',$user[0]->emergencia2,array('class'=>"form-control", 'placeholder'=>"Telefono 2"))); ?>


                    </div>
                </div>



                 <div class="form-group">
                    <?php echo e(Form::label('Turno *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('turno', [
                        'Matutino' => 'Matutino',
                        'Vespertino' => 'Vespertino',
                        'Tiempo Completo' => 'Tiempo Completo',
                        'Doble Turno' => 'Doble Turno'],
                    $user[0]->turno, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Fecha de entrevista ','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::date('fh',date("Y-m-d", strtotime($user[0]->fecha_cita)),array('class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Sucursal *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('sucursal', [
                        'Sevilla'=>'Sevilla'],
                        $user[0]->sucursal, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Hora de entrevista','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('hora_entrevista', [
                        '09:30:00'=>'09:30 am',
                        '10:30:00'=>'10:30 qm',
                        '11:30:00'=>'11:30 qm',
                        '12:30:00'=>'12:30 qm',
                        '13:30:00'=>'01:30 pm',
                        '14:30:00'=>'02:30 pm',
                        '15:30:00'=>'03:30 pm',
                        '16:30:00'=>'04:30 pm',
                        '17:30:00'=>'05:30 pm',],
                        date("H:i:s", strtotime($user[0]->fecha_cita)), ['class'=>"form-control", 'placeholder'=>"", 'id'=>"Fase1"]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Ejecutivo de Reclutamiento','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('ejecReclutamiento',$reclutadores,
                        $user[0]->ejec_entrevista, ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                     <div class="form-group">
                    <?php echo e(Form::label('Área *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('area', [
                        'Operaciones' => 'Operaciones',
                        'Validación' => 'Validación',
                        'Calidad' => 'Calidad',
                        'Back-Office' => 'Back-Office',
                        'Reclutamiento' => 'Reclutamiento',
                        'Sistemas' => 'Sistemas',
                        'Administración' => 'Administración',
                        'Edición' => 'Edición',
                        'Capacitación' => 'Capacitación',
                        'Direccion General'=>'Direccion General',
                        'Recursos Humanos'=>'Recursos Humanos'],$user[0]->area, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"", "onchange"=>"LlenarSelect()"]  )); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Puesto *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('puesto', [
                     'Asistente administrativo Jr' => 'Asistente administrativo Jr',
                                'Asistente administrativo Sr' => 'Asistente administrativo Sr',
                                'Ayudante general' => 'Ayudante general',
                                'Becario' => 'Becario',
                                'Capturista' => 'Capturista',
                                'Gerente de RRHH' => 'Gerente de RRHH',
                                'Jefe de administracion' => 'Jefe de administracion',
                                'Jefe de reclutamiento' => 'Jefe de reclutamiento',
                                'Personal de mantenimiento' => 'Personal de mantenimiento',
                                'Recepcionista' => 'Recepcionista',
                                'Operador de call center' => 'Operador de call center',
                                'Analista de BO' => 'Analista de BO',
                                'Analista de BO (Consultas y recuperación)' => 'Analista de BO (Consultas y recuperación)',
                                'Analista de BO (Ingresos)' => 'Analista de BO (Ingresos)',
                                'Analista de BO (Proceso 1)' => 'Analista de BO (Proceso 1)',
                                'Analista de BO (Proceso 1) Banamex' => 'Analista de BO (Proceso 1) Banamex',
                                'Analista de BO (Proceso 2)' => 'Analista de BO (Proceso 2)',
                                'Analista de BO (WhatsApp)' => 'Analista de BO (WhatsApp)',
                                'Analista de BO 2 (Ingresos)' => 'Analista de BO 2 (Ingresos)',
                                'Facebook AC' => 'Facebook AC',
                                'Facebook Ventas' => 'Facebook Ventas',
                                'Jefe de BO' => 'Jefe de BO',
                                'Analista de Calidad' => 'Analista de Calidad',
                                'Coordinador de Calidad' => 'Coordinador de Calidad',
                                'Jefe de Calidad' => 'Jefe de Calidad',
                                'Capacitador' => 'Capacitador',
                                'Coordinador de Capacitacion' => 'Coordinador de Capacitacion',
                                'Jefe de capacitacion' => 'Jefe de capacitacion',
                                'Director General' => 'Director General',
                                'Jefe de edicion' => 'Jefe de edicion',
                                'Operador de edicion' => 'Operador de edicion',
                                'Supervisor de edicion' => 'Supervisor de edicion',
                                'Coach' => 'Coach',
                                'Comentarios' => 'Comentarios',
                                'Coordinador' => 'Coordinador',
                                'Gerente' => 'Gerente',
                                'Inbox' => 'Inbox',
                                'Operador de call center' => 'Operador de call center',
                                'Procesos' => 'Procesos',
                                'Supervisor' => 'Supervisor',
                                'Supervisor de BO/Validación' => 'Supervisor de BO/Validación',
                                'Ventas' => 'Ventas',
                                'Becario citas' => 'Becario citas',
                                'Becario entrevistas' => 'Becario entrevistas',
                                'Calidad' => 'Calidad',
                                'Coordinador de reclutamiento' => 'Coordinador de reclutamiento',
                                'Ejecutivo de cuenta citas Jr' => 'Ejecutivo de cuenta citas Jr',
                                'Ejecutivo de cuenta citas Sr' => 'Ejecutivo de cuenta citas Sr',
                                'Ejecutivo de cuenta entrevistas Jr' => 'Ejecutivo de cuenta entrevistas Jr',
                                'Ejecutivo de cuenta entrevistas Sr' => 'Ejecutivo de cuenta entrevistas Sr',
                                'Jefe de Reclutamiento' => 'Jefe de Reclutamiento',
                                'Social media manager' => 'Social media manager',
                                'Ejecutivo de recursos humanos' => 'Ejecutivo de recursos humanos',
                                'Becario de desarrollo' => 'Becario de desarrollo',
                                'Becario soporte' => 'Becario soporte',
                                'Jefe de desarrollo' => 'Jefe de desarrollo',
                                'Jefe de soporte' => 'Jefe de soporte',
                                'Programador 1' => 'Programador 1',
                                'Programador 2' => 'Programador 2',
                                'Programador 3' => 'Programador 3',
                                'Técnico de soporte 1' => 'Técnico de soporte 1',
                                'Técnico de soporte 2' => 'Técnico de soporte 2',
                                'Validador' => 'Validador',
                                'Analista de BO Banamex' => 'Analista de BO Banamex'],
                  $user[0]->puesto, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Teléfono','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::number('telefono_fijo',$user[0]->telefono_fijo,array('class'=>"form-control", 'placeholder'=>"55345678",'id'=>'tel'))); ?>

                    </div>
                </div>
                <div class="form-group">
                   <?php echo e(Form::label('Celular','',array('class'=>"col-sm-2 control-label"))); ?>

                   <div class="col-sm-10">
                       <?php echo e(Form::number('telefono_cel',$user[0]->telefono_cel,array('class'=>"form-control", 'placeholder'=>"5511223344",'id'=>'cel'))); ?>

                   </div>
               </div>
                <div class="form-group">
                    <?php echo e(Form::label('Email','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::email('email',$user[0]->email,array('class'=>"form-control"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Campaña','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::select('campaign', [
                        'TM Prepago' => 'TM Prepago',
                        'TM Pospago' => 'TM Pospago',
                        'Inbursa' => 'Inbursa',
                        'PeopleConnect' => 'PeopleConnect',
                        'PyMES' => 'PyMES',
                        'Facebook'=>'Facebook',
                        'Mapfre'=>'Mapfre',
                        'Conaliteg'=>'Conaliteg',
                        'Auri'=>'Auri',
                        'Bancomer'=>'Bancomer',
                        'Banamex' => 'Banamex',
                        'Back-Office' => 'Back-Office',
                        'Edición' => 'Edición',
                        'Validación' =>'Validación'],
                    $user[0]->campaign, ['class'=>"form-control", 'placeholder'=>""]  )); ?>


                    </div>
                </div>
               <div class="form-group">
                    <?php echo e(Form::label('Experiencia *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('experiencia', [
                        'Sin experiencia' => 'Sin experiencia',
                        'Menos a 6 meses' => 'Menos a 6 meses',
                        '6 a 12 meses' => '6 a 12 meses',
                        'Mayor a 12 meses' => 'Mayor a 12 meses'],
                    $user[0]->experiencia, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>


                <div class="form-group">
                    <?php echo e(Form::label('Estatus de llamada *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('estatusLlamada', [
                        'Cita programada' => 'Cita programada',
                        'No contesta' => 'No contesta',
                        'No le interesa' => 'No le interesa'],
                    $user[0]->estatus_llamada, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>


                <div class="form-group">
                  <?php echo e(Form::label('Medio de reclutamiento *','',array('class'=>"col-sm-2 control-label"))); ?>

                  <div class="col-sm-10">
                    <?php echo e(Form::select('tipoMedioReclutamiento', [
                    'Volanteo' => 'Volanteo',
                    'FaceBook Pagado' => 'FaceBook Pagado',
                    'FaceBook Gratuito' => 'FaceBook Gratuito',
                    'Bolsa de Trabajo' => 'Bolsa de Trabajo',
                    'Invitacion Telefonica' => 'Invitación Telefónica'],
                    $user[0]->tipo_medio_reclutamiento, ['required' => 'required','class'=>"form-control", 'placeholder'=>"","onchange"=>"LlenarMedioReclutamiento()",'id'=>'tipoMedioReclutamiento']  )); ?>

                  </div>
                </div>

                <div class="form-group" style='display: none;' id='medioRecluta'>
                    <?php echo e(Form::label('Bolsas de trabajo *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('medioReclutamiento', [
                        'Mi primer empleo' => 'Mi primer empleo',
                        'Intercambio de carterta' => 'Intercambio de carterta',
                        'Postulados por correo' => 'Postulados por correo',
                        'Periódico' => 'Periódico',
                        'Internet' => 'Internet',
                        'Facebook' => 'Facebook',
                        'Twitter' => 'Twitter',
                        'OCC' => 'OCC',
                        'Talenteca' => 'Talenteca',
                        'Indeed' => 'Indeed',
                        'Bumerang' => 'Bumerang',
                        'Computrabajo' => 'Computrabajo',
                        'Volanteo'=>'Volanteo',
                        'Referido'=>'Referido',
                        'Viva Anuncios'=>'Viva Anuncios',
                        'Facil Trabajo' => 'Facil Trabajo',
                        'Un mejor empleo' => 'Un mejor empleo',
                        'Segunda Mano' => 'Segunda Mano',
                        'Trovit'=>'Trovit',
                        'People-Pro'=>'People-Pro',
                        'UNITEC'=>'UNITEC',
                        'CornerJob'=>'CornerJob',
                        'Jobomas'=>'Jobomas',
                        'EmpleoListo'=>'EmpleoListo',
                        'Otro'=>'Otro'],
                        $user[0]->medio_reclutamiento, ['required' => 'required','class'=>"form-control Fase1", 'placeholder'=>"", 'id'=>"medioReclutamiento"]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-2" style="float:right;">
                        <?php echo e(Form::button('Primera Fase',['class'=>"btn btn-primary", "onClick"=>"Fase_2()"])); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Estatus de cita *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('estatusCita', [
                        'Se presento el candidato' => 'Se presento el candidato',
                        'No se presento el candidato' => 'No se presento el candidato'],
                    $user[0]->estatus_cita, ['required' => 'required', 'class'=>"form-control Fase2", 'placeholder'=>"", 'id'=>"Fase2"]  )); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Fecha de Nacimiento *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::date('fechaNacimiento',$user[0]->fecha_nacimiento,array('required' => 'required', 'class'=>"form-control Fase2", 'placeholder'=>"", 'id'=>"Fase2"))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Sexo *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('sexo', [
                        'Mujer' => 'Mujer',
                        'Hombre' => 'Hombre'],
                    $user[0]->sexo, ['required' => 'required', 'class'=>"form-control Fase2", 'placeholder'=>"", 'id'=>"Fase2"] )); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Estado civil *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('estadoCivil', [
                        'Soltero' => 'Soltero',
                        'Casado' => 'Casado',
                        'Separado' => 'Separado',
                        'Divorciado' => 'Divorciado',
                        'Viudo' => 'Viudo'],
                    $user[0]->estado_civil, ['required' => 'required', 'class'=>"form-control Fase2", 'placeholder'=>"", 'id'=>"Fase2"])); ?>

                    </div>
                </div>


                 <div class="form-group">
                    <?php echo e(Form::label('Estado','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::select('state',$states->prepend(''),$user[0]->estado,['id'=>'state','class'=>'form-control Fase2','placeholder'=>'Selecciona un estado'])); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Delegacion/Municipio','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::select('town',[$user[0]->delegacion=>$user[0]->delegacion],$user[0]->delegacion,['id'=>'town','class'=>'form-control Fase2','placeholder'=>'Selecciona una delegacion o municipio'])); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Colonia','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::select('suburb',[$user[0]->colonia=>$user[0]->colonia],$user[0]->colonia,['id'=>'col','class'=>'form-control Fase2','placeholder'=>'Selecciona una colonia'])); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Calle y Numero','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::text('street',$user[0]->calle,array('class'=>"form-control Fase2", 'placeholder'=>""))); ?>


                    </div>
                </div>

                <div class="form-group" id="hijo">
                    <?php echo e(Form::label('Tiene hijos *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('tiene_hijos', [
                        'Si' => 'Si',
                        'No' => 'No'],
                    $user[0]->hijos, ['required' => 'required', 'class'=>"form-control Fase2", 'placeholder'=>"", 'id'=>"Fase2"]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-2"  style="float:right;">
                        <?php echo e(Form::button('Segunda Fase',['class'=>"btn btn-primary ", "onClick"=>"Fase_3()"])); ?>

                    </div>
                </div>

                 <!-- <div class="form-group">
                    <?php echo e(Form::label('Sueldo','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::number('sueldo',$user[0]->s_base,array( 'class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3"))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Sueldo complemento','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::number('sueldoComplemento',$user[0]->s_complemento,array('class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3"))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Bono Asistencia y Puntualidad','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::number('bonoAsistencia',$user[0]->bono_asis_punt,array('class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3"))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Bono Calidad','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::number('bonoCalidad',$user[0]->bono_calidad,array('class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3"))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Bono Productividad','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::number('bonoProductividad',$user[0]->bono_productividad,array('class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3"))); ?>

                    </div>
                </div> -->
                <div class="form-group">
                    <?php echo e(Form::label('Resultado de cita *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('resultadoCita', [
                        'Acepta' => 'Acepta',
                        'No acepta' => 'No acepta',
                        'En espera' => 'En espera'],
                    $user[0]->resultado_cita, ['class'=>"form-control Fase3 s", 'placeholder'=>"", 'id'=>"Fase3", "onChange"=>"validaAcepta()"] )); ?>

                    </div>
                </div>
                 
                <div class="form-group">
                    <?php echo e(Form::label('Tipo de contrato *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('tipo_contrato', [
                        'un_mes' => 'Un mes',
                        'dos_meses' => 'Dos meses',
                        'indefinido' => 'Indefinido'],
                    null, ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>


                <div id="Capa">

                        <div class="form-group">
                            <?php echo e(Form::label('Fecha  de Capacitación *','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::date('fechaCapacitacion',$user[0]->fecha_capacitacion,array('required' => 'required', 'class'=>"form-control Fase3 J1", 'placeholder'=>"", 'id'=>"Fase3"))); ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo e(Form::label('Nombre de Capacitor ','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::select('nombreCapacitador',$capacitadores,
                            $user[0]->nombre_capacitador, [ 'class'=>"form-control Fase3 J2", 'placeholder'=>"", 'id'=>"Fase3"] )); ?>

                            </div>
                        </div>

              </div>
                <!-- <div class="form-group">
                    <?php echo e(Form::label('Estado de Capacitación *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('estadoCapacitacion', [
                        'Aceptado' => 'Aceptado',
                        'No aceptado' => 'No aceptado',
                        'En espera' => 'En espera'],
                    $user[0]->estado_capacitacion, ['class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3"] )); ?>

                    </div>
                </div> -->

                <div class="form-group">
                    <?php echo e(Form::label('Fotografía','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::file('foto',['class'=>"form-control"] )); ?>

                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">

                        <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default",'onClick'=>'return confirm("seguro que desea guardar la información"),ValTel()'])); ?>

                    </div>
                </div>
                <?php echo e(Form::close()); ?>


            </div>
        </div>
    </div>
</div>

<script type="text/javascript">




    function LlenarMedioReclutamiento()
    {
      console.log($('#tipoMedioReclutamiento').val());
      if($('#tipoMedioReclutamiento').val()=='Bolsa de Trabajo')
      {
        $('#medioRecluta').attr("style",'');
        $("#medioReclutamiento").prop('disabled',false);

      }
      else
      {
        $('#medioRecluta').attr("style",'display:none');
        $("#medioReclutamiento").prop('disabled', true);
      }

    }



    var cont=document.getElementsByClassName("Fase1");
    var cont2=document.getElementsByClassName("Fase2");
    var cont3=document.getElementsByClassName("Fase3");
    <?PHP
    if((!$user[0]->estatus_llamada)&&(!$user[0]->medio_reclutamiento))
    {
    ?>
        for(var i=0;i<cont.length;i++)
        {
            document.getElementsByClassName("Fase1")[i].disabled = true;
        }
    <?php
    }
    if((!$user[0]->estatus_cita)&&(!$user[0]->fecha_nacimiento==null)&&(!$user[0]->sexo)&&(!$user[0]->estado_civil)&&(!$user[0]->estado)&&(!$user[0]->delegacion)&&(!$user[0]->colonia)&&(!$user[0]->calle)&&(!$user[0]->hijos))
    {
    ?>
        for(var j=0;j<cont2.length;j++)
        {
            document.getElementsByClassName("Fase2")[j].disabled = true;
        }
    <?php
    }
    if((!$user[0]->s_base)&&(!$user[0]->s_complemento)&&(!$user[0]->bono_asis_punt)&&(!$user[0]->bono_calidad)&&(!$user[0]->bono_productividad)&&(!$user[0]->resultado_cita)&&(!$user[0]->fecha_capacitacion==null)&&(!$user[0]->nombre_capacitador)&&(!$user[0]->estado_capacitacion))
    {
    ?>
        for(var k=0;k<cont3.length;k++)
        {
            document.getElementsByClassName("Fase3")[k].disabled = true;
        }
    <?php
    }
    ?>


    function Fase_1(){
        for(var l=0;l<cont.length;l++)
    document.getElementsByClassName("Fase1")[l].disabled = false;
    }

    function Fase_2(){
        for(var m=0;m<cont2.length;m++)
    document.getElementsByClassName("Fase2")[m].disabled = false;
    }

    function Fase_3(){
        for(var n=0;n<cont3.length;n++)
    document.getElementsByClassName("Fase3")[n].disabled = false;
    }

    function ValTel()
        {
            var cel=$('#cel').val();
            var tel=$('#tel').val();
            if(cel==''&&tel=='')
            {
                alert('Es necesario Capturar algún número telefónico');
                return false;
            }
        }

    function LlenarSelect()
      {
        var listdesp  = document.forms.formulario.area.selectedIndex;
        //alert(list)

        formulario.puesto.length=0;

        if(listdesp==1) ListaDes1();
        if(listdesp==2) ListaDes2();
        if(listdesp==3) ListaDes3();
        if(listdesp==4) ListaDes4();
        if(listdesp==5) ListaDes5();
        if(listdesp==6) ListaDes6();
        if(listdesp==7) ListaDes7();
        if(listdesp==8) ListaDes8();
        if(listdesp==9) ListaDes9();
        if(listdesp==10) ListaDes10();
        if(listdesp==11) ListaDes11();

      }


        function ListaDes1(){
            opcion0 = new Option("Operador de Call Center", "Operador de Call Center");
            opcion1 = new Option("Supervisor", "Supervisor");
            opcion2 = new Option("Coordinador", "Coordinador");
            opcion3 = new Option("Coordinador Jr", "Coordinador Jr");
            //opcion4=new Option("Director","Director");
            opcion4 = new Option("Gerente", "Gerente");
            opcion5 = new Option("Coach", "Coach");
            opcion6 = new Option("Comentarios", "Comentarios");
            opcion7 = new Option("Inbox", "Inbox");
            opcion8 = new Option("Procesos", "Procesos");
            opcion9 = new Option("Supervisor de BO/Validación", "Supervisor de BO/Validación");

            document.forms.formulario.puesto.options[0] = opcion0;
            document.forms.formulario.puesto.options[1] = opcion1;
            document.forms.formulario.puesto.options[2] = opcion2;
            document.forms.formulario.puesto.options[3] = opcion3;
            document.forms.formulario.puesto.options[4] = opcion4;
            document.forms.formulario.puesto.options[5] = opcion5;
            document.forms.formulario.puesto.options[6] = opcion6;
            document.forms.formulario.puesto.options[7] = opcion7;
            document.forms.formulario.puesto.options[8] = opcion8;
            document.forms.formulario.puesto.options[9] = opcion9;
        }

        function ListaDes2(){
          opcion0=new Option("Validador","Validador","defauldSelected");
          // opcion1=new Option("Jefe de Validación","Jefe de Validacion");

          document.forms.formulario.puesto.options[0]=opcion0;
          // document.forms.formulario.puesto.options[1]=opcion1;
        }

        function ListaDes3(){
            opcion0 = new Option("Analista de Calidad", "Analista de Calidad", "defauldSelected");
            opcion1 = new Option("Jefe de Calidad", "Jefe de Calidad");
            opcion2 = new Option("Coordinador de Calidad", "Coordinador de Calidad");

            document.forms.formulario.puesto.options[0] = opcion0;
            document.forms.formulario.puesto.options[1] = opcion1;
            document.forms.formulario.puesto.options[2] = opcion2;
        }

        function ListaDes4(){
            opcion0=new Option("Analista de BO","Analista de BO","defauldSelected");
            opcion1=new Option("Jefe de BO","Jefe de BO");
            opcion2=new Option("Analista de BO (Consultas y recuperación)","Analista de BO (Consultas y recuperación)");
            opcion3=new Option("Analista de BO (Ingresos)","Analista de BO (Ingresos)");
            opcion4=new Option("Analista de BO (Proceso 1)","Analista de BO (Proceso 1)");
            opcion5=new Option("Analista de BO (Proceso 2)","Analista de BO (Proceso 2)");
            opcion6=new Option("Analista de BO (WhatsApp)","Analista de BO (WhatsApp)");
            opcion7=new Option("Analista de BO 2 (Ingresos)","Analista de BO 2 (Ingresos)");
            opcion8=new Option("Facebook AC","Facebook AC");
            opcion9=new Option("Facebook Ventas","Facebook Ventas");
            opcion10=new Option("Analista de BO (Proceso 1) Banamex","Analista de BO (Proceso 1) Banamex");
            opcion11=new Option("Analista de BO Banamex", "Analista de BO Banamex");

            document.forms.formulario.puesto.options[0]=opcion0;
            document.forms.formulario.puesto.options[1]=opcion1;
            document.forms.formulario.puesto.options[2]=opcion2;
            document.forms.formulario.puesto.options[3]=opcion3;
            document.forms.formulario.puesto.options[4]=opcion4;
            document.forms.formulario.puesto.options[5]=opcion5;
            document.forms.formulario.puesto.options[6]=opcion6;
            document.forms.formulario.puesto.options[7]=opcion7;
            document.forms.formulario.puesto.options[8]=opcion8;
            document.forms.formulario.puesto.options[9]=opcion9;
            document.forms.formulario.puesto.options[10]=opcion10;
            document.forms.formulario.puesto.options[11]=opcion11
        }

        function ListaDes5(){
            opcion0=new Option("Ejecutivo de cuenta","Ejecutivo de cuenta","defauldSelected");
            //opcion1=new Option("Coordinador de reclutamiento","Coordinador de reclutamiento");
            opcion1=new Option("Jefe de Reclutamiento","Jefe de Reclutamiento");
            opcion2=new Option("Social Media Manager","Social Media Manager");
            opcion3=new Option("Becario citas","Becario citas");
            opcion4=new Option("Becario entrevistas","Becario entrevistas");
            opcion5=new Option("Calidad","Calidad");
            opcion6=new Option("Coordinador de reclutamiento","Coordinador de reclutamiento");
            opcion7=new Option("Ejecutivo de cuenta citas Jr","Ejecutivo de cuenta citas Jr");
            opcion8=new Option("Ejecutivo de cuenta citas Sr","Ejecutivo de cuenta citas Sr");
            opcion9=new Option("Ejecutivo de cuenta entrevistas Jr","Ejecutivo de cuenta entrevistas Jr");
            opcion10=new Option("Ejecutivo de cuenta entrevistas Sr","Ejecutivo de cuenta entrevistas Sr");
            opcion11=new Option("Jefe de Reclutamiento","Jefe de Reclutamiento");

            document.forms.formulario.puesto.options[0]=opcion0;
            document.forms.formulario.puesto.options[1]=opcion1;
            document.forms.formulario.puesto.options[2]=opcion2;
            document.forms.formulario.puesto.options[3]=opcion3;
            document.forms.formulario.puesto.options[4]=opcion4;
            document.forms.formulario.puesto.options[5]=opcion5;
            document.forms.formulario.puesto.options[6]=opcion6;
            document.forms.formulario.puesto.options[7]=opcion7;
            document.forms.formulario.puesto.options[8]=opcion8;
            document.forms.formulario.puesto.options[9]=opcion9;
            document.forms.formulario.puesto.options[10]=opcion10;
            document.forms.formulario.puesto.options[11]=opcion11;
        }

        function ListaDes6(){
            opcion0=new Option("","","defauldSelected");
            opcion1=new Option("Programador 1","Programador 1");
            opcion2=new Option("Programador 2","Programador 2");
            opcion3=new Option("Programador 3","Programador 3");
            opcion4=new Option("Becario de desarrollo","Becario de desarrollo");
            opcion5=new Option("Becario soporte","Becario soporte");
            opcion6=new Option("Jefe de desarrollo","Jefe de desarrollo");
            opcion7=new Option("Jefe de Soporte","Jefe de Soporte");
            opcion8=new Option("Técnico de soporte 1","Técnico de soporte 1");
            opcion9=new Option("Técnico de soporte 2","Técnico de soporte 2");

            document.forms.formulario.puesto.options[0]=opcion0;
            document.forms.formulario.puesto.options[1]=opcion1;
            document.forms.formulario.puesto.options[2]=opcion2;
            document.forms.formulario.puesto.options[3]=opcion3;
            document.forms.formulario.puesto.options[4]=opcion4;
            document.forms.formulario.puesto.options[5]=opcion5;
            document.forms.formulario.puesto.options[6]=opcion6;
            document.forms.formulario.puesto.options[7]=opcion7;
            document.forms.formulario.puesto.options[8]=opcion8;
            document.forms.formulario.puesto.options[9]=opcion9;
        }

        function ListaDes7(){
            opcion0 = new Option("Asistente Administrativo Jr", "Asistente Administrativo Jr");
            opcion1 = new Option("Asistente Administrativo Sr", "Asistente Administrativo Sr");
            opcion2 = new Option("Ayudante general", "Ayudante general");
            opcion3 = new Option("Becario", "Becario");
            opcion4 = new Option("Capturista", "Capturista");
            opcion5 = new Option("Gerente de RRHH", "Gerente de RRHH");
            opcion6 = new Option("Jefe de administración", "Jefe de administracion");
            opcion7 = new Option("Jefe de reclutamiento", "Jefe de reclutamiento");
            opcion8 = new Option("Personal de mantenimiento", "Personal de mantenimiento")
            opcion9 = new Option("Recepciónista", "Recepcionista");

            document.forms.formulario.puesto.options[0] = opcion0;
            document.forms.formulario.puesto.options[1] = opcion1;
            document.forms.formulario.puesto.options[2] = opcion2;
            document.forms.formulario.puesto.options[3] = opcion3;
            document.forms.formulario.puesto.options[4] = opcion4;
            document.forms.formulario.puesto.options[5] = opcion5;
            document.forms.formulario.puesto.options[6] = opcion6;
            document.forms.formulario.puesto.options[7] = opcion7;
            document.forms.formulario.puesto.options[8] = opcion8;
            document.forms.formulario.puesto.options[9] = opcion9;
        }

        function ListaDes8(){
            opcion0 = new Option("Operador de edición", "Operador de edicion", "defauldSelected");
            opcion1 = new Option("Jefe de edicion", "Jefe de edicion");
            opcion2 = new Option("Supervisor de edicion", "Supervisor de edicion");

            document.forms.formulario.puesto.options[0] = opcion0;
            document.forms.formulario.puesto.options[1] = opcion1;
            document.forms.formulario.puesto.options[2] = opcion2;
        }

        function ListaDes9(){
            opcion0 = new Option("Capacitador", "Capacitador");
            opcion1 = new Option("Jefe de capacitación", "Jefe de capacitacion", "defauldSelected");
            opcion2 = new Option("Coordinador de Capacitacion", "Coordinador de Capacitacion");

            document.forms.formulario.puesto.options[0] = opcion0;
            document.forms.formulario.puesto.options[1] = opcion1;
            document.forms.formulario.puesto.options[2] = opcion2;
        }

        function ListaDes10(){
          opcion0=new Option("Director General","Director General","defauldSelected");

          document.forms.formulario.puesto.options[0]=opcion0;
        }
        function ListaDes11(){
          opcion0=new Option("Ejecutivo de recursos humanos","Ejecutivo de recursos humanos","defauldSelected");

          document.forms.formulario.puesto.options[0]=opcion0;
        }
        </script>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('contentScript'); ?>
    <script>

    <?php if($hijos): ?>

            var contador=0;

            $('<div class="form-group hijodato'+contador+'s" id="hijonombre'+contador+'"></div>').insertAfter('#hijo');
                $('<label class="col-sm-2 control-label hijodato'+contador+'s" id="hijo'+contador+'">Nombre</label>').appendTo('#hijonombre'+contador+'');
                $('<div class="col-sm-10 hijodato'+contador+'s" id="hijo'+contador+'nombre"></div>').appendTo('#hijonombre'+contador+'');
                $('<input type="text" class="form-control Fase2 hijodato'+contador+'s" id="hijo'+contador+'n" name="nombrehijo'+contador+'" value="<?php echo e($hijos[0]->nombre); ?>"></input>').appendTo('#hijo'+contador+'nombre');


                $('<div class="form-group hijodato'+contador+'s" id="hijofecha'+contador+'"></div>').insertAfter('#hijonombre'+contador+'');
                $('<label class="col-sm-2 control-label hijodatos" id="hijo'+contador+'l">fecha de necimiento</label>').appendTo('#hijofecha'+contador+'');
                $('<div class="col-sm-10 hijodato'+contador+'s" id="hijo'+contador+'f"></div>').appendTo('#hijofecha'+contador+'');
                $('<input type="date" class="form-control Fase2 hijodato'+contador+'s" id="hijo'+contador+'c" name="fechahijo'+contador+'" value="<?php echo e($hijos[0]->cumple); ?>"></input>').appendTo('#hijo'+contador+'f');

    <?php echo $cont=1;; ?>

        <?php for($i=1;$i<count($hijos);$i++): ?>

                contador++;

                $('<div class="form-group hijodato'+contador+'s" id="hijonombre'+contador+'"></div>').insertAfter('#hijofecha'+(contador-1)+'');
                $('<label class="col-sm-2 control-label hijodato'+contador+'s" id="hijo'+contador+'">Nombre</label>').appendTo('#hijonombre'+contador+'');
                $('<div class="col-sm-10 hijodato'+contador+'s" id="hijo'+contador+'nombre"></div>').appendTo('#hijonombre'+contador+'');
                $('<input type="text" class="form-control Fase2 hijodato'+contador+'s" id="hijo'+contador+'n" name="nombrehijo'+contador+'" value="<?php echo e($hijos[$i]->nombre); ?>"></input>').appendTo('#hijo'+contador+'nombre');


                $('<div class="form-group hijodato'+contador+'s" id="hijofecha'+contador+'"></div>').insertAfter('#hijonombre'+contador+'');
                $('<label class="col-sm-2 control-label hijodatos" id="hijo'+contador+'l">fecha de necimiento</label>').appendTo('#hijofecha'+contador+'');
                $('<div class="col-sm-10 hijodato'+contador+'s" id="hijo'+contador+'f"></div>').appendTo('#hijofecha'+contador+'');
                $('<input type="date" class="form-control Fase2 hijodato'+contador+'s" id="hijo'+contador+'c" name="fechahijo'+contador+'" value="<?php echo e($hijos[$i]->cumple); ?>"></input>').appendTo('#hijo'+contador+'f');



            <?php echo $cont++;; ?>


        <?php endfor; ?>

            $('<div class="form-group hijodato0s" id="hijoboton"></div>').insertAfter('#hijofecha'+contador+'');
            $('<div class="col-sm-10" id="hijocont"></div>').appendTo('#hijoboton')
            $('<input type="button" class="btn btn-primary  hijodato0s" id="hijo1b" value="+" onClick="add();"></input>' ).appendTo('#hijocont');
            $('<input type="button" class="btn btn-primary  hijodato0s" id="hijo2b" value="-" onClick="dcm();" name="check"></input>' ).appendTo('#hijocont');

    <?php endif; ?>

        /* ------------------------------------- */
        $('#hijo').change(function(event){

        if(event.target.value=='Si')
        {
            console.log("si");
            contador=0;
            $('<div class="form-group hijodato0s" id="hijonombre0"></div>').insertAfter('#hijo');
            $('<label class="col-sm-2 control-label hijodato0s" id="hijo0">Nombre</label>').appendTo('#hijonombre0');
            $('<div class="col-sm-10 hijodato0s" id="hijo0n"></div>').appendTo('#hijonombre0');
            $('<input type="text" class="form-control Fase2 hijodato0s" id="hijo1n" name="nombrehijo0"></input>').appendTo('#hijo0n');


            $('<div class="form-group hijodato0s" id="hijofecha0"></div>').insertAfter('#hijonombre0');
            $('<label class="col-sm-2 control-label hijodato0s" id="hijo0l">fecha de necimiento</label>').appendTo('#hijofecha0');
            $('<div class="col-sm-10 hijodato0s" id="hijo0f"></div>').appendTo('#hijofecha0');
            $('<input type="date" class="form-control Fase2 hijodato0s" id="hijo0c" name="fechahijo0"></input>').appendTo('#hijo0f');


            $('<div class="form-group hijodato0s" id="hijoboton"></div>').insertAfter('#hijofecha'+contador+'');
            $('<div class="col-sm-10" id="hijocont"></div>').appendTo('#hijoboton')
            $('<input type="button" class="btn btn-primary  hijodato0s" id="hijo1b" value="+" onClick="add();"></input>' ).appendTo('#hijocont');
            $('<input type="button" class="btn btn-primary  hijodato0s" id="hijo2b" value="-" onClick="dcm();" name="check"></input>' ).appendTo('#hijocont');



        }
        else
        {
            for(var i=0;i<=contador;i++)
            $('.hijodato'+i+'s').remove();
            console.log("no");
        }

    });


    /*---------     Contador hijos    ---------------*/



    function add(){
    contador++;
            if(contador>=1)
            {
                $('<div class="form-group hijodato'+contador+'s" id="hijonombre'+contador+'"></div>').insertAfter('#hijofecha'+(contador-1)+'');
                $('<label class="col-sm-2 control-label hijodato'+contador+'s" id="hijo'+contador+'l">Nombre</label>').appendTo('#hijonombre'+contador+'');
                $('<div class="col-sm-10 hijodato'+contador+'s" id="hijo'+contador+'nombre"></div>').appendTo('#hijonombre'+contador+'');
                $('<input type="text" class="form-control Fase2 hijodato'+contador+'s" id="hijo'+contador+'n" name="nombrehijo'+contador+'"></input>').appendTo('#hijo'+contador+'nombre');

                $('<div class="form-group hijodato'+contador+'s" id="hijofecha'+contador+'"></div>').insertAfter('#hijonombre'+(contador)+'');
                $('<label class="col-sm-2 control-label hijodatos" id="hijo'+contador+'l">fecha de necimiento</label>').appendTo('#hijofecha'+contador+'');
                $('<div class="col-sm-10 hijodato'+contador+'s" id="hijo'+contador+'f"></div>').appendTo('#hijofecha'+contador+'');
                $('<input type="date" class="form-control Fase2 hijodato'+contador+'s" id="hijo'+contador+'c" name="fechahijo'+contador+'"></input>').appendTo('#hijo'+contador+'f');





            }

    }

    function dcm() {


                if(contador>0)
                {
                    $('.hijodato'+contador+'s').remove();
                    contador--;
                }
        }

        if('<?php echo e($user[0]->tipo_medio_reclutamiento); ?>'==='Bolsa de Trabajo')
        {
          $('#medioRecluta').attr("style",'');
          $("#medioReclutamiento").prop('disabled',false);
        }
        else
        {
          $('#medioRecluta').attr("style",'display:none');
          $("#medioReclutamiento").prop('disabled', true);
        }


</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>
<script>

function LlenarMedioReclutamiento()
{
  console.log($('#tipoMedioReclutamiento').val());
  if($('#tipoMedioReclutamiento').val()=='Bolsa de Trabajo')
  {
    $('#medioRecluta').attr("style",'');
    $("#medioReclutamiento").prop('disabled',false);

  }
  else
  {
    $('#medioRecluta').attr("style",'display:none');
    $("#medioReclutamiento").prop('disabled', true);
  }

}

$( document ).ready(function() {
  var listdesp  = document.forms.formulario.area.selectedIndex;
    //alert(list)

    formulario.puesto.length=0;

    if(listdesp==1) ListaDes1();
    if(listdesp==2) ListaDes2();
    if(listdesp==3) ListaDes3();
    if(listdesp==4) ListaDes4();
    if(listdesp==5) ListaDes5();
    if(listdesp==6) ListaDes6();
    if(listdesp==7) ListaDes7();
    if(listdesp==8) ListaDes8();
    if(listdesp==9) ListaDes9();
    if(listdesp==10) ListaDes10();
    if(listdesp==11) ListaDes11();



    if($('.s').val()==='Acepta')
    {
      $(".J1").prop('disabled',false);
      $(".J2").prop('disabled',false);
    }
    else {
      $(".J1").prop('disabled',true);
      $(".J2").prop('disabled',true);
    }









    var puestesito="<?php echo e($user[0]->puesto); ?>";
    $("#puesto option[value='"+ puestesito +"']").attr("selected","selected");


  if($('#tipoMedioReclutamiento').val()!='Bolsa de Trabajo')
  {
    $('#medioRecluta').attr("style",'display:none');
    $("#medioReclutamiento").prop('disabled', true);
  }
  else
  {
    $('#medioRecluta').attr("style",'');
    $("#medioReclutamiento").prop('disabled',false);
  }
});
</script>

<script type="text/javascript">

    function validaAcepta(){
      // console.log($('.s').val());
      if($('.s').val()=='Acepta')
      {
        $('#Capa').attr("style",'');
        $(".J1").prop('disabled',false);
        $(".J2").prop('disabled',false);
      }
      else {
        $('#Capa').attr("style",'display:none');
        $(".J1").prop('disabled',true);
        $(".J2").prop('disabled',true);
      }
    }




</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>