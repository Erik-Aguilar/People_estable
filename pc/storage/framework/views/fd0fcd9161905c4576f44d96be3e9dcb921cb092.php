<?php $__env->startSection('content'); ?>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Envio de reporte de ventas Inbursa</h3>
  </div>
  <div class="panel-body">

    <form class="form-horizontal" action="<?php echo e(url('/Inbursa/Reportes/Envio/Ventas/Guardar')); ?>" method="post" enctype="multipart/form-data">
      <fieldset>
        <legend>Proporcione la información solicitada</legend>
        <div class="form-group">
          <label for="inputEmail" class="col-lg-3 control-label">Fecha de venta</label>
          <div class="col-lg-8">
            <input type="date" class="form-control" name="fecha" value="<?php echo e(date('Y-m-d')); ?>">
          </div>
          <!-- <div class="col-lg-2">
            <button type="submit" class="btn btn-primary">Buscar</button>
          </div> -->
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-lg-3 control-label">Archivo de venta</label>
          <div class="col-lg-8">
            <input type="file" class="form-control" name="archivo_venta" required=required>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-lg-3 control-label">Archivo de rechazos</label>
          <div class="col-lg-8">
            <input type="file" class="form-control" name="archivo_rechazo" required=required>
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

<?php echo $__env->make('a.layout-master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>