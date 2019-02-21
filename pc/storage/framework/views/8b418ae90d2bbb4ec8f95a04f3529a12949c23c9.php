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
                            <th>Monitoreos</th>
                            <th>Calificacion</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $a = 1;
                      ?>
                      <?php foreach($CALIDAD as $valueCALIDAD): ?>
                      <tr >
                        <td><?php
                        echo $a;
                        ?></td>
                        <?php if($var=='RECH'): ?>
                      <td><?php echo e($valueCALIDAD->nombre_completo); ?></td>
                      <?php else: ?>
                      <td><a href="<?php echo e(url('/calidad/jefeCalidad/verMonitoreoAO/'.$valueCALIDAD->calidad.'/'.$var.'/'.$F1.'/'.$F2)); ?>"><?php echo e($valueCALIDAD->nombre_completo); ?></a></td>
                        <?php endif; ?>


                      <td><?php echo e($valueCALIDAD->monitoreo); ?></td>
                      <td><?php echo e($valueCALIDAD->calificacion); ?></td>
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

<?php echo $__env->make('layout.calidad.jefeCalidad.jefeCalidad', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>