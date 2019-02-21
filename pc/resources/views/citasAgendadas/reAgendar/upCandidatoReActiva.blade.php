@extends($menu)
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">
                {{ Form::open(['action' => 'CitasController@verCandidato',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=> "formulario"
                            ]) }}

                <div class="row">
                    <div class="col-md-10 col-md-push-2">
                        <h3>
                            {{ $user[0]->nombre}} {{$user[0]->paterno  }} {{$user[0]->materno  }}
                        </h3>
                        <div class="form-group">
                            <div class="col-sm-10">
                                {{ Form::text('id',$user[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-pull-10">
                        <img src="{{asset('storage/1.jpg')}}" class="img-responsive" style="width: 150px; height: 120px;">
                    </div>
                </div>
                <br>
                <div class="form-group">
                    {{ Form::label('Nombre(s) *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre',$user[0]->nombre,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Apellido Paterno *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('paterno',$user[0]->paterno,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Apellido Materno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('materno',$user[0]->materno,array('class'=>"form-control", 'placeholder'=>"")) }}
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
                        'Doble Turno'=>'Doble Turno'],$user[0]->turno, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Fecha de entrevista ','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fh',date("Y-m-d", strtotime($user[0]->fecha_cita)),array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Sucursal *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('sucursal', [
                        'Zapata'=>'Zapata',
                        'Roma'=>'Roma'],
                        $user[0]->sucursal, ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Hora de entrevista','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('hora_entrevista', [
                        '10:00:00'=>'10:00 am',
                        '12:00:00'=>'12:00 pm',
                        '14:00:00'=>'14:00 pm',
                        '16:00:00'=>'16:00 pm'],
                        date("H:i:s", strtotime($user[0]->fecha_cita)), ['class'=>"form-control", 'placeholder'=>""]  ) }}
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
                        'Direccion General'=>'Direccion General'],$user[0]->area, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"", "onchange"=>"LlenarSelect()"]  ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Puesto *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('puesto', [
                      'Operador de Call Center' => 'Operador de Call Center',
                      'Supervisor' => 'Supervisor',
                      'Coordinador'=>'Coordinador',
                      'Validador' => 'Validador',
                      'Jefe de Validación' => 'Jefe de Validación',
                      'Analis de Calidad'=>'Analis de Calidad',
                      'Jefe de Calidad' => 'Jefe de Calidad',
                      'Analista de BO'=>'Analista de BO',
                      'Jefe de BO'=>'Jefe de BO',
                      'Ejecutivo de cuenta'=>'Ejecutivo de cuenta',
                      'Coordinador de reclutamiento'=>'Coordinador de reclutamiento',
                      'Programador'=>'Programador',
                      'Tecnico de soporte'=>'Tecnico de soporte',
                      'Jefe de Soporte'=>'Jefe de Soporte',
                      'Jefe de desarollo'=>'Jefe de desarollo',
                      'Becario'=>'Becario',
                      'Jefe de administracion'=>'Jefe de administración',
                      'Personal de limpieza'=>'Personal de limpieza',
                      'Operador de edicion'=>'Operador de edición',
                      'Jefe de capacitación'=>'Jefe de capacitación',
                      'Capacitador'=>'Capacitador',
                      'Director'=>'Director',
                      'Recepción'=>'Recepción',
                      'Asistente Personal'=>'Asistente Personal',
                      'Ejecutivo Administrativo'=>'Ejecutivo Administrativo',
                      'Gerente'=>'Gerente',
                      'Director General'=>'Director General'],
                  $user[0]->puesto, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Teléfono','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('telefono_fijo',$user[0]->telefono_fijo,array('class'=>"form-control", 'placeholder'=>"55345678")) }}
                    </div>
                </div>
                <div class="form-group">
                   {{ Form::label('Celular','',array('class'=>"col-sm-2 control-label")) }}
                   <div class="col-sm-10">
                       {{ Form::text('telefono_cel',$user[0]->telefono_cel,array('class'=>"form-control", 'placeholder'=>"5511223344")) }}
                   </div>
               </div>
                <div class="form-group">
                    {{ Form::label('Email','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('email',$user[0]->email,array('class'=>"form-control")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Campaña','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                         {{ Form::select('campaign', [
                        'TM Prepago' => 'TM Prepago',
                        'Inbursa' => 'Inbursa',
                        'PeopleConnect' => 'PeopleConnect',
                        'PyMES' => 'PyMES',
                        'Facebook'=>'Facebook'],
                    $user[0]->campaign, ['class'=>"form-control", 'placeholder'=>""]  ) }}

                    </div>
                </div>
               <div class="form-group">
                    {{ Form::label('Experiencia *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('experiencia', [
                        'Sin experiencia' => 'Sin experiencia',
                        'Menos a 6 meses' => 'Menos a 6 meses',
                        '6 a 12 meses' => '6 a 12 meses',
                        'Mayor a 12 meses' => 'Mayor a 12 meses'],
                    $user[0]->experiencia, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>


                <div class="form-group">
                    {{ Form::label('Estatus de llamada *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('estatusLlamada', [
                        'Cita programada' => 'Cita programada',
                        'No contesta' => 'No contesta',
                        'No le interesa' => 'No le interesa'],
                    $user[0]->estatus_llamada, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                  {{ Form::label('Medio de reclutamiento *','',array('class'=>"col-sm-2 control-label")) }}
                  <div class="col-sm-10">
                    {{ Form::select('tipoMedioReclutamiento', [
                    'Volanteo' => 'Volanteo',
                    'FaceBook' => 'FaceBook',
                    'Bolsa de Trabajo' => 'Bolsa de Trabajo',
                    'Invitacion Telefonica' => 'Invitación Telefónica'],
                    $user[0]->tipo_medio_reclutamiento, ['required' => 'required','class'=>"form-control", 'placeholder'=>"","onchange"=>"LlenarMedioReclutamiento()",'id'=>'tipoMedioReclutamiento']  ) }}
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
                        'Otro'=>'Otro'],
                        $user[0]->medio_reclutamiento, ['required' => 'required','class'=>"form-control Fase1", 'placeholder'=>"", 'id'=>"medioReclutamiento"]  ) }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2" style="float:right;">
                        {{ Form::button('Primera Fase',['class'=>"btn btn-primary", "onClick"=>"Fase_2()"]) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Estatus de cita *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('estatusCita', [
                        'Se presento el candidato' => 'Se presento el candidato',
                        'No se presento el candidato' => 'No se presento el candidato'],
                    $user[0]->estatus_cita, ['required' => 'required', 'class'=>"form-control Fase2", 'placeholder'=>"", 'id'=>"Fase1"]  ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Fecha de Nacimiento *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fechaNacimiento',$user[0]->fecha_nacimiento,array('required' => 'required', 'class'=>"form-control Fase2", 'placeholder'=>"", 'id'=>"Fase2")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Sexo *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('sexo', [
                        'Mujer' => 'Mujer',
                        'Hombre' => 'Hombre'],
                    $user[0]->sexo, ['required' => 'required', 'class'=>"form-control Fase2", 'placeholder'=>"", 'id'=>"Fase2"] ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Estado civil *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('estadoCivil', [
                        'Soltero' => 'Soltero',
                        'Casado' => 'Casado',
                        'Separado' => 'Separado',
                        'Divorciado' => 'Divorciado',
                        'Viudo' => 'Viudo'],
                    $user[0]->estado_civil, ['required' => 'required', 'class'=>"form-control Fase2", 'placeholder'=>"", 'id'=>"Fase2"]) }}
                    </div>
                </div>


                 <div class="form-group">
                    {{ Form::label('Estado','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                         {{Form::select('state',$states->prepend(''),$user[0]->estado,['id'=>'state','class'=>'form-control Fase2','placeholder'=>'Selecciona un estado'])}}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Delegacion/Municipio','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                         {{Form::select('town',[$user[0]->delegacion=>$user[0]->delegacion],$user[0]->delegacion,['id'=>'town','class'=>'form-control Fase2','placeholder'=>'Selecciona una delegacion o municipio'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Colonia','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                         {{Form::select('suburb',[$user[0]->colonia=>$user[0]->colonia],$user[0]->colonia,['id'=>'col','class'=>'form-control Fase2','placeholder'=>'Selecciona una colonia'])}}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Calle y Numero','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                         {{ Form::text('street',$user[0]->calle,array('class'=>"form-control Fase2", 'placeholder'=>"")) }}

                    </div>
                </div>

                <div class="form-group" id="hijo">
                    {{ Form::label('Tiene hijos *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('tiene_hijos', [
                        'Si' => 'Si',
                        'No' => 'No'],
                    $user[0]->hijos, ['required' => 'required', 'class'=>"form-control Fase2", 'placeholder'=>"", 'id'=>"Fase2"]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-2"  style="float:right;">
                        {{ Form::button('Segunda Fase',['class'=>"btn btn-primary ", "onClick"=>"Fase_3()"]) }}
                    </div>
                </div>

                 <div class="form-group">
                    {{ Form::label('Sueldo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::number('sueldo',$user[0]->s_base,array( 'class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Sueldo complemento','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::number('sueldoComplemento',$user[0]->s_complemento,array('class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Bono Asistencia y Puntualidad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::number('bonoAsistencia',$user[0]->bono_asis_punt,array('class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Bono Calidad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::number('bonoCalidad',$user[0]->bono_calidad,array('class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Bono Productividad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::number('bonoProductividad',$user[0]->bono_productividad,array('class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Resultado de cita *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('resultadoCita', [
                        'Acepta' => 'Acepta',
                        'No acepta' => 'No acepta',
                        'En espera' => 'En espera'],
                    $user[0]->resultado_cita, ['required' => 'required', 'class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3"] ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Fecha  de Capacitación *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fechaCapacitacion',$user[0]->fecha_capacitacion,array('required' => 'required', 'class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Nombre de Capacitor *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('nombreCapacitador',$capacitadores,
                    $user[0]->nombre_capacitador, ['required' => 'required', 'class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3"] ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Estado de Capacitación *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('estadoCapacitacion', [
                        'Aceptado' => 'Aceptado',
                        'No aceptado' => 'No aceptado',
                        'En espera' => 'En espera'],
                    $user[0]->estado_capacitacion, ['required' => 'required', 'class'=>"form-control Fase3", 'placeholder'=>"", 'id'=>"Fase3"] ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Fotografía','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::file('foto',['class'=>"form-control"] ) }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">

                        {{ Form::submit('Enviar',['class'=>"btn btn-default",'onClick'=>'return confirm("seguro que desea guardar la información")']) }}
                    </div>
                </div>
                {{ Form::close() }}

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

      document.forms.formulario.puesto.options[0]=opcion0;
      document.forms.formulario.puesto.options[1]=opcion1;
      document.forms.formulario.puesto.options[2]=opcion2;
      document.forms.formulario.puesto.options[3]=opcion3;
      document.forms.formulario.puesto.options[4]=opcion4;
      //document.forms.formulario.puesto.options[5]=opcion5;
    }

    function ListaDes2(){
      opcion0=new Option("Validador","Validador","defauldSelected");
      //opcion1=new Option("Jefe de Validación","Jefe de Validacion");

      document.forms.formulario.puesto.options[0]=opcion0;
      //document.forms.formulario.puesto.options[1]=opcion1;
    }

    function ListaDes3(){
      opcion0=new Option("Analista de Calidad","Analis de Calidad","defauldSelected");
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

      document.forms.formulario.puesto.options[0]=opcion0;
      document.forms.formulario.puesto.options[1]=opcion1;
      document.forms.formulario.puesto.options[2]=opcion2;
      document.forms.formulario.puesto.options[3]=opcion3;
      document.forms.formulario.puesto.options[4]=opcion4;
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

@section('content2')
<script>

@if($hijos)

        var contador=0;

        $('<div class="form-group hijodato'+contador+'s" id="hijonombre'+contador+'"></div>').insertAfter('#hijo');
            $('<label class="col-sm-2 control-label hijodato'+contador+'s" id="hijo'+contador+'">Nombre</label>').appendTo('#hijonombre'+contador+'');
            $('<div class="col-sm-10 hijodato'+contador+'s" id="hijo'+contador+'nombre"></div>').appendTo('#hijonombre'+contador+'');
            $('<input type="text" class="form-control Fase2 hijodato'+contador+'s" id="hijo'+contador+'n" name="nombrehijo'+contador+'" value="{{$hijos[0]->nombre}}"></input>').appendTo('#hijo'+contador+'nombre');


            $('<div class="form-group hijodato'+contador+'s" id="hijofecha'+contador+'"></div>').insertAfter('#hijonombre'+contador+'');
            $('<label class="col-sm-2 control-label hijodatos" id="hijo'+contador+'l">fecha de necimiento</label>').appendTo('#hijofecha'+contador+'');
            $('<div class="col-sm-10 hijodato'+contador+'s" id="hijo'+contador+'f"></div>').appendTo('#hijofecha'+contador+'');
            $('<input type="date" class="form-control Fase2 hijodato'+contador+'s" id="hijo'+contador+'c" name="fechahijo'+contador+'" value="{{$hijos[0]->cumple}}"></input>').appendTo('#hijo'+contador+'f');

{!! $cont=1; !!}
    @for ($i=1;$i<count($hijos);$i++)

            contador++;

            $('<div class="form-group hijodato'+contador+'s" id="hijonombre'+contador+'"></div>').insertAfter('#hijofecha'+(contador-1)+'');
            $('<label class="col-sm-2 control-label hijodato'+contador+'s" id="hijo'+contador+'">Nombre</label>').appendTo('#hijonombre'+contador+'');
            $('<div class="col-sm-10 hijodato'+contador+'s" id="hijo'+contador+'nombre"></div>').appendTo('#hijonombre'+contador+'');
            $('<input type="text" class="form-control Fase2 hijodato'+contador+'s" id="hijo'+contador+'n" name="nombrehijo'+contador+'" value="{{$hijos[$i]->nombre}}"></input>').appendTo('#hijo'+contador+'nombre');


            $('<div class="form-group hijodato'+contador+'s" id="hijofecha'+contador+'"></div>').insertAfter('#hijonombre'+contador+'');
            $('<label class="col-sm-2 control-label hijodatos" id="hijo'+contador+'l">fecha de necimiento</label>').appendTo('#hijofecha'+contador+'');
            $('<div class="col-sm-10 hijodato'+contador+'s" id="hijo'+contador+'f"></div>').appendTo('#hijofecha'+contador+'');
            $('<input type="date" class="form-control Fase2 hijodato'+contador+'s" id="hijo'+contador+'c" name="fechahijo'+contador+'" value="{{$hijos[$i]->cumple}}"></input>').appendTo('#hijo'+contador+'f');



        {!! $cont++; !!}

    @endfor

        $('<div class="form-group hijodato0s" id="hijoboton"></div>').insertAfter('#hijofecha'+contador+'');
        $('<div class="col-sm-10" id="hijocont"></div>').appendTo('#hijoboton')
        $('<input type="button" class="btn btn-primary  hijodato0s" id="hijo1b" value="+" onClick="add();"></input>' ).appendTo('#hijocont');
        $('<input type="button" class="btn btn-primary  hijodato0s" id="hijo2b" value="-" onClick="dcm();" name="check"></input>' ).appendTo('#hijocont');

@endif

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

    if('{{$user[0]->tipo_medio_reclutamiento}}'==='Bolsa de Trabajo')
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
@stop
stop
