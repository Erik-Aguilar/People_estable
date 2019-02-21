@extends('layout.Inbursa.agente')

@section('content')
<?php
$value = Session::all();
#dd($value);
?>
<style>
    div{
        font-size: 12px;
    }
</style>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Estado del Agente  | {{$value['nombre_completo']}}</h3>
            </div>
            <div class="panel-body">
  				{{ Form::open(['action' => 'EstadoInbController@InsertDatos',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name' => "formulario"
                            ]) }}


                <div class="form-group">
                    {{ Form::label('Telefono','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('telefono',NULL,array('class'=>"form-control", 'placeholder'=>"",'onChange'=>'validacion(this.value)','id'=>'telefono','maxlength'=>'10')) }}

                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_telefono" style='display: none;'> Introduzca telefono a 10 digitos"</span>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_telefono2" style='display: none;'>El telefono contiene mas de 10 numeros"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Estatus','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::select('estatus', [
                        'Contacto' => 'Contacto',
                        'Nocontacto' => 'No contacto'],
                    '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'LlenarSelect()']  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Motivo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::select('motivo', [
                        ],
                    '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'motivo','onchange'=>'motivoval()']  ) }}
                    </div>
                </div>

                <div id='contenido' style='display: none;'>


                <div class="form-group">
                    {{ Form::label('Paterno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('paterno','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'paterno')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_paterno" style='display: none;'> Introduzca apellido paterno "sin espacio en blanco al iniciar ni al terminar"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Materno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('materno','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'materno')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Nombre','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('nombre','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'nombre')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_nombre" style='display: none;'> Introduzca el nombre "sin espacio en blanco al iniciar ni al terminar"</span>
                </div>


                <div class="form-group">
                    {{ Form::label('Fecha de nacimiento del titular de la póliza','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::date('fechaNacimiento','',array('class'=>"form-control", 'placeholder'=>"********",'id'=>'fechaNacimiento')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_fechaNacimiento" style='display: none;'> Fecha de nacimiento es requerida"</span>

                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_fechaNacimiento2" style='display: none;'> La edad tiene que ser mayor a 18 y menor a 65"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Sexo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::select('sexo', [
                        'M' => 'Masculino',
                        'F' => 'Femenino'],
                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'sexo']  ) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_sexo" style='display: none;'>Debe seleccionar una opción en el campo Sexo"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Nombre de la persona que autoriza el seguro','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('nombreAutoriza','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'autoriza')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_autoriza" style='display: none;'>Introduzca nombre de la persona que autoriza el seguro "sin espacio en blanco al inciar ni al terminar"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Parentesco','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::select('parentesco', [
                        'TITULAR' => 'TITULAR',
                        'ABUELA' => 'ABUELA',
                        'ABUELO'=> 'ABUELO',
                        'CUÑADA'=>'CUÑADA',
                        'CUÑADO'=>'CUÑADO',
                        'ESPOSA'=>'ESPOSA',
                        'ESPOSO'=>'ESPOSO',
                        'HERMANA'=>'HERMANA',
                        'HERMANO'=>'HERMANO',
                        'HIJA'=>'HIJA',
                        'HIJO'=>'HIJO',
                        'MADRE'=>'MADRE',
                        'PADRE'=>'PADRE',
                        'PRIMA'=>'PRIMA',
                        'PRIMO'=>'PRIMO',
                        'SOBRINA'=>'SOBRINA',
                        'SOBRINO'=>'SOBRINO',
                        'SUEGRA'=>'SUEGRA',
                        'SUEGRO'=>'SUEGRO',
                        'TIA'=>'TIA',
                        'TIO'=>'TIO',
                        'NUERA'=>'NUERA',
                        'YERNO'=>'YERNO',
                        'OTRO'=>'OTRO',
                        'NINGUNO'=>'NINGUNO'],
                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'parentesco']  ) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_parentesco" style='display: none;'>Introduzca nombre de la persona que autoriza el seguro "sin espacio en blanco al inciar ni al terminar"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Correo Electrónico','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::email('email','',array('class'=>"form-control",'id'=>'correo')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_correo" style='display: none;'>Introduzca su correo electronico</span>
                </div>


                <div class="form-group">
                    {{ Form::label('Fecha en que se hizo el movimiento','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::date('fechaMovimiento',date('Y-m-d'),array('class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly','id'=>'fechaMov')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Dirección','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('direccion','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'direccion')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_direccion" style='display: none;'>La direccion es requerida</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Número Exterior','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('num_ext','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'numExt')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_numExt" style='display: none;'>El numero exterior es requerido</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Vialidad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::select('vialidad', [
                        'AND' => 'Andador',
                        'AUT' => 'Autopista',
                        'AV'=> 'Avenida',
                        'BJD'=>'Bajada',
                        'BLV'=>'Boulrvard',
                        'CALZ'=>'Calzada',
                        'CALLE'=>'Calle',
                        'CJON'=>'Callejon',
                        'CAM'=>'Camino',
                        'CARR'=>'Carretera',
                        'CDA'=>'Cerrada',
                        'CTO'=>'Circuito',
                        'CVLN'=>'Circunvalacion',
                        'CRO'=>'Crucero',
                        'CUCH'=>'Cuchilla',
                        'DIAG'=>'Diagonal',
                        'EJE'=>'Eje',
                        'GTA'=>'Glorieta',
                        'JDN'=>'Jardin',
                        'LIB'=>'Libramiento',
                        'PRJ'=>'Paraje',
                        'PARQ'=>'Parque',
                        'PSJ'=>'Pasaje',
                        'PSO'=>'Paseo',
                        'PERIF'=>'Periferico',
                        'PZA'=>'Plaza',
                        'PRIV'=>'Privada',
                        'PROL'=>'Prolongacion',
                        'RML'=>'Ramal',
                        'RET'=>'Retorno',
                        'RCDA'=>'Rinconada',
                        'VDA'=>'Vereda',
                        'VIA'=>'VIA',
                        'VDTO'=>'Viaducto'],
                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'vialidad']  ) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_vialidad" style='display: none;'>Seleccione una opcion en el campo Vialidad</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Vivienda','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::select('vivienda', [
                        'CASA' => 'Casa',
                        'COND' => 'Condominio',
                        'DEPTO'=> 'Departamento',
                        'DPX'=>'Duplex',
                        'ED'=>'Edificio',
                        'ENT'=>'Entrada',
                        'SUITE'=>'Suite',
                        'TORRE'=>'Torre'],
                    '', [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'vivienda']  ) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_vivienda" style='display: none;'>Seleccione una opcion en el campo Vivienda</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Número interior','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('numint','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'nunInt')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_nunInt" style='display: none;'>El numero interior es requerido</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Piso','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('piso','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'piso')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_piso" style='display: none;'>El numero de piso es requerido</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Tipo de asentamiento','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::select('asentamiento', [
                        'AMPL' => 'Ampliacion',
                        'APTO' => 'Aeropuerto',
                        'BO'=> 'Barrio',
                        'CAMP'=>'Campamento',
                        'CD'=>'Ciudad',
                        'CGOLF'=>'Club de Golf',
                        'CHAB'=>'Conjunto Habitacional',
                        'CI'=>'Conjunto Industrial',
                        'CNGR'=>'Congregacion',
                        'COL'=>'Colonia',
                        'COND'=>'Centro',
                        'CURB'=>'Centro Urbano',
                        'EJ'=>'Ejido',
                        'EST'=>'Estacion',
                        'EXHDA'=>'Ex Hacienda',
                        'FINCA'=>'Finca',
                        'FRAC'=>'Fraccion',
                        'FRACC'=>'Fraccionamiento',
                        'GRNJA'=>'Granja',
                        'GU'=>'Gran Usuario',
                        'HDA'=>'Hacienda',
                        'PBO'=>'Pueblo',
                        'PCOM'=>'Poblado Comunal',
                        'PIND'=>'Parque Industrial',
                        'PTO'=>'Puerto',
                        'RCHO'=>'Rancho o Rancheria',
                        'RES'=>'Residencial',
                        'UHAB'=>'Unidad Habitacional',
                        'UNID'=>'Unidad',
                        'VILLA'=>'Villla',
                        'ZFED'=>'Zona Federal',
                        'ZIND'=>'Zona Industrial',
                        'ZRUR'=>'Zona Rural',
                        'ZURB'=>'Zona Urbana'],
                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'asentamiento']  ) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_asentamiento" style='display: none;'>Seleccione una opción en el campo Asentamiento</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Estado','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                         {{Form::select('state',$states->prepend(''),'',['id'=>'state','class'=>'form-control Fase2','placeholder'=>'Selecciona un estado'])}}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_state" style='display: none;'>Seleccione una opción en el campo Estado</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Delegacion/Municipio','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                         {{Form::select('town',[],'',['id'=>'town','class'=>'form-control Fase2','placeholder'=>'Selecciona una delegacion o municipio'])}}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_town" style='display: none;'>Seleccione una opción en el campo Delegacion/municipio</span>
                </div>
                <div class="form-group">
                    {{ Form::label('Colonia','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                         {{Form::select('col',[],'',['id'=>'col','class'=>'form-control Fase2','placeholder'=>'Selecciona una colonia'])}}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_col" style='display: none;'>Seleccione una opción en el campo Colonia</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Codigo Postal','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                         {{Form::select('cp',[],'',['id'=>'cp','class'=>'form-control Fase2','placeholder'=>'Selecciona una colonia'])}}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_cp" style='display: none;'>Seleccione una opción en el campo Codigo Postal</span>
                </div>

                <div class="form-group">
                    <div class="col-sm-8" style='text-align: center;'>
                    {{ Form::label('Entré calles','',array('class'=>"control-label")) }}
                    </div>
                </div>

                <div class="form-group">

                    {{ Form::label('Calle 1','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('calle_1','No proporciono',array('class'=>"form-control", 'placeholder'=>"",'id'=>'calle_1')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_calle_1" style='display: none;'>Es requerido el llenado de este campo </span>
                </div>

                <div class="form-group">
                    {{ Form::label('Calle 2','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('calle_2','No proporciono',array('class'=>"form-control", 'placeholder'=>"",'id'=>'calle_2')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_calle_2" style='display: none;'>Es requerido el llenado de este campo </span>
                </div>

                <div class="form-group">
                    <div class="col-sm-8" style='text-align: center;'>
                    {{ Form::label('Referencias Principales del Domicilio Asegurado','',array('class'=>"control-label")) }}
                    </div>
                </div>

                <div class="form-group">

                    {{ Form::label('Referencia 1','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">

                        {{ Form::text('ref_1','No proporciono',array('class'=>"form-control", 'placeholder'=>"",'id'=>'ref_1')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_ref_1" style='display: none;'>Es requerido el llenado de este campo </span>
                </div>

                <div class="form-group">

                    {{ Form::label('Referencia 2','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">

                        {{ Form::text('ref_2','No proporciono',array('class'=>"form-control", 'placeholder'=>"",'id'=>'ref_2')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_ref_2" style='display: none;'>Es requerido el llenado de este campo </span>
                </div>

                <div class="form-group" >
                    {{ Form::label('RVT','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('rvtname',$value['nombre_completo'],array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'aceptaventa')) }}
                    </div>
                </div>
                <div class="form-group" style='display:none;'>
                    <div class="col-sm-8">
                        {{ Form::text('rvt',$value['user'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'aceptaventa')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Turno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::select('turno', [
                        'M' => 'Matutino',
                        'V' => 'Vespertino'],
                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'turno']  ) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_turno" style='display: none;'> Seleccione una opción en el campo Turno</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Hora de inicio de la llamada de venta','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::time('hora_ini',null,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Hora de fin de la llamada de venta','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::time('hora_fin',null,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('# de pisos de la construcción','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::text('num_pisos',null,array('class'=>"form-control", 'placeholder'=>"",'title'=>'La planta baja cuenta como Piso 1','id'=>'pisos')) }}
                    </div>
                    <span class="error" id="error_pisos" style='display: none;'> El numero de pisos es requerido</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Tipo de material del techo de la vivienda','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::select('cubierta', [
                        '1' => 'Cubierta Pesada',
                        '2' => 'Cubierta ligera sin diseño',
                        '3'=> 'Cubierta ligera con diseño generico',
                        '4'=>'cubierta ligera con diseño especifico'],
                    null, ['class'=>"form-control", 'placeholder'=>"",'id'=>'cubierta']  ) }}
                    </div>
                    <span class="error" id="error_cubierta" style='display: none;'> Seleccione una opción en el campo Material del Techo</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Cuerpo de agua cercana al domicilio','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::select('tipofuente', [
                        'MAR' => 'Mar',
                        'LG' => 'Lago',
                        'LGA'=> 'Laguna',
                        'RIO'=>'Rio',
                        'NGN'=>'Ninguno'],
                    null, ['class'=>"form-control", 'placeholder'=>"",'id'=>'tipofuente']  ) }}
                    </div>
                    <span class="error" id="error_tipofuente" style='display: none;'> Seleccione una opción en el campo Cuerpo de Agua</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Distancia al cuerpo del agua','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                        {{ Form::select('linea_mar', [
                        'SI' => 'Si',
                        'NO' => 'No'],
                    null, ['class'=>"form-control", 'placeholder'=>"",'id'=>'linea_mar']  ) }}
                    </div>
                    <span class="error" id="error_linea_mar" style='display: none;'> Seleccione una opción en el campo Distancia del Cuerpo de Agua</span>
                </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-10 col-sm-1">
                        {{ Form::submit('Enviar',['class'=>"btn btn-default","onClick"=>'return valida()','id'=>'submit']) }}
                    </div>
                </div>

                {{ Form::close() }}




            </div>
        </div>
    </div>
</div>
@stop
<script>
function myFunction() {
    var mylist = document.getElementById("myList").value;
    // document.getElementById("demo").value = mylist.options[mylist.selectedIndex].value;
    // alert(mylist);
    if (mylist == 1) {
      // alert("Telcel");
      document.getElementById("demo").value = "Telcel";
      document.getElementById("demo").readOnly = true;
    }
    else if (mylist == 2) {
      // alert("Iusacel");
      document.getElementById("demo").value = "Iusacel";
      document.getElementById("demo").readOnly = true;
    }
    else if (mylist == 3) {
      // alert("Movistar");
      document.getElementById("demo").value = "Movistar";
      document.getElementById("demo").readOnly = true;
    }
    else if (mylist == 4) {
      // alert("Unefon");
      document.getElementById("demo").value = "Unefon";
      document.getElementById("demo").readOnly = true;
    }
    else if (mylist == 5) {
      document.getElementById("demo").value = "";
      document.getElementById("demo").readOnly = false;
    }

}

function valida()
{
    var espacio_blanco= /[a-z]/i;

    var fecnacaseg = $('#fechaNacimiento').val();
var now = new Date();
var mes = now.getMonth()+1;
var anio = now.getYear()+1900;
var dia = now.getDate();
var fechauno= new Date(fecnacaseg);
var fechados= new Date(anio,mes,dia);
var edad = parseInt ((fechados - fechauno)/365/24/60/60/1000);

var direccion = $("#direccion").val();
var direccion2 = direccion.split(" ");
var rest = ['ANDADOR','Andador','andador','And.','AND.', 'and.', 'and', 'And', 'AND', 'AUTOPISTA','Autopista','autopista', 'AVENIDA','Avenida','avenida','Av.','av.', 'AV.', 'av', 'Av', 'AV',
'BAJADA','Bajada','bajada', 'BOULEVAR','Boulevard','boulevard','Blvd.', 'BLVD.', 'blvd.', 'Blvd', 'BLVD', 'blvd',
'CALZADA','Calzada','calzada','Czda.', 'czda.', 'CZDA.', 'Czda', 'czda', 'CZDA', 'CALLE','Calle','calle', 'CALLEJON','Callejon','callejon',
'CAMINO','Camino','camino', 'CARRETERA','Carretera','Carr.','carretera', 'CARR.', 'carr.', 'carr', 'Carr', 'CARR',
'CERRADA','Cerrada','Cda.', 'cda.', 'CDA.', 'Cda', 'cda', 'CDA','cerrada', 'CIRCUITO','Circuito','circuito','cto.','Cto.', 'CTO.', 'cto', 'Cto', 'CTO',
'CIRCUNVALACION','Circunvalacion','circunvalacion','CIRC.','Circ.','circ.', 'CIRC', 'Circ', 'circ', 'CRUCERO','Crucero','crucero',
'CUCHILLA','Cuchilla','cuchilla', 'DIAGONAL','Diagonal','diagonal','Diag.', 'EJE','Eje','eje', 'GLORIETA','Glorieta','glorieta','Gta.', 'gta.', 'GTA.', 'Gta', 'gta', 'GTA',
'JARDIN','Jardin','jardin', 'LIBRAMIENTO','Libramiento','libramiento','LIBR.','Libr.', 'libr.', 'LIBR', 'Libr', 'libr',
'PARAJE','Paraje','paraje', 'PARQUE','Parque','parque', 'PASAJE','Pasaje','pasaje', 'PASEO','Paseo','paseo',
'PERIFERICO','Periferico','periferico','prfco.','Prfco.', 'PRFCO.', 'prfco', 'Prfco', 'PRFCO',
'PLAZA','Plaza','plaza', 'PRIVADA','Privada','privada', 'PROLONGACION','Prolongacion','prolongacion','Prol.','prol.', 'PROL.', 'Prol', 'prol', 'PROL',
'RAMAL','Ramal','ramal', 'RETORNO','Retorno','retorno', 'RINCONADA','Rinconada','rinconada', 'VEREDA','Vereda','vereda', 'VIA','Via','via',
'VIADUCTO','Viaducto','viaducto','VDTO.','Vdto.', 'vcto.', 'VDTO', 'Vdto', 'vdto','villa','Villa','VILLA','Ave','ave','Ave.','ave.','AVE','AVE.' ];

var numeroexte = $('#numExt').val();
var numeroexte2 = numeroexte.split(" ");
var restnumero = ['SN','sn','S/N','s/n','sin numero','Sin Numero','sin num.','Sin Num.','Lote','lote','LOTE','Lt.','lt.','LT.','Lt','lt','LT','Manzana','manzana','MANZANA','MZ','mz','Mz','Mz.','MZ.','mz.'];

var numeroint = $('#nunInt').val();
var numeroint2 = numeroint.split(" ");
var restnum = ['SN','sn','S/N','s/n','sin numero','Sin Numero','sin num.','Sin Num.','Lote','lote','LOTE','Lt.','lt.','LT.','Lt','lt','LT','Manzana','manzana','MANZANA','MZ','mz','Mz','Mz.','MZ.','mz.'];


    if($("#telefono").val() ==null || $("#telefono").val().length !=10 || isNaN($("#telefono").val()))
    {
        $('#error_telefono').attr("style",'display:block');
        return false;
    }
    else
    {
        $('#error_telefono').attr("style",'display:none');
    }

    if($("#motivo").val()=='Venta')
    {
        if($("#paterno").val()==null || $('#paterno').val().length==0 || /^\s+$/.test($('#paterno').val()))
            {
                $('#error_paterno').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_paterno').attr("style",'display:none');
            }

        if($("#nombre").val()==null || $('#nombre').val().length==0 || /^\s+$/.test($('#nombre').val()))
            {
                $('#error_nombre').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_nombre').attr("style",'display:none');
            }

        if($("#fechaNacimiento").val()=='' )
            {
                $('#error_fechaNacimiento').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_fechaNacimiento').attr("style",'display:none');

            }

        if(edad<18||edad>=65 )
            {
                $('#error_fechaNacimiento2').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_fechaNacimiento2').attr("style",'display:none');
            }

        if($("#sexo").val()=='' )
            {
                $('#error_sexo').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_sexo').attr("style",'display:none');
            }

        if($("#autoriza").val()==null || $('#autoriza').val().length==0 || /^\s+$/.test($('#autoriza').val()) )
            {
                $('#error_autoriza').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_autoriza').attr("style",'display:none');
            }

        if($("#parentesco").val()=='' )
            {
                $('#error_parentesco').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_parentesco').attr("style",'display:none');
            }

        if($("#correo").val()!=null && $("#correo").val()!=0)
            {
                if(!(/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/.test($("#correo").val())) )
                {
                    $('#error_correo').attr("style",'display:block');
                    return false;
                }
                else
                {
                    $('#error_correo').attr("style",'display:none');
                }
            }

        if(direccion==null || direccion.length==0 || /^\s+$/.test(direccion))
            {
                $('#error_direccion').attr("style",'display:block');
                return false;
            }
            else if(direccion!=null || direccion.length!=0)
            {
                for(var i=0;i<direccion2.length;i++)
                {
                    for(var j=0; j<rest.length; j++)
                    {
                        if (rest[j] == direccion2[i] )
                        {
                alert("No puede escribir "+ direccion2);
                 return false;    }
                 else
                    {
                        $('#error_direccion').attr("style",'display:none');}
                    }
                }

            }

        if($("#numExt").val()==null || $('#numExt').val().length==0 || /^\s+$/.test($('#numExt').val()) )
            {
                $('#error_numExt').attr("style",'display:block');
                return false;
            }
            else if($("#numExt").val()!=null || $("#numExt").length != 0)
            {
                for (var i=0; i<numeroexte2.length; i++)
                {
                    for (var j=0; j<restnumero.length; j++)
                    {
                        if (restnumero[j] == numeroexte2[i] )
                        {
                            alert("No puede escribir "+ numeroexte2);
                            return false;
                        }
                        else
                        {
                            $('#error_numExt').attr("style",'display:none');
                        }
                    }
                }

            }

        if($("#vialidad").val()=='' )
            {
                $('#error_vialidad').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_vialidad').attr("style",'display:none');
            }

        if($("#vivienda").val()=='' )
            {
                $('#error_vivienda').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_vivienda').attr("style",'display:none');
            }

        if($("#nunInt").val()!=null && $("#nunInt").val()!=0)
            if($("#nunInt").val()==null || $("#nunInt").val()==0 ||/^\s+$/.test($("#nunInt").val()))
                {
                    $('#error_nunInt').attr("style",'display:block');
                    return false;
                }
                else if($("#nunInt").val()==null || $("#nunInt").val().length !=0)
                {
                    for (var i=0; i<numeroint2.length; i++)
                    {
                        for (var j=0; j<restnum.length; j++)
                        {
                            if (restnum[j] == numeroint2[i] )
                            {
                            alert("No puede escribir "+ numeroint2);
                             return false;
                            }
                             else
                             {
                                $('#error_nunInt').attr("style",'display:none');
                            }
                        }
                    }

                }

        if($("#piso").val()==null || $("#piso").val().length==0 || isNaN($("#piso").val()))
            {
                $('#error_piso').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_piso').attr("style",'display:none');
            }

        if($("#asentamiento").val()=='' )
            {
                $('#error_asentamiento').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_asentamiento').attr("style",'display:none');
            }

        if($("#state").val()=='' )
            {
                $('#error_state').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_state').attr("style",'display:none');
            }

        if($("#town").val()=='' )
            {
                $('#error_town').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_town').attr("style",'display:none');
            }

        if($("#col").val()=='')
            {
                $('#error_col').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_col').attr("style",'display:none');
            }

        if($("#cp").val()=='' )
            {
                $('#error_cp').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_cp').attr("style",'display:none');
            }

        if($("#calle_1").val()==null || $("#calle_1").val().length==0||/^\s+$/.test($("#calle_1").val()))
            {
                $('#error_calle_1').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_calle_1').attr("style",'display:none');
            }

        if($("#calle_2").val()==null || $("#calle_2").val().length==0||/^\s+$/.test($("#calle_2").val()))
            {
                $('#error_calle_2').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_calle_2').attr("style",'display:none');
            }

        if($("#ref_1").val()==null || $("#ref_1").val().length==0||/^\s+$/.test($("#ref_1").val()))
            {
                $('#error_ref_1').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_ref_1').attr("style",'display:none');
            }

        if($("#ref_2").val()==null || $("#ref_2").val().length==0||/^\s+$/.test($("#ref_2").val()))
            {
                $('#error_ref_2').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_ref_2').attr("style",'display:none');
            }

        if($("#turno").val()=='' )
            {
                $('#error_turno').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_turno').attr("style",'display:none');
            }

        if($("#pisos").val()==null || $("#pisos").val().length==0 || isNaN($("#pisos").val()))
            {
                $('#error_pisos').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_pisos').attr("style",'display:none');
            }
         if(parseInt($('#pisos').val()) < parseInt($('#piso').val()))
            {
                alert('El piso no puede ser mayor al numero de pisos');
                return false;
            }

        if($("#cubierta").val()=='' )
            {
                $('#error_cubierta').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_cubierta').attr("style",'display:none');
            }

        if($("#tipofuente").val()=='' )
            {
                $('#error_tipofuente').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_tipofuente').attr("style",'display:none');
            }

        if($("#linea_mar").val()=='' )
            {
                $('#error_linea_mar').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_linea_mar').attr("style",'display:none');
            }

    }




}

function LlenarSelect()
      {
        var listdesp  = document.forms.formulario.estatus.selectedIndex;
        //alert(list)

        formulario.motivo.length=0;

        if(listdesp==1) ListaDes1();
        if(listdesp==2) ListaDes2();

      }

      function ListaDes1(){
        opcion0=new Option("No le interesa","No le interesa","defauldSelected");
        opcion1=new Option("Cuelga","Cuelga");
        opcion2=new Option("No cubre requisitos","No cubre requisitos");
        opcion3=new Option("Cliente molesto","Cliente molesto");
        opcion4=new Option("Lo pensara","Lo pensara");
        opcion5=new Option("Pide no volver a llamar","Pide no volver a llamar");
        opcion6=new Option("Venta caida","Venta caida");
        opcion7=new Option("Venta","Venta");


        document.forms.formulario.motivo.options[0]=opcion0;
        document.forms.formulario.motivo.options[1]=opcion1;
        document.forms.formulario.motivo.options[2]=opcion2;
        document.forms.formulario.motivo.options[3]=opcion3;
        document.forms.formulario.motivo.options[4]=opcion4;
        document.forms.formulario.motivo.options[5]=opcion5;
        document.forms.formulario.motivo.options[6]=opcion6;
        document.forms.formulario.motivo.options[7]=opcion7;
      }

      function ListaDes2(){
        opcion0=new Option("Buzón","Buzón","defauldSelected");
        opcion1=new Option("Numero inexistente","Numero inexistente");
        opcion2=new Option("No contesta","No contesta");
        opcion3=new Option("Fax","Fax");
        opcion4=new Option("Ya cuenta con el servicio","Ya cuenta con el servicio");
        opcion5=new Option("Remarcación","Remarcación");

        document.forms.formulario.motivo.options[0]=opcion0;
        document.forms.formulario.motivo.options[1]=opcion1;
        document.forms.formulario.motivo.options[2]=opcion2;
        document.forms.formulario.motivo.options[3]=opcion3;
        document.forms.formulario.motivo.options[4]=opcion4;
        document.forms.formulario.motivo.options[5]=opcion5;
      }

function validacion(val)
{
	console.log(val);
	$.ajax({

                url:   "agente/val/"+val,

                type:  'get',
                beforeSend: function () {
                        console.log('espere');

                },
                success:  function (data)
                {
	                if(data!='0')
	                {
	                	document.getElementById("telefono").value='';
	                }
                }
        });
}
</script>


<script>
function motivoval(argument) {
	if($('#motivo').val()=='Venta')
	{
		$('#contenido').attr("style",'');
	}
	else
	{
		$('#contenido').attr("style",'display:none');
		$("#aceptaventa").prop('disabled', true);
	}
	console.log($('#motivo').val());
}

//if($('#motivo').val)



function realizaProceso(valorCaja1, valorCaja2){

        var parametros = {
                "valorCaja1" : valorCaja1,
                "valorCaja2" : valorCaja2
        };
        $.ajax({
                data:  parametros,
                url:   'gethint',
                type:  'post',
                beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (data) {

                    var dhtml="";
                        for (datas in data.datos) {
                          dhtml+=' <p> Nombre: '+data.datos[datas].login+'</p>';
                        };

                    $("#resultado").html(data.resultado + " "+ data.sms+" "+dhtml);
                }
        });
}
</script>
