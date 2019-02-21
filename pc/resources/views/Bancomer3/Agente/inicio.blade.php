@extends($menu)
@section('content')
<style media="screen">
  div{
    font-size: 12px;
  }
</style>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{session('nombre_completo')}}</h3>
            </div>
            <div class="panel-body">

              {{ Form::open(['action' => 'Bancomer3Controller@Guarda',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario",
                          ]) }}
                          <!-- style="display:none" -->
                <div class="form-group"  align='Center'>
                    {{ Form::label('DN','',array('class'=>"col-sm-1 control-label")) }}
                    <div class="col-sm-2">
                        {{ Form::text('dn','',array('id'=>'dn','class'=>"form-control", 'placeholder'=>"5512345678",'required'=>'required')) }}
                    </div>
                    <div class="col-sm-1" >
                        {{ Form::button('Buscar',['class'=>"btn btn-primary", "onClick"=>"buscar()"]) }}
                    </div>
                    {{ Form::label('Tipificacion','',array('class'=>"col-sm-1 control-label")) }}
                    <div class="col-sm-2" >
                      {{ Form::select('tipificacion', [
                      'No Contacto - Buzon de voz' => 'No Contacto - Buzon de voz',
                      'No Contacto - Telefono no existe'=>'No Contacto - Telefono no existe',
                      'Se corta la llamada'=>'Se corta la llamada',
                      'Llamar despues'=>'Llamar despues',
                      'Encuesta efectiva'=>'Encuesta efectiva',
                      'Cliente Molesto'=>'Cliente Molesto',
                      'Cliente solicita no se le marque'=>'Cliente solicita no se le marque',
                      'Ya se realizo encuesta'=>'Ya se realizo encuesta',
                      'No cubre perfil'=>'No cubre perfil',
                      'No contacto con el cliente'=>'No contacto con el cliente',
                      'Telefono Equivocado'=>'Telefono Equivocado',
                      'Suspedio - Fuera de servicio'=>'Suspedio - Fuera de servicio',
                      ],
                      '', ['id'=>'tipificacion','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'tipificacion_fun()'])}}
                    </div>
                    <div class="col-sm-3" >
                        {{ Form::button('Ir a la encuesta',['class'=>"btn btn-primary", "onClick"=>"Encuesta()"]) }}
                    </div>
                </div>
                <div id="exist" style='display:none' > <!-- si encuentra dn -->
                  <div class="form-group">
                      {{ Form::label('Nombre','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('nombre','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'nombre')) }}
                      </div>
                      {{ Form::label('Nu Consecutivo','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('nu_consecutivo','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'nu_consecutivo')) }}
                      </div>
                      {{ Form::label('CR','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('cr','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'cr')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('FDE Fondeo','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('fde_fondeo','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'fde_fondeo')) }}
                      </div>
                      {{ Form::label('Firma','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('firma','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'firma')) }}
                      </div>
                      {{ Form::label('Nom Oficina','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('nom_oficina','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'nom_oficina')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Zona BH 10','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('zona_bh_10','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'zona_bh_10')) }}
                      </div>
                      {{ Form::label('Estado','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('estado','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'estado')) }}
                      </div>
                      {{ Form::label('Valor de Vivienda','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('valor_de_vivienda','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'valor_de_vivienda')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Credito Otorgado','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('credito_otorgado','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'credito_otorgado')) }}
                      </div>
                      {{ Form::label('SUBPRO','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('subpro','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'subpro')) }}
                      </div>
                      {{ Form::label('NB Promotor','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('nb_promotor','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'nb_promotor')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('NB Grupo','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('nb_grupo','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'nb_grupo')) }}
                      </div>
                      {{ Form::label('Empresa','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('empresa','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'empresa')) }}
                      </div>
                      {{ Form::label('Programa ADA','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('programa_ada','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'programa_ada')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('DUG','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-3">
                          {{ Form::text('dug','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'dug','readonly'=>'readonly')) }}
                      </div>
                      {{ Form::label('Fecha','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-2">
                        {{ Form::date('fecha',date('Y-m-d'),array('class'=>"form-control", 'placeholder'=>"********",'id'=>'fecha')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Telefono 1','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-2">
                          {{ Form::text('tel1','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel1','onClick'=>'num1()')) }}
                      </div>
                      {{ Form::label('Telefono 2','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-2">
                          {{ Form::text('tel2','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel2','onClick'=>'num2()')) }}
                      </div>
                      {{ Form::label('Telefono 3','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-2">
                          {{ Form::text('tel3','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel3','onClick'=>'num3()')) }}
                      </div>
                  </div>
                  <div class="form-group" >
                    <div class="col-sm-2" style="display:none">
                        {{ Form::text('numselect','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'numselect')) }}
                        {{ Form::text('nameNum','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'nameNum')) }}
                    </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Observaciones','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-10">
                          {{ Form::textarea('observaciones','',array('class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>
                  </div>
                  <div id="notExist" style="display:none"> <!-- No encuentra Dn -->
                    <div class="form-group">
                        {{ Form::label('Numero no encontrado','',array('class'=>"col-sm-2 control-label")) }}
                    </div>
                  </div>
                <div>
                  {{ Form::submit('Enviar',['id'=>'sendB','class'=>"btn btn-default",'onClick'=>'return validaVenta()']) }}
                </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
@stop
@section('content2')
<script>
function buscar(){
  $.ajax({
                url:   "/Bancomer_3/busca/"+$("#dn").val(),
                type:  'get',
                beforeSend: function () {
                        console.log('espere');
                },
                success:  function (data)
                {
                  console.log(data);
                  if(data != '' ){
                    $("#exist").show();
                    $("#notExist").hide();
                    $("#nombre").val(data[0]['nb_cliente']);
                    $("#nu_consecutivo").val(data[0]['nu_consecutivo']);
                    $("#cr").val(data[0]['cr']);
                    $("#fde_fondeo").val(data[0]['fde_fondeo']);
                    $("#firma").val(data[0]['f_firma']);
                    $("#nom_oficina").val(data[0]['nom_oficina']);
                    $("#zona_bh_10").val(data[0]['zona_bh_10']);
                    $("#estado").val(data[0]['estado']);
                    $("#valor_de_vivienda").val(data[0]['valor_de_la_vivienda']);
                    $("#credito_otorgado").val(data[0]['credito_otorgado']);
                    $("#subpro").val(data[0]['subpro']);
                    $("#nb_promotor").val(data[0]['nb_promotor']);
                    $("#nb_grupo").val(data[0]['nb_grupo']);
                    $("#empresa").val(data[0]['empresa']);
                    $("#programa_ada").val(data[0]['programa_ada']);
                    $("#dug").val(data[0]['dug']);
                    $("#tel1").val(data[0]['nu_tel_1']);
                    $("#tel2").val(data[0]['nu_tel_2']);
                    $("#tel3").val(data[0]['nu_tel_cel1']);

                    $("#tel1").css('background-color', '#EEEEEE');
                    $("#tel2").css('background-color', '#EEEEEE');
                    $("#tel3").css('background-color', '#EEEEEE');

                    $("#numselect").val('');


                  }else {
                    console.log('no');
                    $("#exist").hide();
                    $("#notExist").show();
                  }
                }
        });
}
function Encuesta(){
  if($("#numselect").val()!='' && $("#segmento").val()!='' && $("#mora").val()!=''){
    var vent;
    var x = screen.width/2 ;
    var y = screen.height ;
    var val=$("#credito_otorgado").val();
    console.log(val);
    var val2=parseInt(val);
    console.log(val2);
    if(val2>3000000)
    var credito='SI';
    else
    var credito='NO';

    $.when(ajax()).done(function(){
      vent='https://es.research.net/r/Irene_Hipotecario_Comercial?credito_otorgado=['+$("#credito_otorgado").val()+']&credito_mayor_3millones=['+credito+']&empresa=['+$("#empresa").val()+']&cr=['+$("#cr").val()+']&id_encuesta=['+$("#nameNum").val()+']';
      vent=window.open(vent,"ventana1", "height="+y+",width="+x+",left="+x+"");
    });


  }
  else {
      if($("#dn").val()==''){
        alert('Favor de buscar algun numero');
      }else if($("#numselect").val()==''){
        alert('Favor de seleccionar algun numero');
      }else if ($("#credito_otorgado").val()==''){
        alert('Favor de verificar que exista alguna informacion en el campo "Credito Otorgado"');
      }else if ($("#empresa").val()==''){
        alert('Favor de verificar que exista alguna informacion en el campo "Empresa"');
      }else if ($("#cr").val()=='') {
        alert('Favor de verificar que exista alguna informacion en el campo "CR"');
      }
    }
  }
  function ajax(){
    var num=$("#numselect").val();
    var newNum=num.slice(-10);
    console.log(newNum);
    console.log('|'+$("#fecha").val()+'|');
    console.log('||');

    return $.ajax({
      url:   "/Bancomer_3/audio/"+newNum+"/"+$("#fecha").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        console.log(data);
        $("#nameNum").val(data);
      },
      error:function (request, status, error) {
        alert('No se logro encontrar el audio, Favor de contactar al area de sistemas');
      }
    });
  }
function num1(){
  $("#tel1").css('background-color', '#86E487');
  $("#tel2").css('background-color', '#EEEEEE');
  $("#tel3").css('background-color', '#EEEEEE');
  $("#numselect").val($("#tel1").val());
}
function num2(){
  $("#tel1").css('background-color', '#EEEEEE');
  $("#tel2").css('background-color', '#86E487');
  $("#tel3").css('background-color', '#EEEEEE');
  $("#numselect").val($("#tel2").val());
}
function num3(){
  $("#tel1").css('background-color', '#EEEEEE');
  $("#tel2").css('background-color', '#EEEEEE');
  $("#tel3").css('background-color', '#86E487');
  $("#numselect").val($("#tel3").val());
}
function validaVenta(){
  if($("#dn").val()!=''&& $("#tipificacion").val()!='')
  $( "#sendB" ).addClass( "btn btn-default btn-block" );
  return true;
}
</script>
@stop
