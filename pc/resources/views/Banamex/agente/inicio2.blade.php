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
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

              {{ Form::open(['action' => 'BanamexController@Guarda',
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
                      'No Contacto - Buzon de voz personal' => 'No Contacto - Buzon de voz personal',
                      'No Contacto - Buzon de voz empresa' => 'No Contacto - Buzon de voz empresa',
                      'No Contacto - Telefono no existe'=>'No Contacto - Telefono no existe',
                      'Se corta la llamada'=>'Se corta la llamada',
                      'No le interesa - No tiene tiempo'=>'No le interesa - No tiene tiempo',
                      'No le interesa - Cuelga llamada'=>'No le interesa - Cuelga llamada',
                      'No cubre el perfil'=>'No cubre el perfil',
                      'Llamar despues'=>'Llamar despues',
                      'No le interesa - Mala experiencia con los bancos'=>'No le interesa - Mala experiencia con los bancos',
                      'No le interesa - No quiere adquirir productos'=>'No le interesa - No quiere adquirir productos',
                      'No le interesa - Mala experiencia con Banamex'=>'No le interesa - Mala experiencia con Banamex',
                      'No le interesa - Problemas con buro'=>'No le interesa - Problemas con buro',
                      'No le interesa - Producto poco atractivo'=>'No le interesa - Producto poco atractivo',
                      'Venta - Validada'=>'Venta - Validada',
                      'Venta - No Validada'=>'Venta - No Validada'
                      ],
                      '', ['id'=>'tipificacion','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'tipificacion_fun()'])}}
                    </div>

                    <div id="valida" style="display: none">
                      <div class="form-group" >
                        <div class="col-sm-2">
                          {{ Form::text('empleadoVal','',array('id'=>'numEmpleado','required'=>'required','class'=>"form-control", 'placeholder'=>"Usuario",'onChange'=>'valAjax()')) }}
                        </div>
                        <div class="col-sm-2">
                          {{ Form::password('password',['required'=>'required','id'=>'numPass','class'=>'form-control','placeholder'=>'Password','onChange'=>'valAjax()']) }}
                        </div>
                        <div class="btn btn-success glyphicon glyphicon-ok" id='success' style="display: none">
                        </div>
                        <div class="btn btn-danger glyphicon glyphicon-remove" id='wrong' style="display: none">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-10" style="display: none">
                          {{ Form::text('valVenta','',array('id'=>'valVenta','required'=>'required','class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                        </div>
                      </div>
                    </div>

                </div>
                <div id="exist" style="display:none"> <!-- si encuentra dn -->
                  <div class="form-group">
                      {{ Form::label('Nombre','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-10">
                          {{ Form::text('nombre','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'nombre')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Direccion','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('direccion','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'direccion')) }}
                      </div>
                      {{ Form::label('Colonia','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('colonia','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'colonia')) }}
                      </div>
                  </div>

                  <div class="form-group">
                      {{ Form::label('CP','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('cp','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'cp')) }}
                      </div>
                      {{ Form::label('Delegacion/Municipio','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('delegacion','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'delegacion')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Ciudad','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('ciudad','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'ciudad')) }}
                      </div>
                      {{ Form::label('Estado','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('estado','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'estado')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Telefono Casa','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('tel_casa','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel_casa','onClick'=>'tel_casa_color()')) }}
                      </div>
                      {{ Form::label('Telefono Oficina','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('tel_oficina','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel_oficina','onClick'=>'tel_oficina_color()')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Telefono Casa2','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('tel_casa2','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel_casa2','onClick'=>'tel_casa_color2()')) }}
                      </div>
                      {{ Form::label('movil','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('tel_oficina','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'movil','onClick'=>'tel_movil_color()')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('movil2','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('movil2','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'movil2','onClick'=>'tel_movil2_color()')) }}
                      </div>
                      {{ Form::label('tel_otro','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('tel_otro','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel_otro','onClick'=>'tel_otro_color()')) }}
                      </div>

                  </div>
                  <div class="form-group">
                      {{ Form::label('Sexo','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('sexo','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'sexo')) }}
                      </div>
                      {{ Form::label('Tarjeta','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('tarjeta','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tarjeta')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Banco','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('banco','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'banco')) }}
                      </div>
                      {{ Form::label('¿Conoce al titular?','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4" >
                        {{ Form::select('conoce_titular', [
                        'Si' => 'Si',
                        'No' => 'No'
                        ],
                        '', ['id'=>'con_tit', 'class'=>"form-control", 'placeholder'=>""])}}
                      </div>
                  </div>
                  <div class="form-group" id='correodiv'>
                      {{ Form::label('Correo','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::email('email_co','',array('class'=>"form-control",'required'=>'required', 'placeholder'=>"",'id'=>'correo')) }}
                      </div>
                  <div class="form-group" id="tipoTarjeta_codiv">
                    {{ Form::label('¿Tienes alguna tarjeta de credito?(no nómina o débito) ','',array('class'=>"col-sm-2   control-label")) }}
                      <div class="col-sm-4">
                        {{ Form::select('tipoTarjeta_co', [
                        'Bancarias'=>array(
                        'American Express'=>'American Express',
                        'Citibanamex'=>'Citibanamex',
                        'Banca Afirme'=>'Banca Afirme',
                        'Banco de Bajito'=>'Banco de Bajito',
                        'Banco ge Capital'=>'Banco ge Capital',
                        'Banco Mifel'=>'Banco Mifel',
                        'Banco Union'=>'Banco Union',
                        'Banjercito'=>'Banjercito',
                        'Banorte'=>'Banorte',
                        'Banregio'=>'Banregio',
                        'BBVA Bancomer'=>'BBVA Bancomer',
                        'Citi Bank'=>'Citi Bank',
                        'HSBC'=>'HSBC',
                        'Inbursa'=>'Inbursa',
                        'Invex'=>'Invex',
                        'Ixe Banco'=>'Ixe Banco',
                        'Santander - Serfin'=>'Santander - Serfin',
                        'Scotiabank Inverlat'=>'Scotiabank Inverlat'),
                        'Departamentales'=>array(
                        'CyA'=>'CyA',
                        'Comercial Mexicana'=>'Comercial Mexicana',
                        'Credimatico'=>'Credimatico',
                        'Fabricas de Francia'=>'Fabricas de Francia',
                        'HEB'=>'HEB',
                        'Hermanos Vazquez'=>'Hermanos Vazquez',
                        'Liverpool'=>'Liverpool',
                        'Palacio de Hierro'=>'Palacio de Hierro',
                        'Sears'=>'Sears',
                        'Soriana'=>'Soriana',
                        'Suburbia'=>'Suburbia',
                        'Walmart'=>'Walmart',
                        'Woolworth'=>'Woolworth',
                        'Otros'=>'Otros')],
                        '', ['id'=>'tipoTarjeta_co', 'class'=>"form-control", 'placeholder'=>"",'required'=>'required']  ) }}
                      </div>
                    </div>
                    <div class="form-group" >
                      <div class="col-sm-2" style="display:none">
                          {{ Form::text('numselect','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'numselect')) }}
                      </div>
                    </div>
                  </div>
                <!-- <div class="col-sm-4">
                    {{ Form::text('test','1',array('id'=>'test','class'=>"form-control", 'placeholder'=>"")) }}
                </div> -->
                <div id="send" style="display:none">
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
  $(document).ready(function(){
    //c_new
    var validaEnviar='si';
    $("#correo").prop('disabled', true);
    $("#correodiv").hide();
    $("#tipoTarjeta_co").prop('disabled', true);
    $("#tipoTarjeta_codiv").hide();
    $("#numEmpleado").prop('disabled', true);
    $("#numPass").prop('disabled', true);

      $("#c_new").prop('disabled', true);
      $("#nombre_new").prop('disabled', true);
      $("#paterno_new").prop('disabled', true);
      $("#materno_new").prop('disabled', true);
      $("#tel1_new").prop('disabled', true);
      $("#tel2_new").prop('disabled', true);
      $("#calle_new").prop('disabled', true);
      $("#numExt_new").prop('disabled', true);
      $("#numInt_new").prop('disabled', true);
      $("#cp_new").prop('disabled', true);
      $("#colonia_new").prop('disabled', true);
      $("#delegacion_new").prop('disabled', true);
      $("#ciudad_new").prop('disabled', true);
      $("#estado_new").prop('disabled', true);
      $("#sexo_new").prop('disabled', true);
      $("#tarjeta_new").prop('disabled', true);
      $("#banco_new").prop('disabled', true);
      $("#c_objetivo").prop('disabled', true);
      $("#cContrata_new").prop('disabled', true);
      $("#tipoTarjetaSolicita_co").prop('disabled', true);
    //field c_obletivo anableb
      $("#email_co").prop('disabled', true);
      $("#confirmEmail_co").prop('disabled', true);
      $("#nombre_co").prop('disabled', true);
      $("#paterno_co").prop('disabled', true);
      $("#materno_co").prop('disabled', true);
      $("#diaNacimiento_co").prop('disabled', true);
      $("#mesNacimiento_co").prop('disabled', true);
      $("#yearNacimiento_co").prop('disabled', true);
      $("#rfc_co").prop('disabled', true);
      $("#homoclave_co").prop('disabled', true);
      $("#telCelular_co").prop('disabled', true);
      $("#calle_co").prop('disabled', true);
      $("#noExt_co").prop('disabled', true);
      $("#noInt_co").prop('disabled', true);
      $("#cp_co").prop('disabled', true);
      $("#colonia_co").prop('disabled', true);
      $("#tipoVivienda_co").prop('disabled', true);
      $("#tiempoResidencia_co").prop('disabled', true);
      $("#ladaDomi_co").prop('disabled', true);
      $("#telDom_co").prop('disabled', true);
      $("#tipoTarjeta_co").prop('disabled', true);
      $("#numeroTarjeta_co").prop('disabled', true);
      $("#creditoHipo_co").prop('disabled', true);
      $("#creditoAuto_co").prop('disabled', true);
      $("#nombreEmpresa_co").prop('disabled', true);
      $("#giroEmpresa_co").prop('disabled', true);
      $("#ocupacion_co").prop('disabled', true);
      $("#antiguedad_co").prop('disabled', true);
      $("#ingresos_co").prop('disabled', true);
      $("#calleEmpleo_co").prop('disabled', true);
      $("#numExt_co").prop('disabled', true);
      $("#numInt_co").prop('disabled', true);
      $("#cpEmpleo_co").prop('disabled', true);
      $("#coloniaEmpleo_co").prop('disabled', true);
      $("#nacionalidad_co").prop('disabled', true);
      $("#lugarNaci_co").prop('disabled', true);
      $("#genero_co").prop('disabled', true);
      $("#estadoCivil_co").prop('disabled', true);
      $("#escolaridad_co").prop('disabled', true);
      $("#depEconomicos_co").prop('disabled', true);
      $("#refNombre_co").prop('disabled', true);
      $("#refApellidos_co").prop('disabled', true);
      $("#lada_co").prop('disabled', true);
      $("#refTel_co").prop('disabled', true);
      $("#extensionRef_co").prop('disabled', true);

    var cont=0;
    var yearf={{date('Y')-18}};
    var yeari=yearf-75;
    for(cont=1;cont<=31;cont++){
      $('#diaNacimiento_co').append('<option value="'+cont+'">'+cont+'</option>');
    }

    for(yeari;yeari<=yearf;yeari++){
      $('#yearNacimiento_co').append('<option value="'+yeari+'">'+yeari+'</option>');
    }

  });
  function address(){
    $.ajax({
      url:   "banamex/dir/"+$("#cp_co").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        $('#colonia_co').html('');
        for(i=0;i<data.length;i++)
    		{
          $('#colonia_co').append('<option value="'+data[i].asentamiento+'">'+data[i].asentamiento+'</option>');
    		}
      }
    });
  }
  function address2(){
    $.ajax({
      url:   "banamex/dir/"+$("#cp_new").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        $('#colonia_new').html('');
        $('#colonia_new').append('<option value=""></option>');
        for(i=0;i<data.length;i++)
    		{
          $('#colonia_new').append('<option value="'+data[i].asentamiento+'">'+data[i].asentamiento+'</option>');
    		}
      }
    });
  }
  function address21(){
    $.ajax({
      url:   "banamex/dir/"+$("#cpEmpleo_co").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        $('#coloniaEmpleo_co').html('');
        $('#coloniaEmpleo_co').append('<option value=""></option>');
        for(i=0;i<data.length;i++)
    		{
          $('#coloniaEmpleo_co').append('<option value="'+data[i].asentamiento+'">'+data[i].asentamiento+'</option>');
    		}
      }
    });
  }
  function address3(){
    $.ajax({
      url:   "banamex/col/"+encodeURIComponent($("#colonia_new").val())+"/"+$("#cp_new").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        console.log(data);
        $('#delegacion_new').html('');
        $('#delegacion_new').append('<option value=""></option>');
        for(i=0;i<data.length;i++)
    		{
          $('#delegacion_new').append('<option value="'+data[i].municipio+'">'+data[i].municipio+'</option>');
    		}
      }
    });
  }
  function address4(){
    $.ajax({
      url:   "banamex/del/"+encodeURIComponent($("#delegacion_new").val())+"/"+encodeURIComponent($("#colonia_new").val())+"/"+$("#cp_new").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        console.log(data[0].ciudad);
        $('#ciudad_new').html('');
        $('#ciudad_new').append('<option value=""></option>');
        for(i=0;i<data.length;i++)
    		{
          $('#ciudad_new').append('<option value="'+data[i].ciudad+'">'+data[i].ciudad+'</option>');
    		}
      }
    });
  }
  function address5(){
    $.ajax({
      url:   "banamex/ciu/"+encodeURIComponent($("#ciudad_new").val())+"/"+encodeURIComponent($("#delegacion_new").val())+"/"+encodeURIComponent($("#colonia_new").val())+"/"+$("#cp_new").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        $('#estado_new').html('');
        $('#estado_new').append('<option value=""></option>');
        for(i=0;i<data.length;i++)
    		{
          $('#estado_new').append('<option value="'+data[i].estado+'">'+data[i].estado+'</option>');
    		}
      }
    });
  }
  function validaFecha(){
    if($("#diaNacimiento_co").val()!='' && $("#mesNacimiento_co").val()!='' && $("#yearNacimiento_co").val()!=''){
      $.ajax({
        url:   "banamex/validaFecha/"+$("#diaNacimiento_co").val()+"/"+$("#mesNacimiento_co").val()+'/'+$("#yearNacimiento_co").val(),
        type:  'get',
        beforeSend: function () {
          console.log('espere');
        },
        success:  function (data)
        {
          console.log(data);
          if(data == '0' ){
            $('#diaNacimiento_co').css('color','red');
            $('#mesNacimiento_co').css('color','red');
            $('#yearNacimiento_co').css('color','red');
          }else{
            $('#diaNacimiento_co').css('color','black');
            $('#mesNacimiento_co').css('color','black');
            $('#yearNacimiento_co').css('color','black');
          }
        }
      });
    }
  }

  function BuscarDos() {

    // alert("{{URL('/conaliteg/getDataCall')}}");
    $.get("{{URL('/banamex/datos')}}", function (data) {
        $("#dn").val(data.number);
        buscar();
    })

  }
  function buscar(){
    $.ajax({
                  url:   "banamex/busca/"+$("#dn").val(),
                  type:  'get',
                  beforeSend: function () {
                          console.log('espere');
                  },
                  success:  function (data)
                  {
                    console.log(data);
                    if(data != '' ){
                      var tar=data[0]['tarjeta'];
                      if(tar==16)
                      var res=tar.substring(12,16);
                      else
                      var res=tar;

                      // console.log(tar);

                      $("#exist").show();
                      $("#notExist").hide();
                      $("#c_objetivo").prop('disabled', false);
                      $("#nombre").val(data[0]['nombre']);
                      $("#direccion").val(data[0]['direccion']);
                      $("#colonia").val(data[0]['colonia']);
                      $("#cp").val(data[0]['cp']);
                      $("#delegacion").val(data[0]['del_muni']);
                      $("#ciudad").val(data[0]['ciudad']);
                      $("#estado").val(data[0]['estado']);
                      $("#tel_casa").val(data[0]['tel_casa']);
                      $("#tel_casa2").val(data[0]['tel_casa2']);
                      $("#tel_oficina").val(data[0]['tel_oficina']);
                      $("#tel_otro").val(data[0]['tel_otro']);
                      $("#movil").val(data[0]['movil']);
                      $("#movil2").val(data[0]['movil2']);
                      $("#sexo").val(data[0]['sexo']);
                      $("#tarjeta").val(res);
                      $("#banco").val(data[0]['banco']);

                      $("#tel_casa").css('background-color', '#EEEEEE');
                      $("#tel_oficina").css('background-color', '#EEEEEE');
                      $("#tel_casa2").css('background-color', '#EEEEEE');
                      $("#movil").css('background-color', '#EEEEEE');
                      $("#movil2").css('background-color', '#EEEEEE');
                      $("#tel_otro").css('background-color', '#EEEEEE');


                      $("#numselect").val('');

                      console.log(data[0]['nombre']);
                    }
                    else {
                      console.log('no');
                      $("#exist").hide();
                      $("#notExist").show();

                      $("#tel_casa").css('background-color', '#EEEEEE');
                      $("#tel_oficina").css('background-color', '#EEEEEE');
                      $("#tel_casa2").css('background-color', '#EEEEEE');
                      $("#movil").css('background-color', '#EEEEEE');
                      $("#movil2").css('background-color', '#EEEEEE');
                      $("#numselect").val('');
                    }
                  }
          });
  }
  function c_objetivoFun(){
    if($("#c_objetivo").val()=='Si'){
      $("#cos").show();
      $("#con").hide();
      //field new client disableb
        $("#c_new").prop('disabled', true);
        $("#cContrata_new").prop('disabled', true);
        $("#nombre_new").prop('disabled', true);
        $("#paterno_new").prop('disabled', true);
        $("#materno_new").prop('disabled', true);
        $("#tel1_new").prop('disabled', true);
        $("#tel2_new").prop('disabled', true);
        $("#calle_new").prop('disabled', true);
        $("#numExt_new").prop('disabled', true);
        $("#numInt_new").prop('disabled', true);
        $("#cp_new").prop('disabled', true);
        $("#colonia_new").prop('disabled', true);
        $("#delegacion_new").prop('disabled', true);
        $("#ciudad_new").prop('disabled', true);
        $("#estado_new").prop('disabled', true);
        $("#sexo_new").prop('disabled', true);
        $("#tarjeta_new").prop('disabled', true);
        $("#banco_new").prop('disabled', true);
      //field c_obletivo anableb
        $("#email_co").prop('disabled', false);
        $("#confirmEmail_co").prop('disabled', false);
        $("#nombre_co").prop('disabled', false);
        $("#paterno_co").prop('disabled', false);
        $("#materno_co").prop('disabled', false);
        $("#diaNacimiento_co").prop('disabled', false);
        $("#mesNacimiento_co").prop('disabled', false);
        $("#yearNacimiento_co").prop('disabled', false);
        $("#rfc_co").prop('disabled', false);
        $("#homoclave_co").prop('disabled', false);
        $("#telCelular_co").prop('disabled', false);
        $("#calle_co").prop('disabled', false);
        $("#noExt_co").prop('disabled', false);
        $("#noInt_co").prop('disabled', false);
        $("#cp_co").prop('disabled', false);
        $("#colonia_co").prop('disabled', false);
        $("#tipoVivienda_co").prop('disabled', false);
        $("#tiempoResidencia_co").prop('disabled', false);
        $("#ladaDomi_co").prop('disabled', false);
        $("#telDom_co").prop('disabled', false);
        $("#tipoTarjeta_co").prop('disabled', false);
        $("#numeroTarjeta_co").prop('disabled', false);
        $("#creditoHipo_co").prop('disabled', false);
        $("#creditoAuto_co").prop('disabled', false);
        $("#nombreEmpresa_co").prop('disabled', false);
        $("#giroEmpresa_co").prop('disabled', false);
        $("#ocupacion_co").prop('disabled', false);
        $("#antiguedad_co").prop('disabled', false);
        $("#ingresos_co").prop('disabled', false);
        $("#tipoTarjetaSolicita_co").prop('disabled', false);
        $("#calleEmpleo_co").prop('disabled', false);
        $("#numExt_co").prop('disabled', false);
        $("#numInt_co").prop('disabled', false);
        $("#cpEmpleo_co").prop('disabled', false);
        $("#coloniaEmpleo_co").prop('disabled', false);
        $("#nacionalidad_co").prop('disabled', false);
        $("#lugarNaci_co").prop('disabled', false);
        $("#paisnaci_co").prop('disabled',false);
        $("#genero_co").prop('disabled', false);
        $("#estadoCivil_co").prop('disabled', false);
        $("#escolaridad_co").prop('disabled', false);
        $("#depEconomicos_co").prop('disabled', false);
        $("#refNombre_co").prop('disabled', false);
        $("#refApellidos_co").prop('disabled', false);
        $("#lada_co").prop('disabled', false);
        $("#refTel_co").prop('disabled', false);
        $("#extensionRef_co").prop('disabled', false);

        $.ajax({
                      url:   "banamex/validaVenta/"+$("#numEmpleado").val()+"/"+$("#numPass").val(),
                      type:  'get',

                      success:  function (data)
                      {
                        console.log(data);
                        if(data == 1 ){
                          console.log("bien");
                          $("#valVenta").val('1');
                          $("#success").show();
                          $("#wrong").hide();
                        }
                        else {
                          console.log("error");
                           $("#valVenta").val('0');
                           $("#success").hide();
                           $("#wrong").show();
                        }

                      }
              });



    }else if($("#c_objetivo").val()==''){
      $("#con").hide();
      $("#cos").hide();
    }
    else {
      $("#con").show();
      $("#cos").hide();
      //datos nuevo cliente
        $("#c_new").prop('disabled', false);
        $("#cContrata_new").prop('disabled', false);
        $("#nombre_new").prop('disabled', false);
        $("#paterno_new").prop('disabled', false);
        $("#materno_new").prop('disabled', false);
        $("#tel1_new").prop('disabled', false);
        $("#tel2_new").prop('disabled', false);
        $("#calle_new").prop('disabled', false);
        $("#numExt_new").prop('disabled', false);
        $("#numInt_new").prop('disabled', false);
        $("#cp_new").prop('disabled', false);
        $("#colonia_new").prop('disabled', false);
        $("#delegacion_new").prop('disabled', false);
        $("#ciudad_new").prop('disabled', false);
        $("#estado_new").prop('disabled', false);
        $("#sexo_new").prop('disabled', false);
        $("#tarjeta_new").prop('disabled', false);
        $("#banco_new").prop('disabled', false);
      //datos c_objetivo disabled
        $("#email_co").prop('disabled', true);
        $("#confirmEmail_co").prop('disabled', true);
        $("#nombre_co").prop('disabled', true);
        $("#paterno_co").prop('disabled', true);
        $("#materno_co").prop('disabled', true);
        $("#diaNacimiento_co").prop('disabled', true);
        $("#mesNacimiento_co").prop('disabled', true);
        $("#yearNacimiento_co").prop('disabled', true);
        $("#rfc_co").prop('disabled', true);
        $("#homoclave_co").prop('disabled', true);
        $("#telCelular_co").prop('disabled', true);
        $("#calle_co").prop('disabled', true);
        $("#noExt_co").prop('disabled', true);
        $("#noInt_co").prop('disabled', true);
        $("#cp_co").prop('disabled', true);
        $("#colonia_co").prop('disabled', true);
        $("#tipoVivienda_co").prop('disabled', true);
        $("#tiempoResidencia_co").prop('disabled', true);
        $("#ladaDomi_co").prop('disabled', true);
        $("#telDom_co").prop('disabled', true);
        $("#tipoTarjeta_co").prop('disabled', true);
        $("#numeroTarjeta_co").prop('disabled', true);
        $("#creditoHipo_co").prop('disabled', true);
        $("#creditoAuto_co").prop('disabled', true);
        $("#nombreEmpresa_co").prop('disabled', true);
        $("#giroEmpresa_co").prop('disabled', true);
        $("#ocupacion_co").prop('disabled', true);
        $("#antiguedad_co").prop('disabled', true);
        $("#ingresos_co").prop('disabled', true);
        $("#tipoTarjetaSolicita_co").prop('disabled', true);
        $("#calleEmpleo_co").prop('disabled', true);
        $("#numExt_co").prop('disabled', true);
        $("#numInt_co").prop('disabled', true);
        $("#cpEmpleo_co").prop('disabled', true);
        $("#coloniaEmpleo_co").prop('disabled', true);
        $("#nacionalidad_co").prop('disabled', true);
        $("#lugarNaci_co").prop('disabled', true);
        $("#paisnaci_co").prop('disabled',false);
        $("#genero_co").prop('disabled', true);
        $("#estadoCivil_co").prop('disabled', true);
        $("#escolaridad_co").prop('disabled', true);
        $("#depEconomicos_co").prop('disabled', true);
        $("#refNombre_co").prop('disabled', true);
        $("#refApellidos_co").prop('disabled', true);
        $("#lada_co").prop('disabled', true);
        $("#refTel_co").prop('disabled', true);
        $("#extensionRef_co").prop('disabled', true);
    }
  }
  function cliente_new_fun(){
    if($("#c_new").val()=='Si'){
      $("#ccs").show();
      $("#ccn").hide();

      //datos nuevo cliente enable
        // $("#c_new").prop('disabled', false);
        $("#nombre_new").prop('disabled', false);
        $("#paterno_new").prop('disabled', false);
        $("#materno_new").prop('disabled', false);
        $("#tel1_new").prop('disabled', false);
        $("#tel2_new").prop('disabled', false);
        $("#calle_new").prop('disabled', false);
        $("#numExt_new").prop('disabled', false);
        $("#numInt_new").prop('disabled', false);
        $("#cp_new").prop('disabled', false);
        $("#colonia_new").prop('disabled', false);
        $("#delegacion_new").prop('disabled', false);
        $("#ciudad_new").prop('disabled', false);
        $("#estado_new").prop('disabled', false);
        $("#sexo_new").prop('disabled', false);
        $("#tarjeta_new").prop('disabled', false);
        $("#banco_new").prop('disabled', false);
        $("#cContrata_new").prop('disabled', false);
        $("#tipoTarjetaSolicita_co").prop('disabled', false);

    }
    else {
      $("#ccn").show();
      $("#ccs").hide();

      //datos nuevo cliente disabled
        //$("#c_new").prop('disabled', true);
        $("#nombre_new").prop('disabled', true);
        $("#paterno_new").prop('disabled', true);
        $("#materno_new").prop('disabled', true);
        $("#tel1_new").prop('disabled', true);
        $("#tel2_new").prop('disabled', true);
        $("#calle_new").prop('disabled', true);
        $("#numExt_new").prop('disabled', true);
        $("#numInt_new").prop('disabled', true);
        $("#cp_new").prop('disabled', true);
        $("#colonia_new").prop('disabled', true);
        $("#delegacion_new").prop('disabled', true);
        $("#ciudad_new").prop('disabled', true);
        $("#estado_new").prop('disabled', true);
        $("#sexo_new").prop('disabled', true);
        $("#tarjeta_new").prop('disabled', true);
        $("#banco_new").prop('disabled', true);
        $("#cContrata_new").prop('disabled', true);
        $("#tipoTarjetaSolicita_co").prop('disabled', true);
    }
  }
  function clienteContrata_new_fun(){
    if ($("#cContrata_new").val()=='No') {
      $("#cos").hide();
      $("#email_co").prop('disabled', true);
      $("#confirmEmail_co").prop('disabled', true);
      $("#nombre_co").prop('disabled', true);
      $("#paterno_co").prop('disabled', true);
      $("#materno_co").prop('disabled', true);
      $("#diaNacimiento_co").prop('disabled', true);
      $("#mesNacimiento_co").prop('disabled', true);
      $("#yearNacimiento_co").prop('disabled', true);
      $("#rfc_co").prop('disabled', true);
      $("#homoclave_co").prop('disabled', true);
      $("#telCelular_co").prop('disabled', true);
      $("#calle_co").prop('disabled', true);
      $("#noExt_co").prop('disabled', true);
      $("#noInt_co").prop('disabled', true);
      $("#cp_co").prop('disabled', true);
      $("#colonia_co").prop('disabled', true);
      $("#tipoVivienda_co").prop('disabled', true);
      $("#tiempoResidencia_co").prop('disabled', true);
      $("#ladaDomi_co").prop('disabled', true);
      $("#telDom_co").prop('disabled', true);
      $("#tipoTarjeta_co").prop('disabled', true);
      $("#numeroTarjeta_co").prop('disabled', true);
      $("#creditoHipo_co").prop('disabled', true);
      $("#creditoAuto_co").prop('disabled', true);
      $("#nombreEmpresa_co").prop('disabled', true);
      $("#giroEmpresa_co").prop('disabled', true);
      $("#ocupacion_co").prop('disabled', true);
      $("#antiguedad_co").prop('disabled', true);
      $("#ingresos_co").prop('disabled', true);
      $("#calleEmpleo_co").prop('disabled', true);
      $("#numExt_co").prop('disabled', true);
      $("#numInt_co").prop('disabled', true);
      $("#cpEmpleo_co").prop('disabled', true);
      $("#coloniaEmpleo_co").prop('disabled', true);
      $("#nacionalidad_co").prop('disabled', true);
      $("#lugarNaci_co").prop('disabled', true);
      $("#paisnaci_co").prop('disabled',true);
      $("#genero_co").prop('disabled', true);
      $("#estadoCivil_co").prop('disabled', true);
      $("#escolaridad_co").prop('disabled', true);
      $("#depEconomicos_co").prop('disabled', true);
      $("#refNombre_co").prop('disabled', true);
      $("#refApellidos_co").prop('disabled', true);
      $("#lada_co").prop('disabled', true);
      $("#refTel_co").prop('disabled', true);
      $("#extensionRef_co").prop('disabled', true);
      $("#tipoTarjetaSolicita_co").prop('disabled', true);
    }else {
      $("#cos").show();
      $("#email_co").prop('disabled', false);
      $("#confirmEmail_co").prop('disabled', false);
      $("#nombre_co").prop('disabled', false);
      $("#paterno_co").prop('disabled', false);
      $("#materno_co").prop('disabled', false);
      $("#diaNacimiento_co").prop('disabled', false);
      $("#mesNacimiento_co").prop('disabled', false);
      $("#yearNacimiento_co").prop('disabled', false);
      $("#rfc_co").prop('disabled', false);
      $("#homoclave_co").prop('disabled', false);
      $("#telCelular_co").prop('disabled', false);
      $("#calle_co").prop('disabled', false);
      $("#noExt_co").prop('disabled', false);
      $("#noInt_co").prop('disabled', false);
      $("#cp_co").prop('disabled', false);
      $("#colonia_co").prop('disabled', false);
      $("#tipoVivienda_co").prop('disabled', false);
      $("#tiempoResidencia_co").prop('disabled', false);
      $("#ladaDomi_co").prop('disabled', false);
      $("#telDom_co").prop('disabled', false);
      $("#tipoTarjeta_co").prop('disabled', false);
      $("#numeroTarjeta_co").prop('disabled', false);
      $("#creditoHipo_co").prop('disabled', false);
      $("#creditoAuto_co").prop('disabled', false);
      $("#nombreEmpresa_co").prop('disabled', false);
      $("#giroEmpresa_co").prop('disabled', false);
      $("#ocupacion_co").prop('disabled', false);
      $("#antiguedad_co").prop('disabled', false);
      $("#ingresos_co").prop('disabled', false);
      $("#calleEmpleo_co").prop('disabled', false);
      $("#numExt_co").prop('disabled', false);
      $("#numInt_co").prop('disabled', false);
      $("#cpEmpleo_co").prop('disabled', false);
      $("#coloniaEmpleo_co").prop('disabled', false);
      $("#nacionalidad_co").prop('disabled', false);
      $("#lugarNaci_co").prop('disabled', false);
      $("#paisnaci_co").prop('disabled',false);
      $("#genero_co").prop('disabled', false);
      $("#estadoCivil_co").prop('disabled', false);
      $("#escolaridad_co").prop('disabled', false);
      $("#depEconomicos_co").prop('disabled', false);
      $("#refNombre_co").prop('disabled', false);
      $("#refApellidos_co").prop('disabled', false);
      $("#lada_co").prop('disabled', false);
      $("#refTel_co").prop('disabled', false);
      $("#extensionRef_co").prop('disabled', false);
      $("#tipoTarjetaSolicita_co").prop('disabled', false);
    }
  }
  function tipificacion_fun(){
    if(
      $("#tipificacion").val()=='No Contacto - Buzon de voz personal' ||
      $("#tipificacion").val()=='No Contacto - Buzon de voz empresa' ||
      $("#tipificacion").val()=='No Contacto - Telefono no existe' ||
      $("#tipificacion").val()=='Se corta la llamada' ||
      $("#tipificacion").val()=='No le interesa - No tiene tiempo' ||
      $("#tipificacion").val()=='No le interesa - Cuelga llamada' ||
      $("#tipificacion").val()=='No cubre el perfil' ||
      $("#tipificacion").val()=='Llamar despues' ||
      $("#tipificacion").val()=='No le interesa - Mala experiencia con los bancos' ||
      $("#tipificacion").val()=='No le interesa - No quiere adquirir productos' ||
      $("#tipificacion").val()=='No le interesa - Mala experiencia con Banamex' ||
      $("#tipificacion").val()=='No le interesa - Problemas con buro' ||
      $("#tipificacion").val()=='No le interesa - Producto poco atractivo'
    )
    {
      $("#correo").prop('disabled', true);
      $("#correodiv").hide();
      $("#tipoTarjeta_co").prop('disabled', true);
      $("#tipoTarjeta_codiv").hide();

      $("#sendB").prop('disabled', false);
      $("#send").show();

      $("#valida").hide();
      $("#numEmpleado").prop('disabled', true);
      $("#numPass").prop('disabled', true);

      $("#email_co").prop('required',false);
      $("#tipoTarjeta_co").prop('required',false);
      $("#confirmEmail_co").prop('required',false);
      $("#nombre_co").prop('required',false);
      $("#paterno_co").prop('required',false);
      $("#materno_co").prop('required',false);
      $("#diaNacimiento_co").prop('required',false);
      $("#mesNacimiento_co").prop('required',false);
      $("#yearNacimiento_co").prop('required',false);
      $("#rfc_co").prop('required',false);
      $("#telCelular_co").prop('required',false);
      $("#calle_co").prop('required',false);
      $("#noExt_co").prop('required',false);
      $("#cp_co").prop('required',false);
      $("#colonia_co").prop('required',false);
      $("#tipoVivienda_co").prop('required',false);
      $("#tiempoResidencia_co").prop('required',false);
      $("#ladaDomi_co").prop('requiered', false);
      $("#telDom_co").prop('required', false);
      $("#creditoHipo_co").prop('required',false);
      $("#creditoAuto_co").prop('required',false);
      $("#nombreEmpresa_co").prop('required',false);
      $("#giroEmpresa_co").prop('required',false);
      $("#ocupacion_co").prop('required',false);
      $("#antiguedad_co").prop('required',false);
      $("#ingresos_co").prop('required',false);
      $("#calleEmpleo_co").prop('required',false);
      $("#numExt_co").prop('required',false);
      $("#numInt_co").prop('required',false);
      $("#cpEmpleo_co").prop('required',false);
      $("#coloniaEmpleo_co").prop('required',false);
      $("#nacionalidad_co").prop('required',false);
      $("#lugarNaci_co").prop('required',false);
      $("#paisnaci_co").prop('required',false);

      $("#genero_co").prop('required',false);
      $("#estadoCivil_co").prop('required',false);
      $("#escolaridad_co").prop('required',false);
      $("#depEconomicos_co").prop('required',false);
      $("#refNombre_co").prop('required',false);
      $("#refApellidos_co").prop('required',false);
      $("#lada_co").prop('required',false);
      $("#refTel_co").prop('required',false);

      $("#nombre_new").prop('required',false);
      $("#paterno_new").prop('required',false);
      $("#materno_new").prop('required',false);
      $("#tel1_new").prop('required',false);
      $("#calle_new").prop('required',false);
      $("#numExt_new").prop('required',false);
      $("#numInt_new").prop('required',false);
      $("#cp_new").prop('required',false);
      $("#colonia_new").prop('required',false);
      $("#delegacion_new").prop('required',false);
      $("#ciudad_new").prop('required',false);
      $("#estado_new").prop('required',false);
      $("#sexo_new").prop('required',false);
      $("#tarjeta_new").prop('required',false);
      $("#banco_new").prop('required',false);
      $("#tipoTarjetaSolicita_co").prop('required',false);
    }
    else if($("#tipificacion").val()=='Venta - Validada' || $("#tipificacion").val()=='Venta - No Validada')
    {
      var vent;
      var x = screen.width/2 ;
      var y = screen.height ;
      // if($("#tipoTarjetaSolicita_co").val()!=''){
      //   var vent;
      //   switch ($("#tipoTarjetaSolicita_co").val()) {
      //     case 'Clasica': vent='https://portal.banamex.com.mx/solicitud_tdc_v3/index.html?surcursal=8082&canal=16&pos=75082&idproducto=130217&empresa=144&ecid=AF-CommissionJuction-CreditCardBank-Clasica-ENH-INT-04062016-Emp144&utm_campaign=affiliate&AID=12609679&PID=8084192&SID'; break;
      //     case 'ORO': vent='https://portal.banamex.com.mx/solicitud_tdc_v3/index.html?surcursal=8082&canal=16&pos=75082&idproducto=222577&empresa=144&ecid=AF-CommissionJuction-CreditCardBank-Oro-ENH-INT-04062016-Emp144&utm_campaign=affiliate&AID=12609682&PID=8084192&SID'; break;
      //     case 'PLATINUM': vent='https://portal.banamex.com.mx/solicitud_tdc_v3/index.html?surcursal=8082&canal=16&pos=75082&idproducto=530257&empresa=144&ecid=AF-CommissionJuction-CreditCardBank-Platinium-ENH-INT-04062016-Emp144&utm_campaign=affiliate&AID=12622104&PID=8084192&SID'; break;
      //     case 'BMART': vent='https://portal.banamex.com.mx/solicitud_tdc_v3/index.html?surcursal=8082&canal=16&pos=75082&idproducto=410251&empresa=144&ecid=AF-CommissionJuction-CreditCardBank-Bsmart-ENH-INT-04062016-Emp144&utm_campaign=affiliate&AID=12609688&PID=8084192&SID'; break;
      //     case 'PREMIER': vent='https://portal.banamex.com.mx/solicitud_tdc_v3/index.html?surcursal=8082&canal=16&pos=75082&idproducto=640181&empresa=144&ecid=AF-CommissionJuction-CreditCardBank-Premier-ENH-INT-05022016-Emp144&utm_campaign=affiliate&AID=12679897&PID=8084192&SID'; break;
      //     case 'REWARDS': vent='https://portal.banamex.com.mx/solicitud_tdc_v3/index.html?surcursal=8082&canal=16&pos=75082&idproducto=620220&empresa=144&ecid=AF-CommissionJuction-CreditCardBank-Rewards-ENH-INT-05022016-Emp144&utm_campaign=affiliate&AID=12679898&PID=8084192&SID'; break;
      //
      //   }
      //   vent=window.open(vent,"ventana1", "height="+y+",width="+x+",left="+x+"");
      // }
      $("#correo").prop('disabled', false);
      $("#correodiv").show();
      $("#tipoTarjeta_co").prop('disabled', false);
      $("#tipoTarjeta_codiv").show();
      $("#tipoTarjeta_co").prop('required',true);
      $("#sendB").prop('disabled', false);
      $("#send").show();
      $("#valida").show();
      $("#numEmpleado").prop('disabled', false);
      $("#numPass").prop('disabled', false);

      $("#email_co").prop('required',true);
      //$("#tipoTarjeta_co").prop('required',true);
      $("#confirmEmail_co").prop('required',true);
      $("#nombre_co").prop('required',true);
      $("#paterno_co").prop('required',true);
      $("#materno_co").prop('required',true);
      $("#diaNacimiento_co").prop('required',true);
      $("#mesNacimiento_co").prop('required',true);
      $("#yearNacimiento_co").prop('required',true);
      $("#rfc_co").prop('required',true);
      $("#telCelular_co").prop('required',true);
      $("#calle_co").prop('required',true);
      $("#noExt_co").prop('required',true);
      $("#cp_co").prop('required',true);
      $("#colonia_co").prop('required',true);
      $("#tipoVivienda_co").prop('required',true);
      $("#tiempoResidencia_co").prop('required',true);
      $("#ladaDomi_co").prop('required', true);
      $("#telDom_co").prop('requiered', true);
      $("#creditoHipo_co").prop('required',true);
      $("#creditoAuto_co").prop('required',true);
      $("#nombreEmpresa_co").prop('required',true);
      $("#giroEmpresa_co").prop('required',true);
      $("#ocupacion_co").prop('required',true);
      $("#antiguedad_co").prop('required',true);
      $("#ingresos_co").prop('required',true);
      $("#calleEmpleo_co").prop('required',true);
      $("#numExt_co").prop('required',true);
      // $("#numInt_co").prop('required',true);
      $("#cpEmpleo_co").prop('required',true);
      $("#coloniaEmpleo_co").prop('required',true);
      $("#nacionalidad_co").prop('required',true);
      $("#lugarNaci_co").prop('required',true);
      $("#paisnaci_co").prop('required',true);
      $("#genero_co").prop('required',true);
      $("#estadoCivil_co").prop('required',true);
      $("#escolaridad_co").prop('required',true);
      $("#depEconomicos_co").prop('required',true);
      $("#refNombre_co").prop('required',true);
      $("#refApellidos_co").prop('required',true);
      $("#lada_co").prop('required',true);
      $("#refTel_co").prop('required',true);

      $("#nombre_new").prop('required',true);
      $("#paterno_new").prop('required',true);
      $("#materno_new").prop('required',true);
      $("#tel1_new").prop('required',true);
      $("#calle_new").prop('required',true);
      $("#numExt_new").prop('required',true);
      // $("#numInt_new").prop('required',true);
      $("#cp_new").prop('required',true);
      $("#colonia_new").prop('required',true);
      $("#delegacion_new").prop('required',true);
      $("#ciudad_new").prop('required',true);
      $("#estado_new").prop('required',true);
      $("#sexo_new").prop('required',true);
      $("#tarjeta_new").prop('required',true);
      $("#banco_new").prop('required',true);
      $("#tipoTarjetaSolicita_co").prop('required',true);

    }else {
      $("#sendB").prop('disabled', true);
      $("#send").hide();
      $("#valida").hide();
      $("#numEmpleado").prop('disabled', true);
      $("#numPass").prop('disabled', true);
    }
  }
  function validaEmail(){
    if($("#email_co").val()!=$("#confirmEmail_co").val()){
      document.getElementById("confirmEmail_co").value='';
    }
  }

  function validaVenta(){
// alert('se');
console.log($("#numselect").val());
      if($("#tipificacion").val()=='Venta - Validada' || $("#tipificacion").val()=='Venta - No Validada'){
        if($("#valVenta").val()==1 ){
          if($("#numselect").val()==''){
            alert("Favor de seleccionar algun numero");
            return false;
          }
          return true;
          // return false;
        }
        else {
          return false;
        }
      }else {
        if($("#numselect").val()==''){
          alert("Favor de seleccionar algun numero");
          return false;
        }
          return true;
      }
  }
  function valAjax(){
    $.ajax({
                  url:   "banamex/validaVenta/"+$("#numEmpleado").val()+"/"+$("#numPass").val(),
                  type:  'get',

                  success:  function (data)
                  {
                    console.log(data);
                    if(data == 1 ){
                      console.log("bien");
                      $("#valVenta").val('1');
                      $("#success").show();
                      $("#wrong").hide();
                    }
                    else {
                      console.log("error");
                       $("#valVenta").val('0');
                       $("#success").hide();
                       $("#wrong").show();
                    }

                  }
          });
          console.log("laalla");
          return false;
  }
  function nacionalidad(){
    if($("#nacionalidad_co").val()=="Soy mexicano (a)"){
      $("#nac1").show();
      $("#extran").hide();
      $("#extran1").hide();
      $("#extran2").hide();
      $("#paisnaci_co").prop('disabled', true);
      $("#lugarNaci_co").prop('disabled', false);
    }else if($("#nacionalidad_co").val()=="Soy extranjero (a)"){
       $("#nac1").hide();

      $("#extran").show();
      $("#extran1").show();
      $("#extran2").show();
      $("#paisnaci_co").prop('disabled', false);
      $("#lugarNaci_co").prop('disabled', true);
    }
    else {
      $("#nac").show();
      $("#extran").hide();
      $("#extran1").hide();
      $("#extran2").hide();
      $("#paisnaci_co").prop('disabled', true);
      $("#lugarNaci_co").prop('disabled', false);
    }
  }
  function tel_casa_color(){
    $("#tel_casa").css('background-color', '#86E487');
    $("#tel_casa2").css('background-color', '#EEEEEE');
    $("#tel_oficina").css('background-color', '#EEEEEE');
    $("#movil").css('background-color', '#EEEEEE');
    $("#movil2").css('background-color', '#EEEEEE');
    $("#tel_otro").css('background-color', '#EEEEEE');

    $("#numselect").val($("#tel_casa").val());
  }
  function tel_casa_color2(){
    $("#tel_casa").css('background-color', '#EEEEEE');
    $("#tel_casa2").css('background-color', '#86E487');
    $("#tel_oficina").css('background-color', '#EEEEEE');
    $("#movil").css('background-color', '#EEEEEE');
    $("#movil2").css('background-color', '#EEEEEE');
    $("#tel_otro").css('background-color', '#EEEEEE');

    $("#numselect").val($("#tel_casa2").val());
  }
  function tel_oficina_color(){
    $("#tel_casa").css('background-color', '#EEEEEE');
    $("#tel_casa2").css('background-color', '#EEEEEE');
    $("#tel_oficina").css('background-color', '#86E487');
    $("#movil").css('background-color', '#EEEEEE');
    $("#movil2").css('background-color', '#EEEEEE');
    $("#tel_otro").css('background-color', '#EEEEEE');

    $("#numselect").val($("#tel_oficina").val());

  }
  function tel_movil_color(){
    $("#tel_casa").css('background-color', '#EEEEEE');
    $("#tel_casa2").css('background-color', '#EEEEEE');
    $("#tel_oficina").css('background-color', '#EEEEEE');
    $("#movil").css('background-color', '#86E487');
    $("#movil2").css('background-color', '#EEEEEE');
    $("#tel_otro").css('background-color', '#EEEEEE');
    $("#numselect").val($("#movil").val());
  }
  function tel_movil2_color(){
    $("#tel_casa").css('background-color', '#EEEEEE');
    $("#tel_casa2").css('background-color', '#EEEEEE');
    $("#tel_oficina").css('background-color', '#EEEEEE');
    $("#movil").css('background-color', '#EEEEEE');
    $("#movil2").css('background-color', '#86E487');
    $("#tel_otro").css('background-color', '#EEEEEE');
    $("#numselect").val($("#movil2").val());
  }
  function tel_otro_color(){
    $("#tel_casa").css('background-color', '#EEEEEE');
    $("#tel_casa2").css('background-color', '#EEEEEE');
    $("#tel_oficina").css('background-color', '#EEEEEE');
    $("#movil").css('background-color', '#EEEEEE');
    $("#movil2").css('background-color', '#EEEEEE');
    $("#tel_otro").css('background-color', '#86E487');
    $("#numselect").val($("#tel_otro").val());
  }
</script>
@stop
