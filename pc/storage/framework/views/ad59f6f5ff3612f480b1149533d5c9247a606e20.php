<?php $__env->startSection('content'); ?>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Calidad</h3>
  </div>
  <div class="panel-body">

    <form class="form-horizontal" action="<?php echo e(url('/Inbursa/Calidad/Audios/Lista')); ?>" method="post">
      <fieldset>
        <legend>Seleccione una fecha</legend>
        <div class="form-group">
          <label for="inputEmail" class="col-lg-2 control-label">Fecha de edición</label>
          <div class="col-lg-8">
            <input type="date" class="form-control" name="fecha" value="<?php echo e(date('Y-m-d')); ?>">
          </div>
          <div class="col-lg-2">
            <!-- <button type="reset" class="btn btn-default">Cancel</button> -->
            <button type="submit" class="btn btn-primary">Buscar</button>
          </div>
        </div>


      </fieldset>
    </form>

  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('a.layout-master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>