<?php $__env->startSection('content'); ?>


<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo e(session('nombre_completo')); ?> | <?php echo e($fecha); ?></h3>
      </div>
      <div class="table-body">
      <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
        <tr>
          <th style="width:200px; text-align:center;">Nombre</th>
          <th style="width:50px; text-align:center;">Puesto</th>
          <th style="width:50px; text-align:center;">Turno</th>
          <th style="width:120px; text-align:center;">Campaña/Area</th>
          <th style="width:120px; text-align:center;">Sucursal</th>
          <th style="width:120px; text-align:center;">Telefono fijo</th>
          <th style="width:120px; text-align:center;">Telefono Celular</th>
          <th style="width:120px; text-align:center;">Fecha de ingreso</th>
          <th style="width:120px; text-align:center;">Supervisor</th>
          <th style="width:70px; text-align:center;">Dia 1</th>
          <th style="width:70px; text-align:center;">Dia 2</th>
          <th style="width:70px; text-align:center;">estatus</th>
          <th style="width:50px; text-align:center;">Observaciones</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($candidatos as $valueCandidato): ?>
        <tr>
          <?php foreach($observaciones as $valueObserva): ?>
            <?php if($valueObserva->id==$valueCandidato->id): ?>
              <td class="center" style="width:50px; text-align:center;"><a href="<?php echo e(url('capacitacion/reporte/modifica/'.$fecha.'/'.$valueCandidato->id)); ?>"><?php echo e($valueCandidato->nombre_completo); ?></td>
              <td style="width:200px; text-align:center;"><?php echo e($valueCandidato->puesto); ?></td>
              <td style="width:50px; text-align:center;"><?php echo e($valueCandidato->turno); ?></td>
              <td style="width:120px; text-align:center;"><?php echo e($valueCandidato->campaign); ?> | <?php echo e($valueCandidato->area); ?></td>
              <td style="width:120px; text-align:center;"><?php echo e($valueCandidato->sucursal); ?></td>
              <td style="width:120px; text-align:center;"><?php echo e($valueCandidato->telefono_fijo); ?></td>
              <td style="width:120px; text-align:center;"><?php echo e($valueCandidato->telefono_cel); ?></td>
              <td style="width:120px; text-align:center;"><?php echo e($valueCandidato->fecha_capacitacion); ?></td>
                <td style="width:120px; text-align:center;"><?php echo e($valueCandidato->supervisor); ?></td>
              <td style="width:70px; text-align:center;"><?php echo e($valueObserva->primerDia); ?></td>
              <td style="width:70px; text-align:center;"><?php echo e($valueObserva->segundoDia); ?></td>
              <td style="width:70px; text-align:center;"><?php echo e($valueObserva->estatus); ?></td>
              <td style="width:50px; text-align:center;"><?php echo e($valueObserva->observaciones); ?></td>
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