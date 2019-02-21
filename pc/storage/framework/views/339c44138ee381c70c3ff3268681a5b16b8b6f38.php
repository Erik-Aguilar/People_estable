<?php $__env->startSection('content'); ?>
<?php
$value = Session::all();
?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Capacitacion</h3>
                        </div>
                        <div class="panel-body" style="overflow: auto">


                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <?php foreach($datos as $valueDatos): ?>
                                        <th colspan="2" style="text-align: center;"><?php echo e($valueDatos->medio_reclutamiento); ?></th>
                                    <?php endforeach; ?>
                                        <th rowspan="2" style="text-align: center;">Total</th>
                                </tr>
                                <tr>
                                    <?php foreach($datos as $valueDatos): ?>
                                        <th style="text-align: center;">#</th>
                                        <th style="text-align: center;">%</th>
                                    <?php endforeach; ?>

                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <?php foreach($datos as $valueDatos): ?>
                                        <td style="text-align: center;"><?php echo e($valueDatos->num); ?></td>
                                        <td style="text-align: center;"><?php echo e(number_format((($valueDatos->num)*100)/$total[0]->num,2,'.','')); ?></td>
                                    <?php endforeach; ?>
                                        <td style="text-align: center;"><?php echo e($total[0]->num); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
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