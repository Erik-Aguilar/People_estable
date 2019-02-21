<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Ver Editores</h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                      <tr>
                        <th>Numero de Empleado</th>
                        <th>Nombre</th>
                        <th>Campaña</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach($editor as $valueeditor): ?>
                             <tr>
                               <td><a href="<?php echo e(url('/CambioEditor/'.$valueeditor->id)); ?>" ><?php echo e($valueeditor->id); ?></a></td>
                               <td><?php echo e($valueeditor->nombre_completo); ?></td>
                               <td><?php echo e($valueeditor->campaign); ?></td>
                             </tr>
                             <?php endforeach; ?>
                  </tbody>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!--alertify -->

<script>

    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });



</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.demos.reporte', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>