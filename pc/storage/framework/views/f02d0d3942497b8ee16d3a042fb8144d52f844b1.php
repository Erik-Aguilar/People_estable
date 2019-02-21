<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte resultados de operación</h3>
            </div>
            <div class="panel-body">
              <div class="zui-wrapper">
                <div class="zui-scroller">
                <table class="zui-table table table-bordered">
                <thead>

                	<tr>
                    	<th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Fecha</th>
                    	<th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Aceptada</th>
                        <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">No encontrado</th>
                    	<th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Rechazada</th>
                    </tr>
                    
                </thead>

                    <?php foreach($valores as $key => $values): ?>
                    <tr>
                        <td style="text-align: center;"> <?php echo e($values -> fechaSubido); ?> </td>
                        <td style="text-align: center;"> <?php echo e($values -> PorAceptada); ?> %</td>
                        <td style="text-align: center;"> <?php echo e($values -> PorNoEncontrado); ?> %</td>
                        <td style="text-align: center;"> <?php echo e($values -> PorRechazada); ?> %</td>
                    </tr>
                    <?php endforeach; ?>

                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>   -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make( $menu , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>