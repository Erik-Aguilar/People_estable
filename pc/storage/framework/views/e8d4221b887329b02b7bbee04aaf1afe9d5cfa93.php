<?php $__env->startSection('content'); ?>
<style media="screen">
  div{
    font-size: 12px;
  }
</style>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Banamex folio</h3>
            </div>
            <div class="panel-body">

              <?php echo e(Form::open(['action' => 'BanamexController@Actualiza',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario"
                          ])); ?>

                          <!-- style="display:none" -->
                <div class="form-group"  align='Center'>
                    <?php echo e(Form::label('Folio','',array('class'=>"col-sm-5 control-label"))); ?>

                    <div class="col-sm-2">
                        <?php echo e(Form::text('folio','',array('id'=>'folio','class'=>"form-control", 'placeholder'=>"",'required'=>'required'))); ?>

                    </div>
                    <div class="col-sm-1" >
                      <?php echo e(Form::submit('Buscar',['class'=>"btn btn-primary",'onClick'=>'return validaVenta()'])); ?>

                    </div>
                  </div>

                <div id="send">

                </div>

                <?php echo e(Form::close()); ?>


            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>