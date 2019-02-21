<?php $__env->startSection('content'); ?>


<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reporte de cancelaciones </h3>
      </div>
      <div class="panel-body" style="overflow: auto;">
          <table class="table table-bordered" style="float: left;" >
            <thead  style="">
              <tr>
                <th > Fecha </th>
                <th > Tipificacion </th>
                <th > Total </th>
              </tr>
            </thead>

            <tbody>
              <?php foreach($datos as $key => $value): ?>
              	<tr>
                     	<td> <?php echo e($value->fecha); ?> </td>
              		    <td> <?php echo e($value->tipificar); ?> </td>
                      <td> <?php echo e($value->total); ?> </td>
              	</tr>
              <?php endforeach; ?>
            </tbody>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>