<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Referencias Repetidas</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>DN</th>
                            <th>Referencia 1</th>
                            <th>Referencia 2</th>
                            <th>Validador</th>
                            <th>Vendedor</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $a = 1;
                      ?>
                      <?php foreach($vRef as $valuevRef): ?>
                      <tr >
                        <td><?php
                        echo $a;
                        ?></td>
                      <td><?php echo e($valuevRef->dn); ?></td>
                      <td><?php echo e($valuevRef->ctel1); ?></td>
                      <td><?php echo e($valuevRef->ctel2); ?></td>
                      <td><?php echo e($valuevRef->validador); ?></td>
                      <td><?php echo e($valuevRef->nombre); ?></td>
                      <td><?php echo e($valuevRef->fecha); ?></td>
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

<?php echo $__env->make('layout.coordinador.layoutCoordinador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>