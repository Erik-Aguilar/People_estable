<?php $__env->startSection('content'); ?>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">



                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th>DN</th>
                                        <th>Estatus TM</th>
                                        <th>Estatus PC</th>
                                        <th>Actualización TM</th>
                                        <th>Actualización PC</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($news as $user): ?>
                                    <tr >
                                    <td><?php echo e($user->dn); ?></td>
                                    <td><?php echo e($user->tipificar); ?></td>
                                    <td><?php echo e($user->st_interno); ?></td>
                                    <td><?php echo e($user->actualizacion); ?></td>
                                    <td><?php echo e($user->ac_interno); ?></td>
                                    <td class="center"><a href="<?php echo e(url('bo/nuevos/ges/'.$user->dn)); ?>">Ver</a></td>
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
        "order": [[ 3, 'desc' ]]
    });
});
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.bo.lista', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>