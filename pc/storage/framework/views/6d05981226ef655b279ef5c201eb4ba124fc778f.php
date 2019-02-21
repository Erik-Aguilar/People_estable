<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            
            <h1 style="text-align: center;">Bienvenido</h1>
                  <p style="text-align: center;"><?php echo e(session('nombre_completo')); ?>.</p>
        </div>

    </div>
</div>
<script>
setTimeout(function () {
   window.location.href = "<?php echo e(url('salir')); ?>"; //will redirect to your blog page (an ex: blog.html)
}, 4000);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.rh.ingreso', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>