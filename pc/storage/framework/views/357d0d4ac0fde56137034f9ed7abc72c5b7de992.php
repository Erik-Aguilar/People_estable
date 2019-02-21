<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">TM Prepago</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <tr>
            <th>Validador</th>
            <th>Exitosa</th>
            <th>No exitosa</th>
            <th>Total</th>
          </tr>
          <?php foreach($datos as  $key => $value): ?>
          <tr>
            <td>
              <?php echo e($value->validador); ?>

            </td>
            <td>
              <?php echo e($value->E); ?>

            </td>
            <td>
              <?php echo e($value->NE); ?>

            </td>
            <td>
              <?php echo e($value->E + $value->NE); ?>

            </td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">TM Pospago</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <tr>
            <th>Validador</th>
            <th>Exitosa</th>
            <th>No exitosa</th>
            <th>Total</th>
          </tr>
          <?php foreach($datos2 as  $key => $value): ?>
          <tr>
            <td>
              <?php echo e($value->validador); ?>

            </td>
            <td>
              <?php echo e($value->E); ?>

            </td>
            <td>
              <?php echo e($value->NE); ?>

            </td>
            <td>
              <?php echo e($value->E + $value->NE); ?>

            </td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Banamex</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <tr>
            <th>Validador</th>
            <th>Exitosa</th>
            <th>No exitosa</th>
            <th>Total</th>
          </tr>
          <?php foreach($datos3 as  $key => $value): ?>
          <tr>
            <td>
              <?php echo e($value->nombre_completo); ?>

            </td>
            <td>
              <?php echo e($value->E); ?>

            </td>
            <td>
              0
            </td>
            <td>
              <?php echo e($value->E); ?>

            </td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Inbursa</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <tr>
            <th>Validador</th>
            <th>Exitosa</th>
            <th>No exitosa</th>
            <th>Total</th>
          </tr>
          <?php foreach($datos4 as  $key => $value): ?>
          <tr>
            <td>
              <?php echo e($value->nombre_completo); ?>

            </td>
            <td>
              <?php echo e($value->E); ?>

            </td>
            <td>
              0
            </td>
            <td>
              <?php echo e($value->E); ?>

            </td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>

  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.rep.basic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>