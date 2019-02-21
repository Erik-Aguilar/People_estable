<?php
$user = Session::all();
?>
@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Nuevo Candidato</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'RhController@NuevoCandidato',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=> "formulario"
                                ]) }}

                <div class="form-group">
                    {{ Form::label('Nombre *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Paterno *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('paterno','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Materno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('materno','',array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('En caso de emergencia llamar a','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('nom_emergencia1',null,array('class'=>"form-control", 'placeholder'=>"Nombre del Contacto Emergencia 1")) }}
                        {{ Form::number('emergencia1',null,array('class'=>"form-control", 'placeholder'=>"Telefono 1")) }}
                        {{ Form::text('nom_emergencia2',null,array('class'=>"form-control", 'placeholder'=>"Nombre del Contacto Emergencia 2")) }}
                        {{ Form::number('emergencia2',null,array('class'=>"form-control", 'placeholder'=>"Telefono 2")) }}

                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Área *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('area', [
                        'Operaciones' => 'Operaciones',
                        'Validación' => 'Validación',
                        'Calidad' => 'Calidad',
                        'Back-Office' => 'Back-Office',
                        'Reclutamiento' => 'Reclutamiento',
                        'Sistemas' => 'Sistemas',
                        'Administración' => 'Administración',
                        'Edición' => 'Edición',
                        'Capacitación' => 'Capacitación',
                      'Director General'=>'Director General',
                      'Recursos Humanos'=>'Recursos Humanos'],
                    '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"", "onchange"=>"LlenarSelect()"]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Puesto *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('puesto', [
                        'Operador de Call Center' => 'Operador de Call Center',
                        'Supervisor' => 'Supervisor',
                        'Coordinador'=>'Coordinador'],
                    '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Turno *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('turno', [
                        'Matutino' => 'Matutino',
                        'Vespertino' => 'Vespertino',
                        'Turno Completo (M)' => 'Turno Completo (M)',
                        'Turno Completo (V)' => 'Turno Completo (V)',
                        'Doble Turno' => 'Doble Turno'],
                    '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Telefono celular','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::number('telefono_cel','',array('class'=>"form-control", 'placeholder'=>"5512345678",'id'=>'cel')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Telefono Fijo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::number('telefono_fijo','',array('class'=>"form-control", 'placeholder'=>"55345678",'id'=>'tel')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Estatus de llamada *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('estatusLlamada', [
                        'Cita programada' => 'Cita programada',
                        'No contesta' => 'No contesta',
                        'No le interesa' => 'No le interesa'],
                    null, ['required' => 'required', 'class'=>"form-control Fase1", 'placeholder'=>"", 'id'=>"Fase1"]  ) }}
                    </div>
                </div>

                <div class="form-group">
                  {{ Form::label('Medio de reclutamiento *','',array('class'=>"col-sm-2 control-label")) }}
                  <div class="col-sm-10">
                    {{ Form::select('tipoMedioReclutamiento', [
                    'Volanteo' => 'Volanteo',
                    'FaceBook Pagado' => 'FaceBook Pagado',
                    'FaceBook Gratuito' => 'FaceBook Gratuito',
                    'Bolsa de Trabajo' => 'Bolsa de Trabajo',
                    'Invitacion Telefonica' => 'Invitación Telefónica'],
                    null, ['required' => 'required','class'=>"form-control", 'placeholder'=>"","onchange"=>"LlenarMedioReclutamiento()",'id'=>'tipoMedioReclutamiento']  ) }}
                  </div>
                </div>

                <div class="form-group" style='display: none;' id='medioRecluta'>
                    {{ Form::label('Bolsas de trabajo *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('medioReclutamiento', [
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
                        null, ['required' => 'required','class'=>"form-control Fase1", 'placeholder'=>"", 'id'=>"medioReclutamiento"]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Fecha de entrevista','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fh','',array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                  {{ Form::label('Sucursal *','',array('class'=>"col-sm-2 control-label")) }}
                  <div class="col-sm-10">
                    {{ Form::select('sucursal', [
                    'Sevilla'=>'Sevilla'],
                    null, ['required' => 'required','class'=>"form-control", 'placeholder'=>"",'onchange'=>'ponSucursal(this.form)']  ) }}
                  </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Hora de entrevista','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('hora_entrevista', [],
                        null, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>




                <div class="form-group">
                    {{ Form::label('Ejecutivo de Reclutamiento','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('ejecReclutamiento',$reclutadores,
                        null, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {{ Form::submit('Enviar',['class'=>"btn btn-primary",'onClick'=>'ValTel()']) }}
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
<script>
var horas = new Array
horas[1] = ["","09:30","10:30","11:30","12:30","13:30","14:30","15:30","16:30","17:30"]
horas[2] = ["","09:30","10:30","11:30","12:30","13:30","14:30","15:30","16:30","17:30"]
function ponSucursal(formu)
{	var elSucursal = formu.sucursal.selectedIndex
	formu.hora_entrevista.length = horas[elSucursal].length
	for (i=0; i<formu.hora_entrevista.length; i++)
	{	formu.hora_entrevista.options[i].text = horas[elSucursal][i]
	}
}
</script>

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
      opcion0=new Option("Operador de Call Center","Operador de Call Center");
      opcion1=new Option("Supervisor","Supervisor");
      opcion2=new Option("Coordinador","Coordinador");
      opcion3=new Option("Coordinador Jr","Coordinador Jr");
      //opcion4=new Option("Director","Director");
      opcion4=new Option("Gerente","Gerente");

      document.forms.formulario.puesto.options[0]=opcion0;
      document.forms.formulario.puesto.options[1]=opcion1;
      document.forms.formulario.puesto.options[2]=opcion2;
      document.forms.formulario.puesto.options[3]=opcion3;
      document.forms.formulario.puesto.options[4]=opcion4;
      //document.forms.formulario.puesto.options[5]=opcion5;
    }

    function ListaDes2(){
      opcion0=new Option("Validador","Validador","defauldSelected");
      // opcion1=new Option("Jefe de Validación","Jefe de Validacion");

      document.forms.formulario.puesto.options[0]=opcion0;
      // document.forms.formulario.puesto.options[1]=opcion1;
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
@stop
