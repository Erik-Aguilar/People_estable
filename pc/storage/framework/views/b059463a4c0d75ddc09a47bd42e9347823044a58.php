<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            <h1>Ya existe un candidato con el mismo nombre </h1>
            <p><a href="<?php echo e(url('rh/inicio')); ?>" class="btn btn-primary btn-lg">Registrar nuevo candidato</a></p>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.rh.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>