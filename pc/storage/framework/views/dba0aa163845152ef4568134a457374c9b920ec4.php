<?php $__env->startSection('content'); ?>
<?php
$value = Session::all();
$totalCitas=0;
$totalAsis=0;
$totalAct=0;
?>


            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Capacitacion</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                  <tr>
                                    <th>Reclutador</th>
                                    <th>Agendados</th>
                                    <th>Asistieron</th>
                                    <th>Activos</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach($array as $key => $value): ?>
                                  <tr>
                                    <td><?php echo e($value['nombre']); ?></td>
                                    <td><?php echo e($value['num']); ?></td>
                                    <td><?php echo e($value['asistidos']); ?></td>
                                    <td><?php echo e($value['activos']); ?></td>
                                  </tr>
                                  <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

<!--
        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>   -->
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