<?php $__env->startSection('content'); ?>
<?php
$value = Session::all();
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">inbox | <?php echo e($value['nombre']); ?></h3>
            </div>
            <div class="panel-body">

              <?php echo e(Form::open(['action' => 'FaceBookVentasController@BaseFace',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data"
                          ])); ?>


              <div class="form-group">
                  <?php echo e(Form::label('DN *','',array('class'=>"col-sm-2 control-label"))); ?>

                  <div class="col-sm-10">
                      <?php echo e(Form::text('dn',null,array('required' => 'required','class'=>"form-control", 'placeholder'=>"",'onChange'=>'validacion(this.value)','id'=>'telefono','maxlength'=>'10'))); ?>

                  </div>
              </div>
              <div class="form-group">
                  <?php echo e(Form::label('Paterno','',array('class'=>"col-sm-2 control-label"))); ?>

                  <div class="col-sm-10">
                      <?php echo e(Form::text('paterno',null,array('class'=>"form-control", 'placeholder'=>"",'id'=>'paterno'))); ?>

                  </div>
              </div>
              <div class="form-group">
                  <?php echo e(Form::label('Materno','',array('class'=>"col-sm-2 control-label"))); ?>

                  <div class="col-sm-10">
                      <?php echo e(Form::text('materno',null,array('class'=>"form-control", 'placeholder'=>"",'id'=>'materno'))); ?>

                  </div>
              </div>
              <div class="form-group">
                  <?php echo e(Form::label('Nombre','',array('class'=>"col-sm-2 control-label"))); ?>

                  <div class="col-sm-10">
                      <?php echo e(Form::text('nombres',null,array('class'=>"form-control", 'placeholder'=>"",'id'=>'nombre'))); ?>

                  </div>
              </div>

              <div class="form-group">
                  <?php echo e(Form::label('Estatus *','',array('class'=>"col-sm-2 control-label"))); ?>

                  <div class="col-sm-10">
                      <?php echo e(Form::select('estatusp', [
                      'Prospecto' => 'Prospecto',
                      'No Prospecto' => 'No Prospecto'],
                  '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'valida()','id'=>'estatus']  )); ?>

                  </div>
              </div>

              <div class="form-group" style='display:none;' id='noProspecto'>
                  <?php echo e(Form::label('Estatus No Prospecto*','',array('class'=>"col-sm-2 control-label"))); ?>

                  <div class="col-sm-10">
                      <?php echo e(Form::select('noestatusp', [
                      'Movistar' => 'Movistar',
                      'Menor de Edad' => 'Menor de Edad',
                      'Nextel' => 'Nextel',
                      'Plan de Renta' => 'Plan de Renta',
                      'Telefono Fijo' => 'Telefono Fijo',
                      'Linea Suspendida' => 'Linea Suspendida'],
                  '', ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                  </div>
              </div>
              <div class="form-group">
                  <?php echo e(Form::label('Horario de llamada *','',array('class'=>"col-sm-2 control-label"))); ?>

                  <div class="col-sm-10">
                      <?php echo e(Form::time('h_llamada',null,array('class'=>"form-control", 'placeholder'=>"",'id'=>'nombre operador','required' => 'required'))); ?>

                  </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                      <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default"])); ?>

                  </div>
              </div>
              <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>
<script>
function valida(argument) {
  if($('#estatus').val()=='No Prospecto')
  {
    $('#noProspecto').attr("style",'');
  }
  else
  {
    $('#noProspecto').attr("style",'display:none');

  }
  console.log($('#motivo').val());
}

</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>