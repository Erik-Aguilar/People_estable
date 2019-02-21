<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Validacion Ventas Inbursa Soluciones</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Folio</th>
                            <th>Numero</th>                            
                            <th>Fecha Venta</th>
                            <th>Fecha Envio</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $num =0; ?>
                    <?php foreach ($datos as $key => $value): ?>
                            <tr >
                                <td> <?php echo e($num+=1); ?> </td>
                                <td> <a href="<?php echo e(url('Inbursa_soluciones/ValidacionesDia/'.$value -> id)); ?>"> <?php echo e($value -> id); ?> </a> </td>
                                <td> <?php echo e($value -> telefono); ?> </td>
                                <td> <?php echo e($value -> fecha_capt); ?> </td>
                                <td> <?php echo e($value -> fecha_envio); ?> </td>
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

<?php echo $__env->make('layout.inbursaSoluciones.validador.validador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>