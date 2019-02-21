<?php $__env->startSection('content'); ?>
<?php
$value = Session::all();
?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte general de operación/ Coordinador (Telefonica) / Supervisor</h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Supervisor</th>
                    <th>Agentes activos matutino</th>
                    <th>Agentes activos vespertino</th>
                    <th>Ventas matutino</th>
                    <th>Ventas vespertino</th>
                    <th>VPH matutino</th>
                    <th>VPH vespertino</th>
                  </tr>

                </thead>
                <tbody>
                  <?php $con=0; $mat=0; $ves=0; $ventmat=0;$ventves=0;?>
                  <?php foreach($val as $key => $value): ?>
                  <tr>
                    <?php $con=$con+1; ?>
                     <td><?php echo e($con); ?></td>
                      <td ><a href="<?php echo e(url('coordinador/rgo/agente/'.$key.'/'.$value['nombre'].'/'.$date.'/'.$end_date)); ?>"><?php echo e($value['nombre']); ?></a></td>
                      <td><?php echo e($value['matutino']); ?></td>   <!-- Toal de Plantilla Matunino-->
                      <td><?php echo e($value['vespertino']); ?></td>
                      <td><?php echo e($value['VentMatutino']); ?></td>   <!--Ventas Matutino-->
                      <td><?php echo e($value['VentVespertino']); ?></td>   <!--Ventas Vespertino-->
                      <td><?php echo e($value['PorVentMatutino']); ?></td>   <!--VPH Matutino-->
                      <td><?php echo e($value['PorVentVespertino']); ?></td>   <!--VPH Vespertino-->
                  </tr>
                  <?php $mat=$mat+$value['matutino']; $ves=$ves+$value['vespertino']; $ventmat=$ventmat+$value['VentMatutino']; $ventves=$ventves+$value['VentVespertino'];?>
                  <?php endforeach; ?>

                </tbody>
                <tbody>
                  <tr>
                    <th colspan="2">Total</th>
                    <td><?php echo e($mat); ?></td>
                    <td><?php echo e($ves); ?></td>
                    <td><?php echo e($ventmat); ?></td>
                    <td><?php echo e($ventves); ?></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
             </table>
          </div>
        </div>
    </div>
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

<?php echo $__env->make('layout.coordinador.layoutCoordinador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>