<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            <h1>Ticket contestado</h1>
            <p>El ticket ha sido contestado.</p>
            <p><a href="<?php echo e(url('ListaSistemaTicket')); ?>" class="btn btn-primary btn-lg">Ver mas tickets levantados</a></p>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>