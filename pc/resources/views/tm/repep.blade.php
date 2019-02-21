@extends('layout.tmpre.basic')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="panel panel-default col-md-8 col-md-offset-2">
      <div class="panel-body">
        {{ Form::open(['action' => 'TmVentasController@TmPreStatusSave',
                        'method' => 'post',
                        'class'=>"form-horizontal",
                        'accept-charset'=>"UTF-8",
                        'id'=>'myform',
                        'enctype'=>"multipart/form-data"
                    ]) }}
          <fieldset>
            <legend>Repep</legend>
            <div class="alert alert-dismissible alert-danger" hidden="" id="msg"></div>
            <div class="alert alert-dismissible alert-success" hidden="" id="msg2"></div>
            <div class="form-group" id="phonediv">
              <label for="" class="col-lg-2 control-label">Teléfono</label>
              <div class="col-lg-7">
                <input type="text" class="form-control" name="telefono" id="telefono" placeholder="5512345678" required="">
              </div>
              <div class="col-lg-1">
                <button id="validatelrep" class="btn btn-warning">Validar</button>
              </div>
            </div>

            <!-- <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Estatus 1</label>
              <div class="col-lg-8">
                <select class="form-control" name="st1" id="st1" required="" disabled="">
                  <option></option>
                  <option value="No contacto">No contacto</option>
                  <option value="Contaco efectivo">Contaco efectivo</option>
                  <option value="Contacto NO efectivo">Contacto NO efectivo</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Estatus 2</label>
              <div class="col-lg-8">
                <select class="form-control" name="st2" id="st2" required="">
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Estatus 3</label>
              <div class="col-lg-8">
                <select class="form-control" name="st3" id="st3">
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" id="subguardar" class="btn btn-primary" disabled="">Guardar</button>
              </div>
            </div> -->
          </fieldset>
        {{ Form::close() }}
      </div>
    </div>

  </div>

</div>

<style media="screen">
  .close{
    margin-right: 5%;
  }
</style>

@endsection
@section('content2')
<script type="text/javascript">
function cerrar() {
  $( "#msg" ).hide( 1000 );
}
function cerrar2() {
  $( "#msg2" ).hide( 1000 );
}
$("#telefono").change(function () {
  var valor = $(this).val();
  if(!$.isNumeric( valor )){
    cerrar2();
    cerrar();
    $(this).val('');
    $("#msg").html("<a id='close' class='close' onclick='cerrar()'>X</a><center><strong>Error!</strong> El formato del teléfono no es correcto. Usa solo números</center>");
    $( "#msg" ).show( "slow" );
    $( this ).focus();
    $("#phonediv").attr('class', 'form-group has-error');

  }
  else if(valor.length!=10){
    cerrar();
    cerrar2();
    $(this).val('');
    $("#msg").html("<a id='close' class='close' onclick='cerrar()'>X</a><center><strong>Error!</strong> El formato del teléfono no es correcto. Captura a 10 digitos</center>");
    $( "#msg" ).show( "slow" );
    $( this ).focus();
    $("#phonediv").attr('class', 'form-group has-error');
  }
  else {
    $("#phonediv").attr('class', 'form-group');
    cerrar();
    cerrar2();
  }
});


$("#validatelrep").click(function(){
  var valor = $("#telefono").val();
  if(valor.length==10){
  $("#validatelrep").prop('disabled', true);
  $.get('/tm/repep/buscar/' + $('#telefono').val() + '' ,function(response){
		if (response==0) {
      cerrar();
      cerrar2();
      $(this).val('');
		  $("#msg2").html("<a id='close' class='close' onclick='cerrar2()'>X</a><center><strong>¡Ok!</strong> El teléfono no se encuentra en Repep</center>");
      $( "#msg2" ).show( "slow" );
      $( this ).focus();
      $("#phonediv").attr('class', 'form-group has-success');
      $("#validatelrep").prop('disabled', false);
		}
    else {
      cerrar();
      cerrar2();
      $(this).val('');
      $("#msg").html("<a id='close' class='close' onclick='cerrar()'>X</a><center><strong>¡Cuidado!</strong> El teléfono se encuentra en Repep</center>");
      $( "#msg" ).show( "slow" );
      $( this ).focus();
      $("#phonediv").attr('class', 'form-group has-error');
      $("#validatelrep").prop('disabled', false);
      $.get('/tm/repep/nuevo/' + $('#telefono').val() + '' ,function(response){})
    }
	});
  }
  // $("#subguardar").prop('disabled', false);
  // $("#telefono").css('border', '3px solid red');
  // alert('Telefono invalido');
});


</script>
@endsection
