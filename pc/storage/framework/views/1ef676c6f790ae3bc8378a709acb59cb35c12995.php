<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">

            <h1>Folio Capturado</h1>
            <p>Numero de folio <b><?php echo e($folio); ?></b>. </b></p>
            <p><a href="<?php echo e(url('/InbursaVidatel/agente/downsession')); ?>" class="btn btn-primary btn-lg">Siguiente</a></p>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.InbursaVidatel.agente.agente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>