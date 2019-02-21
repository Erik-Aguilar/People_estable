<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo e($fecha); ?></h3>
      </div>
      <div class="panel-body">
      <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
          <th style="width:200px; text-align:center;">Sucursal</th>
          <th style="width:50px; text-align:center;">Capacitacion</th>
          <th style="width:50px; text-align:center;">Activos</th>
        </thead>
        <tbody>
        <tr>
          <th colspan="3">Zapata</th>
        </tr>
        <?php for($i=0;$i<1;$i++): ?>
        <tr>
          <td>Matutino</td>
          <td><?php echo e($candidatosZapata[$i]->matutino); ?></td>
          <td><?php echo e($activosZapata[$i]->matutino); ?></td>
        </tr>
        <tr>
          <td>Vespertino</td>
          <td><?php echo e($candidatosZapata[$i]->vespertino); ?></td>
          <td><?php echo e($activosZapata[$i]->vespertino); ?></td>
        </tr>
        <tr>
          <td>Turno Completo (M)</td>
          <td><?php echo e($candidatosZapata[$i]->turnocompletom); ?></td>
          <td><?php echo e($activosZapata[$i]->turnocompletom); ?></td>
        </tr>
        <tr>
          <td>Turno Completo (V)</td>
          <td><?php echo e($candidatosZapata[$i]->turnocompletov); ?></td>
          <td><?php echo e($activosZapata[$i]->turnocompletov); ?></td>
        </tr>
        <tr>
          <td>Doble Turno</td>
          <td><?php echo e($candidatosZapata[$i]->dobleturno); ?></td>
          <td><?php echo e($activosZapata[$i]->dobleturno); ?></td>
        </tr>
        <?php endfor; ?>
        <tr>
          <th  colspan="3">Roma</th>
        </tr>
        <?php for($i=0;$i<1;$i++): ?>
        <tr>
          <td>Matutino</td>
          <td><?php echo e($candidatosRoma[$i]->matutino); ?></td>
          <td><?php echo e($activosRoma[$i]->matutino); ?></td>
        </tr>
        <tr>
          <td>Vespertino</td>
          <td><?php echo e($candidatosRoma[$i]->vespertino); ?></td>
          <td><?php echo e($activosRoma[$i]->vespertino); ?></td>
        </tr>
        <tr>
          <td>Turno Completo (M)</td>
          <td><?php echo e($candidatosRoma[$i]->turnocompletom); ?></td>
          <td><?php echo e($activosRoma[$i]->turnocompletom); ?></td>
        </tr>
        <tr>
          <td>Turno Completo (V)</td>
          <td><?php echo e($candidatosRoma[$i]->turnocompletov); ?></td>
          <td><?php echo e($activosRoma[$i]->turnocompletov); ?></td>
        </tr>
        <tr>
          <td>Doble Turno</td>
          <td><?php echo e($candidatosRoma[$i]->dobleturno); ?></td>
          <td><?php echo e($activosRoma[$i]->dobleturno); ?></td>
        </tr>
        <?php endfor; ?>

        </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>
        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <script>
        $(document).ready(function ()
        {
          $('#dataTables-example').DataTable({
              responsive: true
          });
        });
        </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>