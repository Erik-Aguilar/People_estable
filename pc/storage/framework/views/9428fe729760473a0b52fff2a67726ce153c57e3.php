<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tickets levantados</h3>
            </div>
            <div class="panel-body">
              <div class="zui-wrapper">
                <div class="zui-scroller">
                <table class="zui-table table table-bordered">
                <thead>

                	<tr>
                        <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">N° de Ticket</th>
                    	<th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Titulo de petición</th>
                    	<th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Divición</th>
                    	<th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Estatus</th>
                        <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Fecha creada</th>
                        <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Asignado</th>
                    </tr>
                </thead>

                    <?php foreach($valores as $key => $values): ?>
                    <tr>
                        <td class="center"><a href="<?php echo e(url('VerSistemaTicket/'.$values -> id)); ?>"><?php echo e($values -> id); ?></a></td>
                        <td style="text-align: center;"> <?php echo e($values -> titulo); ?> </td>
                        <td style="text-align: center;"> <?php echo e($values -> divicion); ?> </td>
                        <td style="text-align: center;"> <?php echo e($values -> estatus); ?> </td>
                        <td style="text-align: center;"> <?php echo e($values -> hora_envio); ?> </td>
                        <td style="text-align: center;"> <?php echo e($values -> asignado); ?> </td>
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
<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>