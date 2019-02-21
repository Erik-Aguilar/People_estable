<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de calidad por analista</h3>
            </div>
            <div class="panel-body">

                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre analista</th>
                            <th>Campaña</th>
                            <?php if($var=='VEN'): ?>
                            <th>VPH</th>
                            <?php endif; ?>
                            <th>Monitoreos</th>
                            <?php if($var!='RECH'): ?>
                            <th>Calificacion</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $a = 1;
                      ?>
                      <?php foreach($array as $value): ?>
                      <tr >
                        <td><?php
                        echo $a;
                        ?></td>
                        <?php if($var=='RECH'): ?>
                      <td><?php echo e($value['nombre']); ?></td>
                      <?php else: ?>
                      <td><a href="<?php echo e(url('/Administracion/root/verMonitoreoAO/'.$value['id'].'/'.$var.'/'.$F1.'/'.$F2)); ?>">
                        <?php echo e($value['nombre']); ?></a></td>
                        <?php endif; ?>

                      <td><?php echo e($value['campaign']); ?></td>
                      <?php if($var=='VEN'): ?>
                      <td><?php echo e($value['vph']); ?></td>
                      <?php endif; ?>
                      <td><?php echo e($value['num']); ?></td>
                      <?php if($var!='RECH'): ?>
                      <td><?php echo e($value['calificacion']); ?></td>
                      <?php endif; ?>
                      </tr>
                      <?php
                      $a ++;
                      ?>
                      <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>




<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>