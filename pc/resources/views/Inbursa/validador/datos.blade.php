@extends('layout.Inbursa.validador')
@section('content')
<?php
$value = Session::all();
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
                <h3 class="panel-title"> Validacion Inbursa</h3>
            </div>
            <div class="panel-body">
            {{ Form::open(['action' => 'ValidacionInbController@UpdateDatos',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name' => "formulario"
                            ]) }}

            	<div class="form-group">
                    {{ Form::label('Folio','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('id',$datos[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}

                    </div>

                </div>

                <div class="form-group">
                    {{ Form::label('Telefono','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('telefono',$datos[0]->telefono,array('class'=>"form-control", 'placeholder'=>"",'id'=>'telefono','maxlength'=>'10')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_telefono" style='display: none;'> Introduzca telefono a 10 digitos"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Paterno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('paterno',$datos[0]->ap_paterno,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'paterno')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_paterno" style='display: none;'> Introduzca apellido paterno "sin espacio en blanco al iniciar ni al terminar"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Materno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('materno',$datos[0]->ap_materno,array('class'=>"form-control", 'placeholder'=>"",'id'=>'materno')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Nombre','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre',$datos[0]->nombre,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'nombre')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_nombre" style='display: none;'> Introduzca el nombre "sin espacio en blanco al iniciar ni al terminar"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Fecha de nacimiento del titular de la póliza','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fechaNacimiento',$datos[0]->fecnacaseg,array('class'=>"form-control", 'placeholder'=>"********",'id'=>'fechaNacimiento')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_fechaNacimiento" style='display: none;'> Fecha de nacimiento es requerida"</span>

                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_fechaNacimiento2" style='display: none;'> La edad tiene que ser mayor a 18 y menor a 65"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Sexo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('sexo', [
                        'M' => 'Masculino',
                        'F' => 'Femenino'],
                    $datos[0]->sexo, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'sexo']  ) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_sexo" style='display: none;'>Debe seleccionar una opción en el campo Sexo"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Nombre de la persona que autoriza el seguro','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombreAutoriza',$datos[0]->autoriza,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'autoriza')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_autoriza" style='display: none;'>Introduzca nombre de la persona que autoriza el seguro "sin espacio en blanco al inciar ni al terminar"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Parentesco','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
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
                    $datos[0]->parentesco, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'parentesco']  ) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_parentesco" style='display: none;'>Introduzca nombre de la persona que autoriza el seguro "sin espacio en blanco al inciar ni al terminar"</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Correo Electrónico','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::email('email',$datos[0]->correo,array('class'=>"form-control",'id'=>'correo')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_correo" style='display: none;'>Introduzca su correo electronico</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Fecha en que se hizo el movimiento','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fechaMovimiento',$datos[0]->fecha_capt,array('class'=>"form-control", 'placeholder'=>"********",'id'=>'fechaMov')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_fechaMov" style='display: none;'>La fecha de movimiento es requerida</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Dirección','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('direccion',$datos[0]->direccion,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'direccion')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_direccion" style='display: none;'>La direccion es requerida</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Vialidad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('vialidad', [
                        'AND' => 'AND',
                        'AUT' => 'AUT',
                        'AV'=> 'AV',
                        'BJD'=>'BJD',
                        'BLV'=>'BLV',
                        'CALZ'=>'CALZ',
                        'CALLE'=>'CALLE',
                        'CJON'=>'CJON',
                        'CAM'=>'CAM',
                        'CARR'=>'CARR',
                        'CDA'=>'CDA',
                        'CTO'=>'CTO',
                        'CVLN'=>'CVLN',
                        'CRO'=>'CRO',
                        'CUCH'=>'CUCH',
                        'DIAG'=>'DIAG',
                        'EJE'=>'EJE',
                        'GTA'=>'GTA',
                        'JDN'=>'JDN',
                        'LIB'=>'LIB',
                        'PRJ'=>'PRJ',
                        'PARQ'=>'PARQ',
                        'PSJ'=>'PSJ',
                        'PSO'=>'PSO',
                        'PERIF'=>'PERIF',
                        'PZA'=>'PZA',
                        'PRIV'=>'PRIV',
                        'PROL'=>'PROL',
                        'RML'=>'RML',
                        'RET'=>'RET',
                        'RCDA'=>'RCDA',
                        'VDA'=>'VDA',
                        'VIA'=>'VIA',
                        'VDTO'=>'VDTO'],
                    $datos[0]->vialidad, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'vialidad']  ) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_vialidad" style='display: none;'>Seleccione una opcion en el campo Vialidad</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Vivienda','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('vivienda', [
                        'CASA' => 'CASA',
                        'COND' => 'COND',
                        'DEPTO'=> 'DEPTO',
                        'DPX'=>'DPX',
                        'ED'=>'ED',
                        'ENT'=>'ENT',
                        'SUITE'=>'SUITE',
                        'TORRE'=>'TORRE'],
                    $datos[0]->vivienda, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'vivienda']  ) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_vivienda" style='display: none;'>Seleccione una opcion en el campo Vivienda</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Número interior','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('numint',$datos[0]->numint,array('class'=>"form-control", 'placeholder'=>"",'id'=>'nunInt')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_nunInt" style='display: none;'>El numero interior es requerido</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Piso','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('piso',$datos[0]->piso,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'piso')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_piso" style='display: none;'>El numero de piso es requerido</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Tipo de asentamiento','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('asentamiento', [
                        'AMPL' => 'AMPL',
                        'APTO' => 'APTO',
                        'BO'=> 'BO',
                        'CAMP'=>'CAMP',
                        'CD'=>'CD',
                        'CGOLF'=>'CGOLF',
                        'CHAB'=>'CHAB',
                        'CI'=>'CI',
                        'CNGR'=>'CNGR',
                        'COL'=>'COL',
                        'COND'=>'CTRO',
                        'CURB'=>'CURB',
                        'EJ'=>'EJ',
                        'EST'=>'EST',
                        'EXHDA'=>'EXHDA',
                        'FINCA'=>'FINCA',
                        'FRAC'=>'FRAC',
                        'FRACC'=>'FRACC',
                        'GRNJA'=>'GRNJA',
                        'GU'=>'GU',
                        'HDA'=>'HDA',
                        'PBO'=>'PBO',
                        'PCOM'=>'PCOM',
                        'PIND'=>'PIND',
                        'PTO'=>'PTO',
                        'RCHO'=>'RCHO',
                        'RES'=>'RES',
                        'UHAB'=>'UHAB',
                        'UNID'=>'UNID',
                        'VILLA'=>'VILLA',
                        'ZFED'=>'ZFED',
                        'ZIND'=>'ZIND',
                        'ZRUR'=>'ZRUR',
                        'ZURB'=>'ZURB'],
                    $datos[0]->asentamien, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'asentamiento']  ) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_asentamiento" style='display: none;'>Seleccione una opción en el campo Asentamiento</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Colonia','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('colonia',$datos[0]->colonia,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'col')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_col" style='display: none;'>Es requerido el campo de Colonia</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Código postal','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('cp',$datos[0]->codpos,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'cp')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_cp" style='display: none;'>Es requerido el campo de Codigo Postal</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Ciudad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('ciudad',$datos[0]->ciudad,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'ciudad')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_ciudad" style='display: none;'>Es requerido el campo de Ciudad</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Estado','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('estado', [
                        'AGS' => 'AGS',
                        'BC' => 'BC',
                        'BCS'=> 'BCS',
                        'CAMP'=>'CAMP',
                        'COAH'=>'COAH',
                        'COL'=>'COL',
                        'CHIS'=>'CHIS',
                        'CHIH'=>'CHIH',
                        'DF'=>'DF',
                        'DGO'=>'DGO',
                        'GTO'=>'GTO',
                        'GRO'=>'GRO',
                        'HGO'=>'HGO',
                        'JAL'=>'JAL',
                        'MEX'=>'MEX',
                        'MICH'=>'MICH',
                        'MOR'=>'MOR',
                        'NAY'=>'NAY',
                        'NL'=>'NL',
                        'OAX'=>'OAX',
                        'PUE'=>'PUE',
                        'QRO'=>'QRO',
                        'QROO'=>'QROO',
                        'SLP'=>'SLP',
                        'SIN'=>'SIN',
                        'SON'=>'SON',
                        'TAB'=>'TAB',
                        'TAM'=>'TAM',
                        'TLAX'=>'TLAX',
                        'VER'=>'VER',
                        'YUC'=>'YUC',
                        'ZAC'=>'ZAC'],
                    $datos[0]->estado, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'estado']  ) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_estado" style='display: none;'>Es requerido el campo de Estado</span>
                </div>

                <div class="form-group">
                    <div class="col-sm-10" style='text-align: center;'>
                    {{ Form::label('Entré calles','',array('class'=>"control-label")) }}
                    </div>
                </div>

                <div class="form-group">

                    {{ Form::label('Calle 1','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('calle_1',$datos[0]->calle_1,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'calle_1')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_calle_1" style='display: none;'>Es requerido el llenado de este campo </span>
                </div>

                <div class="form-group">
                    {{ Form::label('Calle 2','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('calle_2',$datos[0]->calle_2,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'calle_2')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_calle_2" style='display: none;'>Es requerido el llenado de este campo </span>
                </div>

                <div class="form-group">
                    <div class="col-sm-10" style='text-align: center;'>
                    {{ Form::label('Referencias Principales del Domicilio Asegurado','',array('class'=>"control-label")) }}
                    </div>
                </div>

                <div class="form-group">

                    {{ Form::label('Referencia 1','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('ref_1',$datos[0]->ref_1,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'ref_1')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_ref_1" style='display: none;'>Es requerido el llenado de este campo </span>
                </div>

                <div class="form-group">
                    {{ Form::label('Referencia 2','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('ref_2',$datos[0]->ref_2,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'ref_2','maxlength'=>'4')) }}
                    </div>
                    <span  class="errorcol-sm-8 col-md-offset-2" id="error_ref_2" style='display: none;'>Es requerido el llenado de este campo </span>
                </div>

                <div class="form-group">
                    {{ Form::label('RVT','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('rvt',$datos[0]->rvt,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Validador','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('validador',$value['user'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('# de pisos de la construcción','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('num_pisos',$datos[0]->num_pisos,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'title'=>'La planta baja cuenta como Piso 1','id'=>'pisos')) }}
                    </div>
                    <span class="error" id="error_pisos" style='display: none;'> El numero de pisos es requerido</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Tipo de material del techo de la vivienda','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('cubierta', [
                        '1' => '1',
                        '2' => '2',
                        '3'=> '3',
                        '4'=>'4'],
                    $datos[0]->cubierta, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'cubierta']  ) }}
                    </div>
                    <span class="error" id="error_cubierta" style='display: none;'> Seleccione una opción en el campo Material del Techo</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Cuerpo de agua cercana al domicilio','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('tipofuente', [
                        'MAR' => 'MAR',
                        'LG' => 'LG',
                        'LGA'=> 'LGA',
                        'RIO'=>'RIO',
                        'NGN'=>'NGN'],
                    $datos[0]->tipofuente, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'tipofuente']  ) }}
                    </div>
                    <span class="error" id="error_tipofuente" style='display: none;'> Seleccione una opción en el campo Cuerpo de Agua</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Distancia al cuerpo del agua','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('linea_mar', [
                        'SI' => 'SI',
                        'NO' => 'NO'],
                    $datos[0]->linea_mar, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'linea_mar']  ) }}
                    </div>
                    <span class="error" id="error_linea_mar" style='display: none;'> Seleccione una opción en el campo Distancia del Cuerpo de Agua</span>
                </div>

                <div class="form-group">
                    {{ Form::label('Estatus interno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('estatus', [
                        '1' => 'VENTA',
                        '2' => 'VENTA EN PROCESO',
                        '3'=>'RECHAZO EN VALIDACION',
                        '4'=>'RECUPERAR',
                        '5'=>'RECUPERADA',
                        '6'=>'RECUPERACION FALLIADA',
                        '7'=>'CANCELADA'],
                    '', ['class'=>"form-control", 'placeholder'=>""]  ) }}
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

<script>
var clic = 0;
function agendar(){
   if(clic==0){
   document.getElementById('agenda').style.display = 'block';

   clic=1;
   } else{
       document.getElementById('agenda').style.display = 'none';
    clic = 0;
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


        if($("#col").val()==null || $('#col').val().length==0 || /^\s+$/.test($('#col').val()) )
            {
                $('#error_col').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_col').attr("style",'display:none');
            }

        if($("#cp").val()==null || $('#cp').val().length==0 || /^\s+$/.test($('#cp').val()) )
            {
                $('#error_cp').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_cp').attr("style",'display:none');
            }
        if($("#ciudad").val()==null || $('#ciudad').val().length==0 || /^\s+$/.test($('#ciudad').val()) )
            {
                $('#error_ciudad').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_ciudad').attr("style",'display:none');
            }

        if($("#estado").val()=='' )
            {
                $('#error_estado').attr("style",'display:block');
                return false;
            }
            else
            {
                $('#error_estado').attr("style",'display:none');
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






</script>
@stop
