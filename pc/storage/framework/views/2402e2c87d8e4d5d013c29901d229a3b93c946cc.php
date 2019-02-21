<?php $__env->startSection('content'); ?>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista Back-Office Banamex</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th> DN </th>
                                        <th> Estatus </th>
                                        <th> Estatus 1 </th>
                                        <th> Estatus 2 </th>
                                        <th> Estatus 3 </th>
                                        <th> Folio </th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($datos as $value): ?>
                                    <tr >
                                        <td> <a href="<?php echo e(url('BoBanamexp1/'.$value->b_id)); ?>"> <?php echo e($value->dn); ?> </a> </td>
                                    <td> <?php echo e($value->status); ?> </td>
                                    <td> <?php echo e($value->estatus_bo1); ?> </td>
                                    <td> <?php echo e($value->estatus_bo2); ?> </td>
                                    <td> <?php echo e($value->estatus_bo3); ?> </td>
                                    <td> <?php echo e($value->folio); ?> </td>
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

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>