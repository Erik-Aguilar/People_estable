<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            <h1>Usuario creado </h1>
            <p>El ticket ha sido enviado.</p>
            <p><a href="<?php echo e(url('NuevoTicket')); ?>" class="btn btn-primary btn-lg">Registrar nuevo ticket</a></p>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>