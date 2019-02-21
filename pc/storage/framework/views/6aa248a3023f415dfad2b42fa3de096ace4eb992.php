<?php $__env->startSection('content'); ?>
<?php
$value = Session::all();
?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Área</th>
                                        <th>Puesto</th>
                                        <th>Campaña</th>
                                        <th># Empleado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($datos as $valueDatos): ?>
                                    <tr >
                                        <td class="center"><a href="<?php echo e(url('coordinador/candidato/'.$valueDatos->id)); ?>"><?php echo e($valueDatos->nombre_completo); ?></td>
                                        <td><?php echo e($valueDatos->area); ?></td>
                                        <td><?php echo e($valueDatos->puesto); ?></td>
                                        <td><?php echo e($valueDatos->campaign); ?></a></td>
                                        <td><?php echo e($valueDatos->id); ?></a></td>
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
        responsive: true
    });
});
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make( $menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>