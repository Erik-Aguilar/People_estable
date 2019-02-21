<?php
$user = Session::all();
?>
    
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            <h1>Contraseña actualizada</h1>
            <p><a href="<?php echo e(url('Administracion/admin/plantilla')); ?>" class="btn btn-primary btn-lg">Ver plantilla</a></p>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>