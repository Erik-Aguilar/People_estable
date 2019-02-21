<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="jumbotron">
            <h1>Base Asignada</h1>
            <p><a href="<?php echo e(url('/bo')); ?>" class="btn btn-primary btn-lg">Siguiente</a></p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>