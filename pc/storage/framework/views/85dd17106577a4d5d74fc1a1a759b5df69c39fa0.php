<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Modulo de estatus de venta Soluciones</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Telefono</th>
                            <th>Fecha Captura</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($status as $valuestatus): ?>
                        <tr>
                            <td><?php echo e($valuestatus->id); ?></td>
                            <td><?php echo e($valuestatus->telefono); ?></td>
                            <td><?php echo e($valuestatus->fecha_capt); ?></td>
                            <td><?php echo e($valuestatus->estatus_people); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!--alertify -->
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.core.css">
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.default.css">
<script src="http://blog.reaccionestudio.com/ejemplos/alertify_js/lib/alertify.js"></script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>