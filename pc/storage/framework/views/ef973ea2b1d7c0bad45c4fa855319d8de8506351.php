<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Plantilla</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th rowspan="2">Nombre del Ejecutivo</th>
                            <th rowspan="2">Supervisor</th>
                            <th rowspan="2">Campaña</th>
                            <th rowspan="2">Fecha de Ingreso</th>
                            <?php foreach($fechaValue as $value): ?>
                                <th colspan="2"><?php echo e($value); ?></th>
                            <?php endforeach; ?>
                            <th rowspan="2">Numero de monitoreos</th>
                        </tr>
                        <tr>
                            <?php foreach($fechaValue as $value): ?>
                              <th>Calidad</th>
                              <th>VPH</th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach($datosArray as $key => $value): ?>
                        <tr>
                            <td> <a href="<?php echo e(url('calidad/inbursa/ventas/reporte/'.$value['id'].'/'.$fecha_i.'/'.$fecha_f)); ?>"><?php echo e($value['nombre']); ?></a></td>
                            <td><?php echo e($value['supervisor']); ?></td>
                            <td><?php echo e($value['campaign']); ?></td>
                            <td><?php echo e($value['fecha_ingreso']); ?></td>

                            <?php foreach($fechaValue as $valueFecha): ?>

                              <?php if( $value['calidad'.$valueFecha]==="--" ): ?>
                                <td>--</td>
                              <?php else: ?>
                                <td><a href="<?php echo e(url('calidad/inbursa/ventas/NumMon/'.$value['id'].'/'.$valueFecha)); ?>"><?php echo e($value['calidad'.$valueFecha]); ?></a></td>
                              <?php endif; ?>

                              <?php if(array_key_exists('vph'.$valueFecha,$value)): ?>
                                <td><?php echo e($value['vph'.$valueFecha]); ?></td>
                              <?php else: ?>
                                <td>--</td>
                              <?php endif; ?>
                            <?php endforeach; ?>

                            <?php if(array_key_exists('monitoreo',$value)): ?>
                              <td><?php echo e($value['monitoreo']); ?></td>
                            <?php else: ?>
                              <td>--</td>
                            <?php endif; ?>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.calidad.inbursa.inbursa', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>