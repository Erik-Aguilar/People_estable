<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            <?php if($mensaje==0): ?>
            <h1>Usuario creado </h1>
            <p><?php echo e($nombre); ?> fue dado de alta, el usuario asignado es <b> <?php echo e($id); ?> </b> .</p>
            <p><a href="<?php echo e(url('Administracion/root')); ?>" class="btn btn-primary btn-lg">Registrar nuevo usuario</a></p>
            <?php else: ?>
            <h1>Usuario actualizado </h1>
            <p>Los datos de <b><?php echo e($nombre); ?></b> fueron actualizados # empleado <b> <?php echo e($id); ?>. </b></p>
            <p><a href="<?php echo e(url('/Administracion/root/plantilla')); ?>" class="btn btn-primary btn-lg">Ver plantilla</a></p>
            <?php endif; ?>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>