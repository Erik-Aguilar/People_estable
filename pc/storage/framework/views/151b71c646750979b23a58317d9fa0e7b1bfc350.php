<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Back-Office Banamex</h3>

                <div style='float:right'>
                    <?php echo e(Form::button('Excel',['class'=>"btn btn-primary","onClick"=>"test()"])); ?>

                </div>
                <br>
                <br>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                    <thead>
                        <tr>
                            <th>id base</th>
                            <th>Nombre Cliente</th>
                            <th>id registro</th>
                            <th>Numero</th>
                            <th>Email</th>
                            <th>Fecha de venta</th>
                            <th>Hora de venta</th>
                            <th>Estatus BO 1</th>
                            <th>Estatus BO 2</th>
                            <th>Estatus BO 3</th>
                            <th>Folio</th>
                            <th>Back-Office</th>
                            <th>Operador</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datos as $value): ?>
                        <tr >
                            <td><?php echo e($value->b_id); ?></td>
                            <td>
                                <?php if($value->nombre): ?>
                                <?php echo e($value->nombre); ?>

                                <?php else: ?>
                                <?php echo e($value->paterno2); ?>  <?php echo e($value->materno2); ?>  <?php echo e($value->nombre2); ?>

                                <?php endif; ?>

                            </td>
                            <td><?php echo e($value->v_id); ?></td>
                            <td><?php echo e($value->dn); ?></td>
                            <td><?php echo e($value->email); ?></td>
                            <td><?php echo e($value->fecha); ?></td>
                            <td><?php echo e($value->hora); ?></td>
                            <td><?php echo e($value->estatus_bo1); ?></td>
                            <td><?php echo e($value->estatus_bo2); ?></td>
                            <td><?php echo e($value->estatus_bo3); ?></td>
                            <td><?php echo e($value->folio); ?></td>
                            <td><?php echo e($value->nombre_completo); ?></td>
                            <td><?php echo e($value->operador); ?></td>
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
<script>

    function test() {
        window.open("/banamex/generaExcel/" + "<?php echo e($fecha_i); ?>" + "/" + "<?php echo e($fecha_f); ?>", '_blank');

    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>