<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Ventas a recuperar </h3>
            </div>
            <div class="panel-body">


                <table class="table  table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Numero de Venta</th>
                            <th>Teléfono</th>
                            <th>Fecha</th>
                            <th>Estatus</th>
                            <th>Estatus BO 1</th>
                            <th>Estatus BO 2</th>
                            <th>Estatus BO 3</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    
                    <?php foreach($recuperacion as $key => $value): ?>
                        <tr >
                            <td> <a href="<?php echo e(url('recuperacionBanamex/'.$value->v_id)); ?>"> <?php echo e($value -> v_id); ?> </a></td>
                            <td> <?php echo e($value -> dn); ?> </a></td>
                            <td> <?php echo e($value -> fecha); ?> </td>
                            <td> <?php echo e($value -> status); ?> </td>
                            <td> <?php echo e($value -> estatus_bo1); ?> </td>
                            <td> <?php echo e($value -> estatus_bo2); ?> </td>
                            <td> <?php echo e($value -> estatus_bo3); ?> </td>
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

<?php echo $__env->make('layout.Banamex.bo.bo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>