<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">
                <?php echo e(Form::open(['action' => 'RhController@Back',
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
                                <?php echo e(Form::text('id',$user[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-pull-10">
                        <img src="<?php echo e(asset('storage/1.jpg')); ?>" class="img-responsive" style="width: 150px; height: 120px;">
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <?php echo e(Form::label('Nombre(s)','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->nombre,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Apellido Paterno','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('paterno',$user[0]->paterno,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Apellido Materno','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('materno',$user[0]->materno,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo e(Form::label('En caso de emergencia llamar a  ','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nom_emergencia1','',array('class'=>"form-control", 'placeholder'=>"Nombre del Contacto Emergencia 1"))); ?>

                        <?php echo e(Form::number('emergencia1','',array('class'=>"form-control", 'placeholder'=>"Telefono 1"))); ?>

                        <?php echo e(Form::text('nom_emergencia2','',array('class'=>"form-control", 'placeholder'=>"Nombre del Contacto Emergencia 2"))); ?>

                        <?php echo e(Form::number('emergencia2','',array('class'=>"form-control", 'placeholder'=>"Telefono 2"))); ?>

                    </div>
                </div>
                
                 <div class="form-group">
                    <?php echo e(Form::label('Turno','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->turno,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Fecha de entrevista ','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',date("Y-m-d", strtotime($user[0]->fecha_cita)),array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Sucursal','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->sucursal,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Hora de entrevista','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',date("H:i:s", strtotime($user[0]->fecha_cita)),array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Ejecutivo de Reclutamiento','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->reclutador,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                     <div class="form-group">
                    <?php echo e(Form::label('Área','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->area,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Puesto','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->puesto,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Teléfono','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->telefono_fijo,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                   <?php echo e(Form::label('Celular','',array('class'=>"col-sm-2 control-label"))); ?>

                   <div class="col-sm-10">
                       <?php echo e(Form::text('nombre',$user[0]->telefono_cel,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                   </div>
               </div>
                <div class="form-group">
                    <?php echo e(Form::label('Email','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->email,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Campaña','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::text('nombre',$user[0]->campaign,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
               <div class="form-group">
                    <?php echo e(Form::label('Experiencia','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->experiencia,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>


                <div class="form-group">
                    <?php echo e(Form::label('Estatus de llamada','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->estatus_llamada,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Medio de reclutamiento ','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->tipo_medio_reclutamiento,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Bolsas de Trabajo','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->medio_reclutamiento,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Estatus de cita','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->estatus_cita,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Fecha de Nacimiento','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->fecha_nacimiento,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Sexo','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->sexo,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Estado civil','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->estado_civil,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>


                 <div class="form-group">
                    <?php echo e(Form::label('Estado','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::text('nombre',$user[0]->estado,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Delegacion/Municipio','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::text('nombre',$user[0]->delegacion,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Colonia','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::text('nombre',$user[0]->colonia,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Calle y Numero','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::text('street',$user[0]->calle,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>


                    </div>
                </div>

                <div class="form-group" id="hijo">
                    <?php echo e(Form::label('Tiene hijos *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->hijos,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                 <div class="form-group">
                    <?php echo e(Form::label('Sueldo','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->s_base,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Sueldo complemento','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->s_complemento,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Bono Asistencia y Puntualidad','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->bono_asis_punt,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Bono Calidad','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->bono_calidad,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Bono Productividad','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->bono_productividad,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Resultado de cita *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->resultado_cita,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Fecha  de Capacitación *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->fecha_capacitacion,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Nombre de Capacitor ','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->nombre_capacitador,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Estado de Capacitación *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->estado_capacitacion,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">

                        <?php echo e(Form::submit('Salir',['class'=>"btn btn-default"])); ?>

                    </div>
                </div>
                <?php echo e(Form::close()); ?>


            </div>
        </div>
    </div>
</div>

<script type="text/javascript">


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

  }


    function ListaDes1(){
      opcion0=new Option("Operador de Call Center","Operador de Call Center");
      opcion1=new Option("Supervisor","Supervisor");
      opcion2=new Option("Coordinador","Coordinador");
      opcion3=new Option("Coordinador Jr","Coordinador Jr");
      //opcion4=new Option("Director","Director");
      opcion4=new Option("Gerente","Gerente");
      opcion5=new Option("Couch","Couch");

      document.forms.formulario.puesto.options[0]=opcion0;
      document.forms.formulario.puesto.options[1]=opcion1;
      document.forms.formulario.puesto.options[2]=opcion2;
      document.forms.formulario.puesto.options[3]=opcion3;
      document.forms.formulario.puesto.options[4]=opcion4;
      document.forms.formulario.puesto.options[5]=opcion5;
      //document.forms.formulario.puesto.options[5]=opcion5;
    }

    function ListaDes2(){
      opcion0=new Option("Validador","Validador","defauldSelected");
      //opcion1=new Option("Jefe de Validación","Jefe de Validacion");

      document.forms.formulario.puesto.options[0]=opcion0;
      //document.forms.formulario.puesto.options[1]=opcion1;
    }

    function ListaDes3(){
      opcion0=new Option("Analista de Calidad","Analista de Calidad","defauldSelected");
      opcion1=new Option("Jefe de Calidad","Jefe de Calidad");

      document.forms.formulario.puesto.options[0]=opcion0;
      document.forms.formulario.puesto.options[1]=opcion1;
    }

    function ListaDes4(){
      opcion0=new Option("Analista de BO","Analista de BO","defauldSelected");
      opcion1=new Option("Jefe de BO","Jefe de BO");

      document.forms.formulario.puesto.options[0]=opcion0;
      document.forms.formulario.puesto.options[1]=opcion1;
    }

    function ListaDes5(){
      opcion0=new Option("Ejecutivo de cuenta","Ejecutivo de cuenta","defauldSelected");
      //opcion1=new Option("Coordinador de reclutamiento","Coordinador de reclutamiento");
      opcion1=new Option("Jefe de Reclutamiento","Jefe de Reclutamiento");
      opcion2=new Option("Social Media Manager","Social Media Manager");

      document.forms.formulario.puesto.options[0]=opcion0;
      document.forms.formulario.puesto.options[1]=opcion1;
      document.forms.formulario.puesto.options[2]=opcion2;
    }

    function ListaDes6(){
      opcion0=new Option("Programador","Programador","defauldSelected");
      opcion1=new Option("Tecnico de soporte","Tecnico de soporte");
      opcion2=new Option("Jefe de Soporte","Jefe de Soporte");
      opcion3=new Option("Jefe de desarrollo","Jefe de desarrollo");
      opcion4=new Option("Becario","Becario");
      opcion5=new Option("Pasante","Pasante");
      opcion6=new Option("Director de Sistemas","Director de Sistemas");

      document.forms.formulario.puesto.options[0]=opcion0;
      document.forms.formulario.puesto.options[1]=opcion1;
      document.forms.formulario.puesto.options[2]=opcion2;
      document.forms.formulario.puesto.options[3]=opcion3;
      document.forms.formulario.puesto.options[4]=opcion4;
      document.forms.formulario.puesto.options[5]=opcion5;
      document.forms.formulario.puesto.options[6]=opcion6;
    }

    function ListaDes7(){
      //opcion0=new Option("Becario","Becario");
      opcion0=new Option("Jefe de administración","Jefe de administracion");
      opcion1=new Option("Personal de limpieza","Personal de limpieza");
      //opcion3=new Option("Director","Director");
      opcion2=new Option("Recepciónista","Recepcionista");
      opcion3=new Option("Asistente Administrativo","Asistente Administrativo");
      //opcion6=new Option("Ejecutivo Administrativo","Ejecutivo Administrativo");
      opcion4=new Option("Capturista","Capturista");
      opcion5=new Option("Personal de mantenimiento","Personal de mantenimiento");

      document.forms.formulario.puesto.options[0]=opcion0;
      document.forms.formulario.puesto.options[1]=opcion1;
      document.forms.formulario.puesto.options[2]=opcion2;
      document.forms.formulario.puesto.options[3]=opcion3;
      document.forms.formulario.puesto.options[4]=opcion4;
      document.forms.formulario.puesto.options[5]=opcion5;
      // document.forms.formulario.puesto.options[5]=opcion5;
      // document.forms.formulario.puesto.options[6]=opcion6;
      // document.forms.formulario.puesto.options[7]=opcion7;
    }

    function ListaDes8(){
      opcion0=new Option("Operador de edición","Operador de edicion","defauldSelected");

      document.forms.formulario.puesto.options[0]=opcion0;

    }

    function ListaDes9(){
      //opcion0=new Option("Jefe de capacitación","Jefe de capacitacion","defauldSelected");
      opcion0=new Option("Capacitador","Capacitador");

      //document.forms.formulario.puesto.options[0]=opcion0;
      document.forms.formulario.puesto.options[0]=opcion0;
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

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>