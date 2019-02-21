<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Cambiar Editores Campaña</h3>
            </div>
            <div class="panel-body">

              <?php echo e(Form::open(['action' => 'EdicionController@UpFormEdit',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data"
                          ])); ?>


                          <div class="form-group">
                              <?php echo e(Form::label('ID','',array('class'=>"col-sm-2 control-label"))); ?>

                              <div class="col-sm-8">
                                      <?php echo e(Form::text('id',$detalle[0]->id, array('class' => 'form-control', 'readonly'=>'readonly'))); ?>

                              </div>
                          </div>

                          <div class="form-group">
                              <?php echo e(Form::label('Nombre','',array('class'=>"col-sm-2 control-label"))); ?>

                              <div class="col-sm-8">
                                      <?php echo e(Form::text('nombre_completo',$detalle[0]->nombre_completo, array('class' => 'form-control', 'readonly'=>'readonly'))); ?>

                              </div>
                          </div>

                          <div class="form-group">
                              <?php echo e(Form::label('Campaña','',array('class'=>"col-sm-2 control-label"))); ?>

                              <div class="col-sm-8">
                                  <?php echo e(Form::select('campaign', [
                                  'Inbursa' => 'Inbursa',
                                  'Mapfre'=>'Mapfre'],
                              $detalle[0]->campaign, ['class'=>"form-control", 'placeholder'=>"",'id'=>'campaign','onChange'=>'validacion(),ACalidad()']  )); ?>

                              </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12 col-md-offset-5">
                              <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default"])); ?>

                            </div>
                          </div>

            <?php echo e(Form::close()); ?>



            </div>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.edicion.edicion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>