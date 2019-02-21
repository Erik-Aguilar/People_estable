<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Editor Modificado</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12 col-md-offset-5">
                  <a href="<?php echo e(url('/VerEditores')); ?>" class="btn btn-default">Camios relizados</a>
                </div>
              </div>

            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.edicion.edicion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>