<?php $__env->startSection('content'); ?>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Lista de audios</h3>
  </div>
  <div class="panel-body">
    <table class="table table-striped table-hover ">
      <thead>
        <tr>
          <th>Folio</th>
          <th>Telefono</th>
          <th>Fecha de venta</th>
          <th>Editor</th>
          <th>Estatus</th>
          <th>Observaciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($info as $key => $value): ?>
        <tr class="danger ver-audio " style="cursor:pointer;" data-href="<?php echo e(url('/Inbursa/Calidad/Audios/'.$value->id)); ?>">
          <td><?php echo e($value->id); ?></td>
          <td><?php echo e($value->telefono); ?></td>
          <td><?php echo e($value->fecha_capt); ?></td>
          <td><?php echo e($value->quienSubio); ?></td>
          <td><?php echo e($value->estatusSubido); ?></td>
          <td><?php echo e($value->motivoEstatus); ?></td>
        </tr>
        <?php endforeach; ?>

      </tbody>
    </table>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('contentScript'); ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
  $(".ver-audio").click(function() {
      window.location = $(this).data("href");
  });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('a.layout-master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>