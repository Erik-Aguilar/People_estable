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
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{$value['nombre_completo']}}. Extensión {{$value['extension']}}</h3>
            </div>
            <div class="panel-body">

              <div class="row">
                <div class="col-md-6">
                  <div class="col-md-8 col-md-offset-2">
                    <input type="text" name="" value="" placeholder="Teléfono" class="form-control" id="telefono">
                    <br>
                    <input type="text" name="" value="" placeholder="Nombre" class="form-control" id="nombre">
                    <br>
                    <input type="text" name="" value="" placeholder="Dirección" class="form-control" id="direccion">
                    <br>
                    <button type="button" class="btn btn-primary btn-lg btn-block" id="datos">Obtener datos</button>
                    <br>
                    <button type="button" class="btn btn-danger btn-lg btn-block" id="colgar" >Colgar</button>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col-md-8 col-md-offset-2">
                    <br>
                    <button type="button" class="btn btn-success btn-lg btn-block" id="conectar">Conectar</button>
                    <br>
                    <button type="button" class="btn btn-warning btn-lg btn-block" id="pausar">Pausar</button>
                    <br>
                    <button type="button" class="btn btn-info btn-lg btn-block" id="continuar">Continuar</button>
                    <br>
                    <button type="button" class="btn btn-danger btn-lg btn-block" id="desconectar">Desconectar</button>


                  </div>
                </div>
                <div class="col-md-8 col-md-offset-2" id="resdiv">
                  <br>
                  <input type="text" name="" value="" placeholder="Server status" class="form-control" id="resultado">
                </div>
              </div>

            </div>
        </div>
    </div>
</div>
@stop
@section('content2')
<script type="text/javascript">
$( "#conectar" ).click(function() {
  $.ajax({
          data:  '',
          url:   '/inbursa/asterisk/comenzar',
          type:  'get',
          beforeSend: function () {
            $("#resdiv").addClass( "has-warning" );
            $("#resultado").val("Procesando, espere por favor...");
          },
          success:  function (data) {
            $("#resdiv").addClass( "has-success" );
            $("#resultado").val(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            $("#resdiv").addClass( "has-error" );
            $("#resultado").val(thrownError);
          }
  });
});

$( "#pausar" ).click(function() {
  $.ajax({
          data:  '',
          url:   '/inbursa/asterisk/pausar',
          type:  'get',
          beforeSend: function () {
            $("#resdiv").addClass( "has-warning" );
            $("#resultado").val("Procesando, espere por favor...");
          },
          success:  function (data) {
            $("#resdiv").addClass( "has-success" );
            $("#resultado").val(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            $("#resdiv").addClass( "has-error" );
            $("#resultado").val(thrownError);
          }
  });
});

$( "#continuar" ).click(function() {
  $.ajax({
          data:  '',
          url:   '/inbursa/asterisk/continuar',
          type:  'get',
          beforeSend: function () {
            $("#resdiv").addClass( "has-warning" );
            $("#resultado").val("Procesando, espere por favor...");
          },
          success:  function (data) {
            $("#resdiv").addClass( "has-success" );
            $("#resultado").val(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            $("#resdiv").addClass( "has-error" );
            $("#resultado").val(thrownError);
          }
  });
});

$( "#desconectar" ).click(function() {
  $.ajax({
          data:  '',
          url:   '/inbursa/asterisk/desconectar',
          type:  'get',
          beforeSend: function () {
            $("#resdiv").addClass( "has-warning" );
            $("#resultado").val("Procesando, espere por favor...");
          },
          success:  function (data) {
            $("#resdiv").removeClass( "has-warning" );
            $("#resdiv").addClass( "has-success" );
            $("#resultado").val(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            $("#resdiv").removeClass( "has-warning" );
            $("#resdiv").addClass( "has-error" );
            $("#resultado").val(thrownError);
          }
  });
});

$( "#colgar" ).click(function() {
  $.ajax({
          data:  '',
          url:   '/inbursa/asterisk/colgar',
          type:  'get',
          beforeSend: function () {
            $("#resdiv").addClass( "has-warning" );
            $("#resultado").val("Procesando, espere por favor...");
          },
          success:  function (data) {
            $("#resdiv").removeClass( "has-warning" );
            $("#resdiv").addClass( "has-success" );
            $("#resultado").val(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            $("#resdiv").removeClass( "has-warning" );
            $("#resdiv").addClass( "has-error" );
            $("#resultado").val(thrownError);
          }
  });
});

$( "#datos" ).click(function() {
$.get("{{URL('/inbursa/asterisk/datos')}}", function (data) {
    //success data
    //console.log(data.name);
    $("#telefono").val(data.dn);
    $("#nombre").val(data.nombre);
    $("#direccion").val(data.direccion);

})
});
</script>
@stop
