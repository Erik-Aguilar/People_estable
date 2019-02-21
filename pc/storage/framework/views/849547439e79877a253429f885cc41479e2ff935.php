<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">

            <h1>El candidato ha sido dado de alta </h1>
            <p><?php echo e($candidato->nombre); ?> fue dado de alta, el número asignado es <b> <?php echo e($candidato->id); ?> </b> .</p>
            <p><a href="<?php echo e(url('rh/nuevo/candidato')); ?>" class="btn btn-primary btn-lg">Registrar nuevo candidato</a></p>

        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>