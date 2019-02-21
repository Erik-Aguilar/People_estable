<?php $__env->startSection('content'); ?>
<?php
$total=0;
?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reportes</h3>
      </div>
      <div class="panel-body">

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th>Area</th>
              <th>Supervisor</th>
              <th>Personal</th>
            </tr>
            <?php foreach($data as $key => $value): ?>
              <tr>
                <td>
                  <?php echo e($value->area); ?>

                </td>
                <td>
                  <?php echo e($value->nombre_completo); ?>

                </td>
                <td class='val'>
                  <a href="<?php echo e(url('Administracion/personal/datos/'.$value->supervisor.'/'.$value->area)); ?>">
                  <?php echo e($value->per); ?>

                  <?php $total+=$value->per;?>
                </td>
              </tr>
            <?php endforeach; ?>
            <tr>
              <th>Total</th>
              <td></td>
              <td><?php echo e($total); ?></td>
            </tr>

          </table>
        </div>

      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>