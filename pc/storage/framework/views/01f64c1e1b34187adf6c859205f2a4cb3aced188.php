<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="jumbotron">
            <h1>Folio inexistente</h1>
            <p>El folio digitado no exite</b></p>
            <p><a href="<?php echo e(url('/Inbursa_soluciones/validacion')); ?>" class="btn btn-primary btn-lg">Regresar al menu</a></p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Inbursa.validador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>