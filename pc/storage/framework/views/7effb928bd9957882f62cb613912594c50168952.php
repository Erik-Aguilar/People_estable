<?php $__env->startSection('content'); ?>

<div class="panel panel-primary col-md-6 col-md-offset-3" >
  <div class="panel-heading">
    <h3 class="panel-title">Subir Cuadro de Mando</h3>
  </div>
  <div class="panel-body">

    <form class="form-horizontal" action="<?php echo e(url('/subeCM2')); ?>" method="post" enctype="multipart/form-data">
      <fieldset>
        <div class="form-group">
          <label for="inputEmail" class="col-lg-3 control-label">Archivo Cuadro de Mando</label>
          <div class="col-lg-8">
            <input type="file" class="form-control" name="archivo_venta" required=required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-12">
            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </div>
      </fieldset>
    </form>

  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>