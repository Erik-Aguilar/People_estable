<?php $__env->startSection('content'); ?>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reporte Auditoria a Reclutamiento</h3>
      </div>
      <div class="panel-body">

        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th rowspan="2">Reclutador</th>
              <?php foreach($fechaValue as $valueFecha): ?>
                 <th colspan='2'><?php echo e($valueFecha); ?></th>
              <?php endforeach; ?>
              </tr>
              <tr>
              <?php foreach($fechaValue as $fecha): ?>
                  <th>Núm. Llamadas</th>
                  <th>Promedio por Día</th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
          <?php foreach($val as $valValue): ?>

            <tr>
              <td><?php echo e($valValue['nombre']); ?></td>
              <?php foreach($fechaValue as $fecha): ?>
                  <?php if(array_key_exists($fecha,$valValue)): ?>
                    <td style="text-align:center;"><?php echo e($valValue[$fecha]); ?></td>
                    <td style="text-align:center;"><?php echo e($valValue['Calidad'.$fecha]); ?>%</td>
                  <?php else: ?>
                    <td style="text-align:center;">--</td>
                    <td style="text-align:center;">--</td>
                  <?php endif; ?>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
<?php $__env->stopSection(); ?>
<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>