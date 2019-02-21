<?php $__env->startSection('content'); ?>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"></h3>
                        </div>
                        <div class="panel-body">

                          <?php echo e(Form::open(['action' => 'BoController@GuardarViejos',
                                          'method' => 'post',
                                          'class'=>"form-horizontal",
                                          'accept-charset'=>"UTF-8",
                                          'enctype'=>"multipart/form-data"
                                      ])); ?>


                          <div class="form-group">
                              <?php echo e(Form::label('DN','',array('class'=>"col-sm-2 control-label"))); ?>

                              <div class="col-sm-10">
                                  <?php echo e(Form::text('dn',$reg[0]->dn,array('required' => 'required', 'class'=>"form-control",
                                  'placeholder'=>"", 'readonly'=>''))); ?>

                              </div>
                          </div>

                          <div class="form-group">
                              <?php echo e(Form::label('Estatus *','',array('class'=>"col-sm-2 control-label"))); ?>

                              <div class="col-sm-10">
                                  <?php echo e(Form::select('estatus', [
                                  'Bienvenida'=>'Bienvenida',
                                  'Invitación a CAC' => 'Invitación a CAC',
                                  'Invitación a CAC WA' => 'Invitación a CAC WA',
                                  'Invitación Recarga/de Pre a Pos' => 'Invitación Recarga/de Pre a Pos',
                                  'Telefono incorrecto' => 'Telefono incorrecto',
                                  'Sin referencia' => 'Sin referencia',
                                  'No contacto' => 'No contacto',
                                  'Regreso a compañia anterior: Mala venta' => 'Regreso a compañia anterior: Mala venta',
                                  'Regreso a compañia anterior: Mala experiencia en CAC' => 'Regreso a compañia anterior: Mala experiencia en CAC',
                                  'Regreso a compañia anterior: No se puede adecuar equipo en CAC' => 'Regreso a compañia anterior: No se puede adecuar equipo en CAC'],
                              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                              </div>
                          </div>
                          <div class="form-group">
                              <?php echo e(Form::label('Invitacion a: *','',array('class'=>"col-sm-2 control-label"))); ?>

                              <div class="col-sm-10">
                                  <?php echo e(Form::select('invitacion', [
                                  'DN' => 'DN',
                                  'Ref1' => 'Ref1',
                                  'Ref2' => 'Ref2',
                                  'DN+Ref1+Ref2'=>'DN+Ref1+Ref2'],
                              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                              </div>
                          </div>
                          <div class="form-group">
                              <?php echo e(Form::label('Historial','',array('class'=>"col-sm-2 control-label"))); ?>

                              <div class="col-sm-10">
                                  <?php echo e(Form::textarea('hist',
                                  "Venta: ". $venta[0]->fecha.
                                  "\nValidación: ".$venta[0]->fecha_val.
				                          "\nNombre: ".$venta[0]->nombre_cliente.
                                  "\nTel1: ".$venta[0]->ctel1.
                                  "\nTel2: ".$venta[0]->ctel2.
                                  "\nHistorial:\n".$str_hist.""
                                  ,array('class'=>"form-control", 'readonly'=>""))); ?>

                              </div>
                          </div>

                          <div class="form-group">
                              <?php echo e(Form::label('Estatus Whatsapp','',array('class'=>"col-sm-2 control-label"))); ?>

                              <div class="col-sm-10">
                                  <?php echo e(Form::select('estatus_face', [
                                  'Ok' => 'Ok',
                                  'No Ok' => 'No Ok'],
                              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                              </div>
                          </div>

                          <div class="form-group">
                              <?php echo e(Form::label('Observaciones','',array('class'=>"col-sm-2 control-label"))); ?>

                              <div class="col-sm-10">
                                  <?php echo e(Form::textarea('observaciones','',array('class'=>"form-control", 'placeholder'=>""))); ?>

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

        </div>
        <?php $__env->stopSection(); ?>
        <?php $__env->startSection('content2'); ?>

        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <script>
$(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.bo.lista', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>