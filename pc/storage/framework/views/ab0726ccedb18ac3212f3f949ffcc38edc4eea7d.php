<?php $__env->startSection('content'); ?>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">DN no validados</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DN</th>
                                        <th>Fecha</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($datos as $key => $value): ?>
                                    <tr>
                                        <td><?php echo e($key+1); ?></td>
                                        <td><a href="<?php echo e(url('/calidad/prepago/novalidado/'.$value->dn)); ?>"><?php echo e($value->dn); ?></a></td>
                                        <td><?php echo e($value->fecha); ?></td>
                                        <td><?php echo e($value->estatus); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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

<?php echo $__env->make('layout.calidad.prepago.prepago', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>