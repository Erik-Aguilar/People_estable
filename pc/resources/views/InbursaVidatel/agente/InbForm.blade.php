@extends('layout.InbursaVidatel.agente.agente')
@section('content')

<?php
$value = Session::all();
// dd($value);


$hora=date('H:i:s');
?>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Llamada en curso...</h4>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label class="control-label" for="focusedInput">Nombre</label>
            <input class="form-control" id="nombre-asterisk" type="text" value="" disabled="" >
          </div>

          <div class="form-group">
            <label class="control-label" for="focusedInput">Teléfono</label>
            <input class="form-control" id="telefono-asterisk" type="text" value="" disabled="" >
          </div>

          <div class="form-group">
            <label class="control-label" for="focusedInput">Dirección</label>
            <input class="form-control" id="direccion-asterisk" type="text" value="" disabled="" >
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>



<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                  <button type="button" class="btn btn-info" onclick="datosastrisk()" data-toggle="modal" data-target="#myModal">Obtener datos</button>
                  {{$value['nombre_completo']}}</h3>
            </div>
            <div class="panel-body">
              {{ Form::open(['action' => 'InbursaVidatelController@FromularioInbVidatel',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario",
                              'onsubmit'=>'return validar()'
                                ]) }}

                                <div class="form-group">
                                    {{ Form::label('telefono','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('telefono','',array('class'=>"form-control",'id'=>'telefono','maxlength'=>'10','minlength'=>'10','required' => 'required')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Estatus','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::select('estatus', [
                                        'Contacto' => 'Contacto',
                                        'Nocontacto' => 'No contacto'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'onchange'=>'LlenarSelect()']  ) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Motivo','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::select('motivo', [],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'motivo','onchange'=>'motivoval()']  ) }}
                                    </div>
                                </div>

  <div id='divPass' style='display: none;'>
    <div class="form-group">
        {{ Form::label('Contraseña','',array('class'=>"col-sm-3 control-label")) }}
        <div class="col-sm-8">
            {{ Form::password('contrasena',array('class'=>"form-control",'id'=>'contra','placeholder'=>'Introdusca una contraseña valida para continuar')) }}
        </div>
    </div>
  </div>
<div id='contenido' style='display: none;'>

                                <div class="form-group">
                                    {{ Form::label('apellido paterno','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('ap_paterno','',array('class'=>"form-control",'id'=>'ap_paterno')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('apellido materno','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('ap_materno','',array('class'=>"form-control",'id'=>'ap_materno')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('nombre','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('nombre','',array('class'=>"form-control",'id'=>'nombre')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('fecha nacimiento','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::date('fecnacaseg','',array('class'=>"form-control",'id'=>'fecnacaseg')) }}
                                    </div>
                                </div>


                                <div class="form-group">
                                    {{ Form::label('Sexo','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::select('sexo', [
                                        'M' => 'Masculino',
                                        'F' => 'Femenino'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'sexo']  ) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Nombre de la persona que autoriza el seguro','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('autoriza','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'autoriza')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                  {{ Form::label('Parentesco','',array('class'=>"col-sm-3 control-label")) }}
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
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Correo Electrónico','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::email('correo','',array('class'=>"form-control",'id'=>'correo')) }}
                                    </div>
                               </div>

                               <div class="form-group">
                                   {{ Form::label('Fecha en que se hizo el movimiento','',array('class'=>"col-sm-3 control-label")) }}
                                   <div class="col-sm-8">
                                       {{ Form::date('fecha_capt',date('Y-m-d'),array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'fecha_capt')) }}
                                   </div>
                               </div>

                               <div class="form-group">
                                   {{ Form::label('Dirección','',array('class'=>"col-sm-3 control-label")) }}
                                   <div class="col-sm-8">
                                       {{ Form::text('direccion','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'direccion')) }}
                                   </div>
                               </div>

                               <div class="form-group">
                                   {{ Form::label('Número exterior','',array('class'=>"col-sm-3 control-label")) }}
                                   <div class="col-sm-8">
                                       {{ Form::text('num_ext','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'num_ext')) }}
                                   </div>
                                </div>

                               <div class="form-group">
                                   {{ Form::label('Vialidad','',array('class'=>"col-sm-3 control-label")) }}
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
                                 </div>

                                 <div class="form-group">
                                   {{ Form::label('Vivienda','',array('class'=>"col-sm-3 control-label")) }}
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
                                 </div>

                                 <div class="form-group">
                                     {{ Form::label('Número interior','',array('class'=>"col-sm-3 control-label")) }}
                                     <div class="col-sm-8">
                                         {{ Form::text('numint','',array('class'=>"form-control", 'placeholder'=>"Escribe 0 si no tiene numero interior",'id'=>'numint')) }}
                                     </div>
                                 </div>

                                 <div class="form-group">
                                     {{ Form::label('Piso','',array('class'=>"col-sm-3 control-label")) }}
                                     <div class="col-sm-8">
                                         {{ Form::text('piso','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'piso')) }}
                                     </div>
                                  </div>

                                  <div class="form-group">
                                      {{ Form::label('Tipo de asentamiento','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::select('asentamien', [
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
                                      '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'asentamien']  ) }}
                                      </div>
                                    </div>

                                    <!--  Estado , ciudad, colonia, dp-->

                                    <div class="form-group">
                                        {{ Form::label('Estado *','',array('class'=>"col-sm-3 control-label")) }}
                                        <div class="col-sm-8">
                                             {{Form::select('state',$states->prepend(''),'',['id'=>'state','class'=>'form-control','placeholder'=>'Selecciona un estado'])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('Delegación/Municipio *','',array('class'=>"col-sm-3 control-label")) }}
                                        <div class="col-sm-8">
                                             {{Form::select('town',[],'',['id'=>'town','class'=>'form-control','placeholder'=>'Selecciona una delegacion o municipio'])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('Colonia *','',array('class'=>"col-sm-3 control-label")) }}
                                        <div class="col-sm-8">
                                             {{Form::select('col',[],'',['id'=>'col','class'=>'form-control','placeholder'=>'Selecciona una colonia'])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('Código Postal *','',array('class'=>"col-sm-3 control-label")) }}
                                        <div class="col-sm-8">
                                             {{Form::select('cp',[],'',['id'=>'cp','class'=>'form-control','placeholder'=>'Selecciona una colonia'])}}
                                        </div>
                                    </div>

                                    <!-- <div class="form-group">
                                           {{ Form::label('ref 1','',array('class'=>"col-sm-3 control-label")) }}
                                           <div class="col-sm-8">
                                               {{ Form::text('ref_1','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'ref_2')) }}
                                           </div>
                                        </div> -->


                                    <div class="form-group">
                                           {{ Form::label('ref 2','',array('class'=>"col-sm-3 control-label")) }}
                                           <div class="col-sm-8">
                                               {{ Form::text('ref_2','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'ref_2','maxlength'=>'4','minlength'=>'4')) }}
                                           </div>
                                        </div>

                                        <div class="form-group" >
                                            {{ Form::label('RVT','',array('class'=>"col-sm-3 control-label")) }}
                                            <div class="col-sm-8">
                                                {{ Form::text('rvtname',$value['nombre_completo'],array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'aceptaventa')) }}
                                            </div>
                                        </div>
                                        <div class="form-group" style='display:none;'>
                                            <div class="col-sm-8">
                                                {{ Form::text('rvt',$value['user'],array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'aceptaventa')) }}
                                            </div>
                                        </div>

                                       <div class="form-group">
                                           {{ Form::label('turno','',array('class'=>"col-sm-3 control-label")) }}
                                           <div class="col-sm-8">
                                             {{ Form::select('turno', [
                                             'M' => 'MATUTINO',
                                             'V'=> 'VESPERTINO'],
                                         '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'turno']  ) }}
                                           </div>
                                        </div>

                                        <div class="form-group">
                                            {{ Form::label('Hora de inicio de la llamada de venta','',array('class'=>"col-sm-3 control-label")) }}
                                            <div class="col-sm-8">
                                                {{ Form::time('hora_ini',$hora,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                          {{ Form::label('# de pisos de la construcción','',array('class'=>"col-sm-3 control-label")) }}
                                          <div class="col-sm-8">
                                              {{ Form::text('num_pisos','',array('class'=>"form-control", 'placeholder'=>"No puede ser mayor al valor en el Capo Piso",'id'=>'num_pisos')) }}
                                          </div>
                                       </div>


                                       <div class="form-group">
                                           {{ Form::label('Numero celular','',array('class'=>"col-sm-3 control-label")) }}
                                           <div class="col-sm-8">
                                             {{ Form::text('ref_1_num','',array('class'=>"form-control",'maxlength'=>'10', 'placeholder'=>"Referencia Telefonica",'id'=>'ref_1_num')) }}
                                             <br>
                                             <label>Compañia</label>
                                             {{ Form::select('ref_1_tel', [
                                             '1' => 'TELCEL',
                                             '2' => 'IUSACELL',
                                             '3' => 'TELEFONICA MOVISTAR',
                                             '4' => 'UNEFON',
                                             '5' => 'OTRO',
                                             '6' => 'AT&amp;T',
                                             '7' => 'NEXTEL',
                                             '8' => 'VIRGIN'],
                                         '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'ref_1_tel','onchange'=>'compval()']  ) }}
                                         <br>
                                         <label>Otra compañia</label>
                                         {{ Form::text('ref_1_com','',array('class'=>"form-control",'placeholder'=>"Nombre de la otra compañia telefonica",'id'=>'ref_1_com')) }}
                                          </div>
                                        </div>

</div>
                                       <div class="form-group">
                                           <div class="col-sm-offset-6 col-sm-1">
                                               {{ Form::submit('Enviar',['class'=>"btn btn-default",'id'=>'submit']) }}
                                           </div>
                                       </div>

               {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('/assets/js/jquery-3_2_1.min.js')}}" ></script>
<script type="text/javascript">

function validar() {
    if($('#motivo').val() == 'Mascarilla no venta' || $('#motivo').val() == 'Mascarilla venta'){
    if($('#contra').val() != '16131714'){
      return false;
    }
  }
}

$("#fecnacaseg").blur(function () {
  // alert($( this ).val().substr(0,4));
  var mes = parseInt($( this ).val().substr(5,2));
  var dia = parseInt($( this ).val().substr(8,2));
  var ano = parseInt($( this ).val().substr(0,4));
  // alert('Dia: ' + dia + ' Mes: ' + mes +  ' Año: ' + ano);
  fecha_hoy = new Date();
  ahora_ano = fecha_hoy.getYear();
  ahora_mes = fecha_hoy.getMonth();
  ahora_dia = fecha_hoy.getDate();
  edad = (ahora_ano + 1900) - ano;

  if ( ahora_mes < (mes - 1)){
    edad--;
  }
  if (((mes - 1) == ahora_mes) && (ahora_dia < dia)){
    edad--;
  }
  if (edad > 1900){
    edad -= 1900;
  }
  if(edad < 18 || edad > 64 ){
      alert("Edad no permitida: " + edad + " años!");
      $( this ).val('')
  }


});

$("#telefono").change(function () {
  var url="{{URL('/Inbursa/buscar/venta/')}}" + "/" + $( this ).val();

  $.get( url, function( data ) {
    if (data>0) {
      alert("El número ya esta en la base de ventas");
      $("#telefono").val('');
    }
  });

});

</script>
<script type="text/javascript">

function datosastrisk() {
  var url="{{URL('/inbursa/llamadas/datos')}}";
  $.get( url, function( data ) {
    $("#nombre-asterisk").val(data.nombre);
    $("#telefono-asterisk").val(data.numero);
    $("#direccion-asterisk").val(data.direccion);
  });

}

function compval() {
  // console.log($('#ref_1_num').val());
  // console.log($('#ref_1_tel').val());

  if ($('#ref_1_tel').val()==5) {
    $('#ref_1_com').prop('required',true);
    $('#ref_1_com').prop('readonly',false);
  }
  else {
    $('#ref_1_com').prop('required',false);
    $('#ref_1_com').prop('readonly',true);
  }
}



function motivoval() {
// console.log($('#motivo').val());
if ($('#motivo').val()=="Mascarilla venta" || $('#motivo').val()=="Mascarilla no venta") {
  $('#divPass').attr("style",'');
  $('#contra').prop('required',true);

  $('#contenido').attr("style",'display:none');
  $("#aceptaventa").prop('disabled', true);

  $('#ap_paterno').prop('required',false);
  $('#ap_materno').prop('required',false);
  $('#nombre').prop('required',false);
  $('#fecnacaseg').prop('required',false);
  $('#sexo').prop('required',false);
  $('#autoriza').prop('required',false);
  $('#parentesco').prop('required',false);
  $('#direccion').prop('required',false);
  $('#vialidad').prop('required',false);
  $('#vivienda').prop('required',false);
  $('#asentamien').prop('required',false);
  $('#piso').prop('required',false);
  $('#state').prop('required',false);
  $('#town').prop('required',false);
  $('#col').prop('required',false);
  $('#cp').prop('required',false);
  $('#ref_2').prop('required',false);
  $('#turno').prop('required',false);
  $('#num_pisos').prop('required',false);
  $('#ref_1_num').prop('required',false);
  $('#ref_1_tel').prop('required',false);
}
  else if ($('#motivo').val()=="Venta") {
    // console.log('Si Venta');
    $('#divPass').attr("style",'display:none');
    $('#contra').prop('required',false);

    $('#contenido').attr("style",'');
    // $('#contenido').prop('required',true);
    $('#ap_paterno').prop('required',true);
    $('#ap_materno').prop('required',true);
    $('#nombre').prop('required',true);
    $('#fecnacaseg').prop('required',true);
    $('#sexo').prop('required',true);
    $('#autoriza').prop('required',true);
    $('#parentesco').prop('required',true);
    $('#direccion').prop('required',true);
    // $('#num_ext').prop('required',true);
    $('#vialidad').prop('required',true);
    $('#vivienda').prop('required',true);
    // $('#numint').prop('required',true);
    $('#asentamien').prop('required',true);
    $('#piso').prop('required',true);
    $('#state').prop('required',true);
    $('#town').prop('required',true);
    $('#col').prop('required',true);
    $('#cp').prop('required',true);
    // $('#calle_1').prop('required',true);
    // $('#calle_2').prop('required',true);
    $('#ref_2').prop('required',true);
    $('#turno').prop('required',true);
    $('#num_pisos').prop('required',true);
    $('#ref_1_num').prop('required',true);
    $('#ref_1_tel').prop('required',true);

  }
  else {

    $('#divPass').attr("style",'display:none');
    $('#contra').prop('required',false);

    // console.log('No Venta');
    $('#contenido').attr("style",'display:none');
    $("#aceptaventa").prop('disabled', true);

    $('#ap_paterno').prop('required',false);
    $('#ap_materno').prop('required',false);
    $('#nombre').prop('required',false);
    $('#fecnacaseg').prop('required',false);
    $('#sexo').prop('required',false);
    $('#autoriza').prop('required',false);
    $('#parentesco').prop('required',false);
    $('#direccion').prop('required',false);
    $('#vialidad').prop('required',false);
    $('#vivienda').prop('required',false);
    $('#asentamien').prop('required',false);
    $('#piso').prop('required',false);
    $('#state').prop('required',false);
    $('#town').prop('required',false);
    $('#col').prop('required',false);
    $('#cp').prop('required',false);
    $('#ref_2').prop('required',false);
    $('#turno').prop('required',false);
    $('#num_pisos').prop('required',false);
    $('#ref_1_num').prop('required',false);
    $('#ref_1_tel').prop('required',false);

  }

}

</script>
<script type="text/javascript">



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
        opcion8=new Option("Mascarilla venta","Mascarilla venta");
        opcion9=new Option("Mascarilla no venta","Mascarilla no venta");


        document.forms.formulario.motivo.options[0]=opcion0;
        document.forms.formulario.motivo.options[1]=opcion1;
        document.forms.formulario.motivo.options[2]=opcion2;
        document.forms.formulario.motivo.options[3]=opcion3;
        document.forms.formulario.motivo.options[4]=opcion4;
        document.forms.formulario.motivo.options[5]=opcion5;
        document.forms.formulario.motivo.options[6]=opcion6;
        document.forms.formulario.motivo.options[7]=opcion7;
        document.forms.formulario.motivo.options[8]=opcion8;
        document.forms.formulario.motivo.options[9]=opcion9;
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



</script>
@stop
