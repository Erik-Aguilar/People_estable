<?php $__env->startSection('content'); ?>
<?php
$value = Session::all();
?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Citas Agendadas</h3>
                        </div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Reclutador</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($citas as $valueCitas): ?>
                                    <tr >
                                        <td class="center"><a href="<?php echo e(url('citas/captura/'.$valueCitas->id)); ?>"><?php echo e($valueCitas->id); ?></td>
                                        <td><?php echo e($valueCitas->nombre); ?>

                                        <?php echo e($valueCitas->paterno); ?>

                                        <?php echo e($valueCitas->materno); ?></td>
                                        <td><?php echo e($valueCitas->nombre_completo); ?>  </td>
                                        <td><?php echo e($valueCitas->fecha_cita); ?></td>
                                    </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
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
        order:[3,'desc']
    });
});
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>