<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de entrevistas</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Asistieron</th>
                            <th>Aceptados en Capacitación</th>
                            <th>Efectividad</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach($c2 as $valuec2): ?>
                      <tr >
                      <td><?php echo e($valuec2->nombre_completo); ?></td>
                      <td><?php echo e($valuec2->Asistieron); ?></td>
                      <td><?php echo e($valuec2->Aceptados); ?></td>
                      <td><?php echo e($valuec2->efectividad); ?></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de citas</h3>
            </div>
            <div class="panel-body">

                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Citas</th>
                            <th>Entrevistas</th>
                            <th>Efectividad</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach($c1 as $valuec1): ?>
                      <tr >
                      <td><?php echo e($valuec1->nombre_completo); ?></td>
                      <td><?php echo e($valuec1->citas); ?></td>
                      <td><?php echo e($valuec1->entrevistados); ?></td>
                      <td><?php echo e($valuec1->efectividad); ?></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de Excel Candidatos</h3>
            </div>
            <div class="panel-body">
              <div class="col-md-10 col-md-offset-5">
                <?php echo e(Form::open(['action' => 'CoordinadorController@ReporteCandidatos',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ])); ?>


                            <input type="hidden" name="F1" value="<?php echo e($F1); ?>">
                            <input type="hidden" name="F2" value="<?php echo e($F2); ?>">

                          <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default"])); ?>


              <?php echo e(Form::close()); ?>

              </div>
            </div>
        </div>
    </div>
</div>



<!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!--alertify -->
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.core.css">
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.default.css">
<script src="http://blog.reaccionestudio.com/ejemplos/alertify_js/lib/alertify.js"></script>

<script>

    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });



</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>