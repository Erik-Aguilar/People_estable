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
                <h3 class="panel-title">Referido</h3>
            </div>
            <div class="panel-body">

              {{ Form::open(['action' => 'BanamexController@GuardaReferido',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario",

                          ]) }}

                  <div class="form-group"  align='Center'>
                      {{ Form::label('DN','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-2">
                          {{ Form::text('dn','',array('id'=>'dn','class'=>"form-control", 'placeholder'=>"5512345678",'required'=>'required')) }}
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
                  <div class="form-group">
                    {{ Form::label('Nombre*','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-4">
                        {{ Form::text('nombre','',array('id'=>'nombre','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                    {{ Form::label('paterno*','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-4">
                        {{ Form::text('paterno','',array('id'=>'paterno','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                  </div>
                  <div class="form-group">
                    {{ Form::label('materno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-4">
                      {{ Form::text('materno','',array('id'=>'materno', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                    {{ Form::label('Correo*','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-4">
                      {{ Form::email('email','',array('class'=>"form-control",'required'=>'required', 'placeholder'=>"",'id'=>'correo')) }}
                    </div>
                  </div>

                  <div class="form-group">
                    {{ Form::label('¿Tienes alguna tarjeta de credito?(no nómina o débito)* ','',array('class'=>"col-sm-2   control-label")) }}
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
                        '', ['id'=>'tipoTarjeta', 'class'=>"form-control", 'placeholder'=>"",'required'=>'required']  ) }}
                    </div>
                  </div>
                  <div>
                  <div id="send" style="display:none">
                    {{ Form::submit('Enviar',['class'=>"btn btn-default",'onClick'=>'return validaVenta()']) }}
                  </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('content2')
<script>
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
      $("#nombre").prop('required',false);
      $("#paterno").prop('required',false);
      $("#tipoTarjeta").prop('required',false);
      $("#correo").prop('required',false);
      $("#send").show();

      $("#numEmpleado").prop('disabled', true);
      $("#numPass").prop('disabled', true);

    }
    else if($("#tipificacion").val()=='Venta - Validada' || $("#tipificacion").val()=='Venta - No Validada')
    {
      $("#nombre").prop('required',true);
      $("#paterno").prop('required',true);
      $("#tipoTarjeta").prop('required',true);
      $("#correo").prop('required',true);
      $("#send").show();
      $("#valida").show();

      $("#numEmpleado").prop('disabled', false);
      $("#numPass").prop('disabled', false);

    }else {
      $("#nombre").prop('required',true);
      $("#paterno").prop('required',true);
      $("#tipoTarjeta").prop('required',true);
      $("#correo").prop('required',true);
      $("#send").hide();
      $("#valida").hide();
      $("#numEmpleado").prop('disabled', false);
      $("#numPass").prop('disabled', false);
    }
  }

  function validaVenta(){
    if($("#tipificacion").val()=='Venta - Validada' || $("#tipificacion").val()=='Venta - No Validada'){
      if($("#valVenta").val()==1){
        $("#valida").show();
        $("#numEmpleado").prop('disabled', false);
        return true;
      }
      else {
        return false
      }
    }else {
      return true;
    }
  }
  function valAjax(){
    $.ajax({
                  url:   "/banamex/validaVenta/"+$("#numEmpleado").val()+"/"+$("#numPass").val(),
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

</script>
@stop
