<?php $__env->startSection('content'); ?>
<?php
    $value = Session::all();
?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e($moni[0]->nombre); ?> <?php echo e($moni[0]->paterno); ?> <?php echo e($moni[0]->materno); ?></h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DN</th>
                                        <th>Resultado</th>
                                        <th>Fecha de Monitoreo</th>
                                        <th>Fecha de Venta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($moni as $key=>$ValueMoni): ?>
                                    <tr >
                                        <td><?php echo e($key+1); ?></td>
                                        <td class="center"><a href="<?php echo e(url('/calidad/inbursaVidatel/ventas/update/'.$ValueMoni->id)); ?>"><?php echo e($ValueMoni->dn); ?></td>
                                        <td><?php echo e($ValueMoni->resultado); ?> %</td>
                                        <td><?php echo e($ValueMoni->fecha_monitoreo); ?></td>
                                        <td><?php echo e($ValueMoni->fecha_venta); ?></td>
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

<?php echo $__env->make('layout.calidad.inbursa.inbursa', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>