<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            <?php if($val==1): ?>
              <h1>Venta Capturada </h1>
              <!-- <h1>Registro Capturado</h1> -->
              <p>Folio:<b><?php echo e($fol); ?></b></p>
              <p><a href="<?php echo e(url('/banamex')); ?>" class="btn btn-primary btn-lg">Nuevo Registro</a></p>
            <?php else: ?>
              <h1>Registro Capturado</h1>
              <p>Folio:<b><?php echo e($fol); ?></b></p>
              <p><a href="<?php echo e(url('/banamex')); ?>" class="btn btn-primary btn-lg">Nuevo Registro</a></p>
            <?php endif; ?>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>