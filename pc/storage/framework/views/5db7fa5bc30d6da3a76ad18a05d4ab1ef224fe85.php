<?php
$user = Session::all();
?>

    


<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'AdminController@NewEmpleado',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=>'formulario'
                            ])); ?>



                <div class="form-group">
                    <?php echo e(Form::label('Nombre *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',null,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Paterno *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('paterno',null,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Materno','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('materno',null,array('class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Telefono fijo',null,array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::number('telefono_fijo',null,array('class'=>"form-control"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Telefono celular','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::number('telefono_cel',null,array('class'=>"form-control"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Fecha de Cumpleaños','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::date('fecha_cumple',null,array('class'=>"form-control", 'placeholder'=>"********"))); ?>

                    </div>
                </div>





                <div class="form-group">
                    <?php echo e(Form::label('En caso de emergencia llamar a ','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nom_emergencia1',null,array('class'=>"form-control", 'placeholder'=>"Nombre del Contacto emergencia 1"))); ?>

                        <?php echo e(Form::number('emergencia1',null,array('class'=>"form-control", 'placeholder'=>"Telefono 1"))); ?>

                        <?php echo e(Form::text('nom_emergencia2',null,array('class'=>"form-control", 'placeholder'=>"Nombre del Contacto emergencia 2"))); ?>

                        <?php echo e(Form::number('emergencia1',null,array('class'=>"form-control", 'placeholder'=>"Telefono 2"))); ?>

                    </div>
                </div>







                <div class="form-group">
                    <?php echo e(Form::label('Usuario externo','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('user_ext',null,array('class'=>"form-control", 'placeholder'=>"PC0000"))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Usuario Elastix','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('user_elx',null,array('class'=>"form-control", 'placeholder'=>"111"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Usuario Auxiliar','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('usuarioAux',null,array('class'=>"form-control"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Posicion *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('posicion',null,array('class'=>"form-control"))); ?>


                    </div>
                </div>



                <div class="form-group">
                    <?php echo e(Form::label('Area *','',array('class'=>"col-sm-2 control-label"))); ?>

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
                      'Recursos Humanos'=>'Recursos Humanos'],
                      null, ['id'=>'area','required' => 'required', 'class'=>"form-control", 'placeholder'=>"", "onchange"=>"LlenarSelect(),validacion()"]  )); ?>

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
                                'Validador' => 'Validador'
                                ],
                  null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'puesto','onChange'=>'validacion()']  )); ?>

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
                        'Validación' =>'Validación'
                    ],null, ['class'=>"form-control", 'placeholder'=>"",'id'=>'campaign','onChange'=>'validacion(),ACalidad()']  )); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Sucursal *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('sucursal', [
                                'Zapata'=>'Zapata',
                                'Roma'=>'Roma',
                            ],
                        null, ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Turno *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('turno', [
                        'Matutino' => 'Matutino',
                        'Vespertino' => 'Vespertino',
                        'Turno Completo' => 'Turno Completo',
                        'Doble Turno' => 'Doble Turno'],
                    null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Grupo','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('grupo', [
                        '1' => 'Proceso 1 BO',
                        '2' => 'Proceso 2 BO',
                        '7' => 'Ingreso BO',
                        '3' => 'Calidad (Validadores)',
                        '4' => 'Facebook Inbox',
                        '5' => 'Facebook Ventas',
                        '6' => 'Facebook Comentarios',
                        '10' => 'Encuesta 2 de Bancomer'],
                    null, ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Supervisor','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('supervisor', $super,
                    null, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'sup']  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Validador','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('validador',$teamLeader,
                        null, ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Analista de Calidad','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('analistaCalidad',$analistaCalidad,
                        null, ['class'=>"form-control", 'placeholder'=>"",'id'=>'analista']  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Fecha de ingreso a capacitacion','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::date('fecha_ingreso_capacitacion',null,array('class'=>"form-control", 'placeholder'=>"********"))); ?>

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


                <div class="form-group">
                  <?php echo e(Form::label('Medio de reclutamiento *','',array('class'=>"col-sm-2 control-label"))); ?>

                  <div class="col-sm-10">
                    <?php echo e(Form::select('tipoMedioReclutamiento', [
                    'Volanteo' => 'Volanteo',
                    'FaceBook' => 'FaceBook',
                    'Bolsa de Trabajo' => 'Bolsa de Trabajo',
                    'Invitacion Telefonica' => 'Invitación Telefónica'],
                    null, ['required' => 'required','class'=>"form-control", 'placeholder'=>"","onchange"=>"LlenarMedioReclutamiento()",'id'=>'tipoMedioReclutamiento']  )); ?>

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
                        'Otro'=>'Otro'],
                        null, ['required' => 'required','class'=>"form-control", 'placeholder'=>"", 'id'=>"medioReclutamiento"]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Ejecutivo de Reclutamiento','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('ejecReclutamiento',$Reclutador,
                        null, ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>


                <div class="form-group">
                    <?php echo e(Form::label('Fotografía','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::file('foto',['class'=>"form-control"] )); ?>

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default"])); ?>

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



function ACalidad()
{
    var camp=$('#campaign').val();
    console.log(camp);
    $.ajax({

                url:   "admin/analista/"+camp,

                type:  'get',
                beforeSend: function () {
                        console.log('espere');
                },
                success:  function (analista)
                {
                    console.log(analista);
                    $('#analista').empty();
                    $('#analista').append(new Option('', ''));
                    for(i=0;i<analista.length;i++)
                    {
                        $('#analista').append('<option value="'+analista[i].id+'">'+analista[i].nombre_completo+'</option>');
                    }
                }
        });
}

function validacion()
{
    var area=$('#area').val();
    var puesto=$('#puesto').val();
    var camp=$('#campaign').val();
    console.log(area);
    console.log(puesto);
    console.log(camp);
    $.ajax({

                url:   "admin/coor/"+area+"/"+puesto+"/"+camp,

                type:  'get',
                beforeSend: function () {
                        console.log('espere');

                },
                success:  function (data)
                {
                    console.log(data);

                    $('#sup').empty();

                    $('#sup').append(new Option('', ''));
                    for(i=0;i<data.length;i++)
                    {
                        $('#sup').append('<option value="'+data[i].id+'">'+data[i].nombre_completo+'</option>');
                    }

                }
        });
}

// function posicion(){
//     var posicion =$('#posicion').pos();
//     var turno =$('#turno').pos();
//     console.log(posi);
//     $.ajax({
//
//         url: "admin/coor/"+posicion+"/"+turno,
//
//         type: 'get',
//         beforeSend:function(){
//             console.log('espere');
//         },
//         success: function(data){
//             console.log(data);
//
//             $('#sup').empty();
//
//             $('#sup').append(new Option('',''));
//             for(i=0;i<data.length;i++){
//                 $('#sup'.append('<option value ="'+data[i]+'">'+data[i].nombre_completo+'</option>'))
//             }
//         }
//     });
//
// }

function LlenarSelect(){
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


    var area=$('#area').val();
    var puesto=$('#puesto').val();
    var camp=$('#campaign').val();
    console.log(area);
    console.log(puesto);
    console.log(camp);
    $.ajax({

                url:   "admin/coor/"+area+"/"+puesto+"/"+camp,

                type:  'get',
                beforeSend: function () {
                        console.log('espere');

                },
                success:  function (data)
                {
                    console.log(data);

                    $('#sup').empty();

                    $('#sup').append(new Option('', ''));
                    for(i=0;i<data.length;i++)
                    {
                        $('#sup').append('<option value="'+data[i].id+'">'+data[i].nombre_completo+'</option>');
                    }

                }
        });

  }

  function ListaDes1(){
    opcion0=new Option("Operador de Call Center","Operador de Call Center");
    opcion1=new Option("Supervisor","Supervisor");
    opcion2=new Option("Coordinador","Coordinador");
    opcion3=new Option("Coordinador Jr","Coordinador Jr");
    //opcion4=new Option("Director","Director");
    opcion4=new Option("Gerente","Gerente");
    opcion5=new Option("Coach","Coach");
    opcion6=new Option("Comentarios","Comentarios");
    opcion7=new Option("Inbox","Inbox");
    opcion8=new Option("Procesos","Procesos");
    opcion9=new Option("Supervisor de BO/Validación","Supervisor de BO/Validación");
    

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
    opcion2=new Option("Coordinador de Calidad","Coordinador de Calidad");

    document.forms.formulario.puesto.options[0]=opcion0;
    document.forms.formulario.puesto.options[1]=opcion1;
    document.forms.formulario.puesto.options[2]=opcion2;
  }

  function ListaDes4(){
    opcion0=new Option("Analista de BO","Analista de BO","defauldSelected");
    opcion1=new Option("Jefe de BO","Jefe de BO");
    opcion2=new Option("Analista de BO (Consultas y recuperación)","Analista de BO (Consultas y recuperación)");
    opcion3=new Option("Analista de BO (Ingresos)","Analista de BO (Ingresos)");
    opcion4=new Option("Analista de BO (Proceso 1)","Analista de BO (Proceso 1)");
    opcion4=new Option("Analista de BO (Proceso 2)","Analista de BO (Proceso 2)");
    opcion5=new Option("Analista de BO (WhatsApp)","Analista de BO (WhatsApp)");
    opcion6=new Option("Analista de BO 2 (Ingresos)","Analista de BO 2 (Ingresos)");
    opcion7=new Option("Facebook AC","Facebook AC");
    opcion8=new Option("Facebook Ventas","Facebook Ventas");
        
    

    document.forms.formulario.puesto.options[0]=opcion0;
    document.forms.formulario.puesto.options[1]=opcion1;
    document.forms.formulario.puesto.options[0]=opcion2;
    document.forms.formulario.puesto.options[1]=opcion3;
    document.forms.formulario.puesto.options[0]=opcion4;
    document.forms.formulario.puesto.options[1]=opcion5;
    document.forms.formulario.puesto.options[0]=opcion6;
    document.forms.formulario.puesto.options[1]=opcion7;
    document.forms.formulario.puesto.options[1]=opcion8;
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
    opcion7=new Option("Ejecutivo de cuenta citas Sr","Ejecutivo de cuenta citas Sr");
    opcion8=new Option("Ejecutivo de cuenta entrevistas Jr","Ejecutivo de cuenta entrevistas Jr");
    opcion9=new Option("Ejecutivo de cuenta entrevistas Sr","Ejecutivo de cuenta entrevistas Sr");
    opcion10=new Option("Jefe de Reclutamiento","Jefe de Reclutamiento");


    document.forms.formulario.puesto.options[0]=opcion0;
    document.forms.formulario.puesto.options[1]=opcion1;
    document.forms.formulario.puesto.options[2]=opcion2;
    document.forms.formulario.puesto.options[0]=opcion3;
    document.forms.formulario.puesto.options[1]=opcion4;
    document.forms.formulario.puesto.options[2]=opcion5;
    document.forms.formulario.puesto.options[0]=opcion6;
    document.forms.formulario.puesto.options[1]=opcion7;
    document.forms.formulario.puesto.options[2]=opcion8;
    document.forms.formulario.puesto.options[2]=opcion9;
  }

  function ListaDes6(){
    opcion0=new Option("Programador 1","Programador 1","defauldSelected");
    opcion1=new Option("Programador 2","Programador 2");
    opcion2=new Option("Programador 3","Programador 3");
    opcion3=new Option("Becario de desarrollo","Becario de desarrollo");
    opcion4=new Option("Becario soporte","Becario soporte");
    opcion5=new Option("Jefe de desarrollo","Jefe de desarrollo");
    opcion6=new Option("Jefe de Soporte","Jefe de Soporte");
    opcion7=new Option("Técnico de soporte 1","Técnico de soporte 1");
    opcion8=new Option("Técnico de soporte 2","Técnico de soporte 2");
    

    document.forms.formulario.puesto.options[0]=opcion0;
    document.forms.formulario.puesto.options[1]=opcion1;
    document.forms.formulario.puesto.options[2]=opcion2;
    document.forms.formulario.puesto.options[3]=opcion3;
    document.forms.formulario.puesto.options[4]=opcion4;
    document.forms.formulario.puesto.options[5]=opcion5;
    document.forms.formulario.puesto.options[6]=opcion6;
    document.forms.formulario.puesto.options[5]=opcion7;
    document.forms.formulario.puesto.options[6]=opcion8;
  }

  function ListaDes7(){
    
    opcion0=new Option("Asistente Administrativo Jr","Asistente Administrativo Jr");
    opcion1=new Option("Asistente Administrativo Sr","Asistente Administrativo Sr");
    opcion2=new Option("Ayudante general","Ayudante general");
    opcion3=new Option("Becario","Becario");
    opcion4=new Option("Capturista","Capturista");
    opcion5=new Option("Gerente de RRHH","Gerente de RRHH");
    opcion6=new Option("Jefe de administración","Jefe de administracion");
    opcion7=new Option("Jefe de reclutamiento","Jefe de reclutamiento");
    opcion8=new Option("Personal de mantenimiento","Personal de mantenimiento")
    opcion9=new Option("Recepciónista","Recepcionista");
    
    //opcion3=new Option("Director","Director");
    
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

  function ListaDes8(){
    opcion0=new Option("Operador de edición","Operador de edicion","defauldSelected");
    opcion1=new Option("Jefe de edicion","Jefe de edicion");
    opcion2=new Option("Supervisor de edicion","Supervisor de edicion");
    
    document.forms.formulario.puesto.options[0]=opcion0;
    document.forms.formulario.puesto.options[0]=opcion1;
    document.forms.formulario.puesto.options[0]=opcion2;

  }

  function ListaDes9(){
    opcion0=new Option("Capacitador","Capacitador");
    opcion1=new Option("Jefe de capacitación","Jefe de capacitacion","defauldSelected");
    opcion0=new Option("Coordinador de Capacitacion","Coordinador de Capacitacion");
    
    document.forms.formulario.puesto.options[0]=opcion0;
    document.forms.formulario.puesto.options[0]=opcion1;
    document.forms.formulario.puesto.options[0]=opcion2;
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

<?php echo $__env->make('layout.admin.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>