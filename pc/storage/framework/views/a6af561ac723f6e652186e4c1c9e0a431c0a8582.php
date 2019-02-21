<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">

                <h3 class="panel-title"><?php echo e($fecha); ?></h3>
            </div>
            <div class="panel-body">

              <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                  <thead>
                  <tr>
                          <th style="text-align: center;">DN</th>
                          <th style="text-align: center;">Facebook</th>
                          <th style="text-align: center;">Vendedor</th>
                          <th style="text-align: center;">Turno</th>
                          <th style="text-align: center;">Estatus</th>
                          <th style="text-align: center;">Ultima Actualización</th>
                  </tr>
                  </thead>
                  <tbody>

                        <?php foreach($ventas as $ventasValue): ?>
                        <tr>
                          <td style="text-align: center;"><?php echo e($ventasValue->dn); ?></td>
                          <td style="text-align: center;"><?php echo e($ventasValue->nombre_completo); ?></td>
                          <td style="text-align: center;"><?php echo e($ventasValue->val); ?></td>
                          <td style="text-align: center;"><?php echo e($ventasValue->turno); ?></td>
                          <td style="text-align: center;"><?php echo e($ventasValue->estatus); ?></td>
                          <td style="text-align: center;"><?php echo e($ventasValue->updated_at); ?></td>
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
        responsive: true,
        order:[2,'desc']
    });
});
        </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>