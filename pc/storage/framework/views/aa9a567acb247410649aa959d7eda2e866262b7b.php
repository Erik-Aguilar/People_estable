<?php $__env->startSection('content'); ?>
<?php
$value = Session::all();
?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ventas | <?php echo e($value['nombre']); ?></h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">folio</th>
                                        <th style="text-align: center;">Nombre operador</th>
                                        <th style="text-align: center;">Cliente</th>
                                        <th style="text-align: center;">DN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($datos as $datosValues): ?>
                                    <tr >
                                      <td class="center" style="text-align: center;"><a href="<?php echo e(url('facebook/updateValida/'.$datosValues->id)); ?>"><?php echo e($datosValues->id); ?></a></td>
                                        <td style="text-align: center;"><?php echo e($datosValues->nombre_completo); ?></td>
                                        <td style="text-align: center;"><?php echo e($datosValues->paterno); ?> <?php echo e($datosValues->materno); ?> <?php echo e($datosValues->nombre); ?></td>
                                        <td class="center" style="text-align: center;"><?php echo e($datosValues->dn); ?></td>
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

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>