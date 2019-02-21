<?php $__env->startSection('content'); ?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Back-Office Banamex</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Folio</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($datos as $value): ?>
                                    <tr>
                                      <td><a href="<?php echo e(url('/banamex/backoffice/'.$value->v_id)); ?>"><?php echo e($value->v_id); ?></a></td>
                                      <td><?php echo e($value->folio); ?></td>
                                      <td><?php echo e($value->bo_captura==null?'':'Capturado'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
        <script>



        </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>
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