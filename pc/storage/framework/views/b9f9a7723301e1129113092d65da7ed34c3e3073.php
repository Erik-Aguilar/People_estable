<?php $__env->startSection('content'); ?>

<div class="container-fluid">
  <div class="row">
  <div class="col-md-6 col-md-offset-1">


    <?php if($Vista== "Agenda"): ?>
    <?php echo e(Form::open(['action' => 'AuriController@SaveAgenda',
                    'method' => 'post',
                    'class'=>"form-horizontal",
                    'accept-charset'=>"UTF-8",
                    'enctype'=>"multipart/form-data"
                ])); ?>

        <?php endif; ?>

    <?php if($Vista== "Agente"): ?>
    <?php echo e(Form::open(['action' => 'AuriController@SaveAgente',
                    'method' => 'post',
                    'class'=>"form-horizontal",
                    'accept-charset'=>"UTF-8",
                    'enctype'=>"multipart/form-data"
                ])); ?>

        <?php endif; ?>



  <fieldset>
    <legend>
      <img src="<?php echo e(asset('assets/img/auri_logo.png')); ?>">

  </legend>
    <br>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Marca</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="inputEmail" value="<?php echo e($datos[0]->MARCA); ?>" disabled="">
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Empresa</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="inputEmail" value="<?php echo e($datos[0]->EMPRESA); ?>" disabled="">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Nombre</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="inputEmail" value="<?php echo e($datos[0]->TITULO); ?> <?php echo e($datos[0]->NOMBRE); ?> <?php echo e($datos[0]->APELLIDOS); ?>" disabled="">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Puesto</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="inputEmail" value="<?php echo e($datos[0]->PUESTO); ?>" disabled="">
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Teléfono</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="telefono" value="<?php echo e($datos[0]->telefono); ?>" disabled="">
        <a id="telefonoLlamar" class="btn btn-success btn-block" >Llamar <span class="glyphicon glyphicon-earphone" style="float:right"aria-hidden="true"></span> </a>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Ext</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="inputEmail" value="<?php echo e($datos[0]->TELS); ?>" disabled="">
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Email</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="inputEmail" value="<?php echo e($datos[0]->E_MAIL); ?>" disabled="">
      </div>
    </div>
    <!-- datos envio -->
    <input name="id" type="hidden" value="<?php echo e($datos[0]->id); ?>">
    <div class="form-group">
      <label for="select" class="col-lg-2 control-label">Estatus</label>
      <div class="col-lg-8">
        <select class="form-control" id="select" name="estatus">
          <option></option>
          <option>Cuelgan llamada</option>
          <option>No se encuentra</option>
          <option>Falla sistema</option>
          <option>Fuera del pais</option>
          <option>Ocupado</option>
          <option>Fuera de servicio</option>
          <option>Número equivocado</option>
          <option>No le interesa</option>
          <option>No contesta</option>
          <option>Teléfono no existe</option>
          <option>Reagendar</option>
          <option>La persona ya no esta disponible</option>
          <option>Se necesita extensión</option>
          <option>Si acepta</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Fecha</label>
      <div class="col-lg-8">
        <input type="date" class="form-control" id="inputEmail"  name="fecha">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Hora</label>
      <div class="col-lg-8">
        <input type="time" class="form-control" id="inputEmail" name="hora">
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Observaciones</label>
      <div class="col-lg-8">
        <textarea class="form-control" rows="3" id="textArea" name="obs"></textarea>
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
  <div class="col-md-4">
    <br><br><br><br><br><br><br>
      <a id="sc1" class="btn btn-info btn-block">Wind Universidad <span class="glyphicon glyphicon-earphone" style="float:right"aria-hidden="true"></span> </a>
      <br>
      <a id="sc2" class="btn btn-info btn-block">Wind del Valle II <span class="glyphicon glyphicon-earphone" style="float:right"aria-hidden="true"></span> </a>
      <br>
      <a id="sc3" class="btn btn-info btn-block">Wind Condos del Valle <span class="glyphicon glyphicon-earphone" style="float:right"aria-hidden="true"></span> </a>
      <br>
      <a id="sc4" class="btn btn-info btn-block">Wind Nápoles <span class="glyphicon glyphicon-earphone" style="float:right"aria-hidden="true"></span> </a>
      <br>
      <a id="sc5" class="btn btn-info btn-block">Capri Residencial <span class="glyphicon glyphicon-earphone" style="float:right"aria-hidden="true"></span> </a>
      <br>
      <!-- <a id="sc6" class="btn btn-info btn-block">Toulouse Residencial <span class="glyphicon glyphicon-earphone" style="float:right"aria-hidden="true"></span> </a>
      <br> -->
      <a id="sc7" class="btn btn-info btn-block">Show Room <span class="glyphicon glyphicon-earphone" style="float:right"aria-hidden="true"></span> </a>

  </div>


  <div class="col-md-4">
    <br><br><br><br>
    <div class="form-group">
      <label for="comment">Comment:</label>
      <textarea class="form-control" rows="9" id="comment" readonly>

<?php
foreach ($V as $key => $value) {
  echo "\nFecha llamda: $value->fecha \n
Hora llamada: $value->hora \n
Estatus llamada: $value->estatus \n
Observaciones llamada: $value->observaciones \n
------------------------------------------------------------------------------";
}
 ?>




      </textarea>
    </div>
  </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>
<script>
$("#telefonoLlamar").click(function(event) {
  var ext = "<?php echo session('extension'); ?>";
  var num = '9' + $("#telefono").val();
  $.get('/llamar/'+ num +'/'+ ext + '',function(response,state){
    console.log(response);
  });
});
$("#sc1").click(function(event) {
  var ext = "<?php echo session('extension'); ?>";
  var num = '956613351'
  $.get('/llamar/'+ num +'/'+ ext + '',function(response,state){
    console.log(response);
  });
});
$("#sc2").click(function(event) {
  var ext = "<?php echo session('extension'); ?>";
  var num = '956011458'
  $.get('/llamar/'+ num +'/'+ ext + '',function(response,state){
    console.log(response);
  });
});
$("#sc3").click(function(event) {
  var ext = "<?php echo session('extension'); ?>";
  var num = '955596895'
  $.get('/llamar/'+ num +'/'+ ext + '',function(response,state){
    console.log(response);
  });
});
$("#sc4").click(function(event) {
  var ext = "<?php echo session('extension'); ?>";
  var num = '955573940'
  $.get('/llamar/'+ num +'/'+ ext + '',function(response,state){
    console.log(response);
  });
});
$("#sc5").click(function(event) {
  var ext = "<?php echo session('extension'); ?>";
  var num = '953350281'
  $.get('/llamar/'+ num +'/'+ ext + '',function(response,state){
    console.log(response);
  });
});
$("#sc6").click(function(event) {
  var ext = "<?php echo session('extension'); ?>";
  var num = '955364930'
  $.get('/llamar/'+ num +'/'+ ext + '',function(response,state){
    console.log(response);
  });
});
$("#sc7").click(function(event) {
  var ext = "<?php echo session('extension'); ?>";
  var num = '56011034'
  $.get('/llamar/'+ num +'/'+ ext + '',function(response,state){
    console.log(response);
  });
});
// Wind Universidad	56613351
// Wind del Valle II	56011458
// Wind Condos del Valle	55596895
// Wind Nápoles	55573940
// Capri Residencial	53350281
// Toulouse Residencial	55364930

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>