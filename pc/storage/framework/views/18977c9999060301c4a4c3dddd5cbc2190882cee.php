<?php $__env->startSection('content'); ?>
<div class="row">
<!-- -###################### Fin TM Prepago  #####################-->
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <div >
                <div>
                  <h3 class="panel-title">Reporte general de operación / Agentes</h3>
                </div>
              </div>
            </div>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Ventas</th>
                  <th>VPH</th>
                  <th>Calidad</th>
                </tr>
              </thead>
              <tbody>
                <?php $cont=1; $vent=0;?>
                <?php foreach($ar as $key=>$value): ?>
                <tr>
                  <td><?php echo e($cont); ?></td>
                  <td><?php echo e($value['name']); ?></td>
                  <td><?php echo e($value['ventas']); ?></td>
                  <td><?php echo e($value['vph']); ?></td>
                  <td><?php echo e($value['calidad']); ?>%</td>
                </tr>
                <?php
                  $cont++;
                  $vent+=$value['ventas'];
                ?>
                <?php endforeach; ?>
              </tbody>
              <tbody>
                <tr>

                  <td colspan="2">Total</td>
                  <td><?php echo e($vent); ?></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
        </div>
    </div>
<!-- -###################### Fin TM Prepago  #####################-->

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>
<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
$('#dataTables-example').DataTable({
responsive: true
});
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>