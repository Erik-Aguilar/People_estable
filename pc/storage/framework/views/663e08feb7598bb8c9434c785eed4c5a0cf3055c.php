<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Audios Ventas Bancomer</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Numero</th>
                            <th>Teléfono</th>
                            <th>Fecha</th>
                            <th>Estatus de venta</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $num =0; ?>
                    <?php foreach ($datos as $key => $value): ?>
                        <tr >
                            <td><?php echo e($num+=1); ?> </td>
                            <td> <a href="<?php echo e(url('Bancomer/datos/'.$value -> dn.'/'.$value -> fecha.'/'.$value -> v_id )); ?>"><?php echo e($value -> dn); ?> </a></td>
                            <td> <?php echo e($value -> fecha); ?> </td>
                            <td> <?php echo e($value -> status); ?> </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Bancomer.Edicion.edicion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>