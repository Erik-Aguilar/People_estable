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
                                        <th>Estado</th>
                                        <th>Area</th>
                                        <th>Puesto</th>
                                        <th>Fecha Cita</th>
                                        <th># empleado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($datos as $datosValue): ?>
                                    <tr >
                                        <td class="center"><?php echo e($datosValue->nombre_completo); ?></td>
                                        <td><?php echo e($datosValue->estadoCandidato); ?></td>
                                        <td><?php echo e($datosValue->area); ?></td>
                                        <td><?php echo e($datosValue->puesto); ?></td>
                                        <td><?php echo e($datosValue->fecha_cita); ?></td>
                                        <td><?php echo e($datosValue->id); ?></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>


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