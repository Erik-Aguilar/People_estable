<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="panel panel-default col-md-8 col-md-offset-2">
      <div class="panel-body">
        <?php echo e(Form::open(['action' => 'TmVentasController@TmPosStatusSave',
                        'method' => 'post',
                        'class'=>"form-horizontal",
                        'accept-charset'=>"UTF-8",
                        'id'=>'myform',
                        'enctype'=>"multipart/form-data"
                    ])); ?>

          <fieldset>
            <legend>Operaciones</legend>
            <div class="alert alert-dismissible alert-danger" hidden="" id="msg"></div>
            <div class="form-group" id="phonediv">
              <label for="" class="col-lg-2 control-label">Teléfono</label>
              <div class="col-lg-8">
                <input type="text" class="form-control" name="telefono" id="telefono" placeholder="5512345678" required="">
              </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Estatus 1</label>
              <div class="col-lg-8">
                <select class="form-control" name="st1" id="st1" required="">
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
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            </div>
          </fieldset>
        <?php echo e(Form::close()); ?>

      </div>
    </div>

  </div>

</div>

<style media="screen">
  .close{
    margin-right: 5%;
  }
</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>
<script type="text/javascript">
function cerrar() {
  $( "#msg" ).hide( 1000 );
}
$("#telefono").change(function () {
  var valor = $(this).val();
  if(!$.isNumeric( valor )){
    $(this).val('');
    $("#msg").html("<a id='close' class='close' onclick='cerrar()'>X</a><center><strong>Error!</strong> El teléfono no es correcto.</center>");
    $( "#msg" ).show( "slow" );
    $( this ).focus();
    $("#phonediv").attr('class', 'form-group has-error');

  }
  else if(valor.length!=10){
    $(this).val('');
    $("#msg").html("<a id='close' class='close' onclick='cerrar()'>X</a><center><strong>Error!</strong> El teléfono no es correcto.</center>");
    $( "#msg" ).show( "slow" );
    $( this ).focus();
    $("#phonediv").attr('class', 'form-group has-error');
  }
  else {
    $("#phonediv").attr('class', 'form-group');
    cerrar();
  }
});
$( "#st1" ).change(function () {
  var valorEst = $("#st1").val();
  if(valorEst=="No contacto"){
    $("#st2").empty();
    var option0 = $('<option></option>').attr("value", "").text("");
    var option1 = $('<option></option>').attr("value", "Problemas Marcacion").text("Problemas Marcación");
    var option2 = $('<option></option>').attr("value", "Se corta llamada").text("Se corta llamada");
    var option3 = $('<option></option>').attr("value", "Buzon de voz").text("Buzón de voz");
    var option4 = $('<option></option>').attr("value", "No contesta").text("No contesta");
    var option5 = $('<option></option>').attr("value", "Tono Ocupado").text("Tono Ocupado");
    $("#st2").append(option0);
    $("#st2").append(option1);
    $("#st2").append(option2);
    $("#st2").append(option3);
    $("#st2").append(option4);
    $("#st2").append(option5);
    $("#st3").empty();
  }
  else if (valorEst=="Contaco efectivo") {
    $("#st2").empty();
    var option0 = $('<option></option>').attr("value", "").text("");
    var option1 = $('<option></option>').attr("value", "Agenda promesa de venta").text("Agenda promesa de venta");
    var option2 = $('<option></option>').attr("value", "Transferencia a Validacion").text("Transferencia a Validacion");
    var option3 = $('<option></option>').attr("value", "Llamar Despues").text("Llamar Despues");
    var option4 = $('<option></option>').attr("value", "Rechaza Oferta").text("Rechaza Oferta");
    $("#st2").append(option0);
    $("#st2").append(option1);
    $("#st2").append(option2);
    $("#st2").append(option3);
    $("#st2").append(option4);
    $("#st3").empty();
  }
  else if (valorEst=="Contacto NO efectivo") {

    $("#st2").empty();
    var option0 = $('<option></option>').attr("value", "").text("");
    var option1 = $('<option></option>').attr("value", "No es titular").text("No es titular");
    var option2 = $('<option></option>').attr("value", "Plan de Renta Movil").text("Plan de Renta Movil");
    var option3 = $('<option></option>').attr("value", "Linea Fija").text("Linea Fija");
    var option4 = $('<option></option>').attr("value", "DN gestionado por otro Call Center").text("DN gestionado por otro Call Center");
    var option5 = $('<option></option>').attr("value", "Ya tiene linea movistar").text("Ya tiene linea movistar");
    $("#st2").append(option0);
    $("#st2").append(option1);
    $("#st2").append(option2);
    $("#st2").append(option3);
    $("#st2").append(option4);
    $("#st2").append(option5);
    $("#st3").empty();
  }
  else {
    $("#st2").empty();
    $("#st3").empty();
  }
});

$( "#st2" ).change(function () {
  var valorEst = $("#st2").val();
  if(valorEst=="Rechaza Oferta"){

    $("#st3").empty();
    var option12 = $('<option></option>').attr("value", "").text("");
    var option0 = $('<option></option>').attr("value", "Cac lejano").text("Cac lejano");
    var option1 = $('<option></option>').attr("value", "Recibio contra oferta despues de llamada").text("Recibio contra oferta despues de llamada");
    var option2 = $('<option></option>').attr("value", "Desconfianza llamada/no proporciona datos").text("Desconfianza llamada/no proporciona datos");
    var option3 = $('<option></option>').attr("value", "Cobertura").text("Cobertura");
    var option4 = $('<option></option>').attr("value", "Llamadas recurrentes Movistar/no volver a llamar").text("Llamadas recurrentes Movistar/no volver a llamar");
    var option5 = $('<option></option>').attr("value", "Satisfecho con su compañía actual").text("Satisfecho con su compañía actual");
    var option6 = $('<option></option>').attr("value", "No permite brindar informacion/cuelga llamada").text("No permite brindar informacion/cuelga llamada");
    var option7 = $('<option></option>').attr("value", "Mejor oferta compañía actual").text("Mejor oferta compañía actual");
    var option8 = $('<option></option>').attr("value", "Equipo NO Acondicionable").text("Equipo NO Acondicionable");
    var option9 = $('<option></option>').attr("value", "Se encuentra en proceso de Validacion").text("Se encuentra en proceso de Validacion");
    var option10 = $('<option></option>').attr("value", "Ya tiene linea movistar").text("Ya tiene linea movistar");
    var option11 = $('<option></option>').attr("value", "Mala experiencia con Movistar").text("Mala experiencia con Movistar");

    $("#st3").append(option12);
    $("#st3").append(option0);
    $("#st3").append(option1);
    $("#st3").append(option2);
    $("#st3").append(option3);
    $("#st3").append(option4);
    $("#st3").append(option5);
    $("#st3").append(option6);
    $("#st3").append(option7);
    $("#st3").append(option8);
    $("#st3").append(option9);
    $("#st3").append(option10);
    $("#st3").append(option11);

  }
  else {
    $("#st3").empty();
  }
});



</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.tmpos.basic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>