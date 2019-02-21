<?php $__env->startSection('content'); ?>
<div class="row">
<!-- -######################   #####################-->
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <div >
                <div>
                  <h3 class="panel-title">Reporte Marcacion / Ventas (Numerico)</h3>
                </div>
              </div>
            </div>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Marcaciones / Ventas</th>
                  <th>DN</th>
                  <th>REF 1</th>
                  <th>REF 2</th>
                  <th>No Contacto</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data as $key=>$value): ?>
                <tr>
                  <td><?php echo e($key); ?></td>
                  <td><?php echo e($value['marcado']); ?></td>
                  <td><?php echo e($value['Dn']); ?></td>
                  <td><?php echo e($value['ref1']); ?></td>
                  <td><?php echo e($value['ref2']); ?></td>
                  <td><?php echo e($value['todo']); ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <div >
                <div>
                  <h3 class="panel-title">Reporte Marcacion / Ventas (Porcentaje)</h3>
                </div>
              </div>
            </div>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Marcaciones / Ventas</th>
                  <th>DN</th>
                  <th>REF 1</th>
                  <th>REF 2</th>
                  <th>No Contacto</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data as $key=>$value): ?>
                <tr>
                  <td><?php echo e($key); ?></td>
                  <td><?php echo e($value['marcadoP']); ?>%</td>
                  <td><?php echo e($value['DnP']); ?>%</td>
                  <td><?php echo e($value['ref1P']); ?>%</td>
                  <td><?php echo e($value['ref2P']); ?>%</td>
                  <td><?php echo e($value['todoP']); ?>%</td>
                </tr>
                <?php endforeach; ?>
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