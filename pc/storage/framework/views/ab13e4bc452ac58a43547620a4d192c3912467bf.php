<?php $__env->startSection('content'); ?>
            <div class="row">
                <div class="col-md-12 ">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='25'>
                                <thead>
                                    <tr>
                                        <th>N. empleado</th>
                                        <th>Supervisor</th>
                                        <th>Campaña</th>
                                        <th>Matutino</th>
                                        <th>Matutino Completo</th>
                                        <th>Vespertino</th>
                                        <th>Turno Completo</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($datos as $datosValue): ?>
                                    <tr >
                                        <td class="center"><?php echo e($datosValue->idsup); ?></td>
                                        <td><?php echo e($datosValue->nombre_completo); ?></td>
                                        <td><?php echo e($datosValue->campaign); ?></td>
                                        <td><?php echo e($datosValue->Matutino); ?></td>
                                        <td><?php echo e($datosValue->Matutino_Completo); ?></td>
                                        <td><?php echo e($datosValue->Vespertino); ?></td>
                                        <td><?php echo e($datosValue->Turno_Completo); ?></td>
                                        <td><?php echo e($datosValue->Total); ?></td>
                                        
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
        order:[2,'desc']
        
    });
});
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.rep.basic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>