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
                                <th>Número de empleado</th>
                                <th>Nombre completo</th>
                                <th>Hora de entrada</th>
                            </tr>
                        </thead>
    	                <tbody>
                            <?php foreach($valores as $key => $values): ?>
                    		<tr>
                        		<td> <?php echo e($values -> id); ?> </td>
                        		<td> <?php echo e($values -> nombre); ?> </td>
                        		<td> <?php echo e($values -> hora); ?> </td>
                        	</tr>
                			<?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make( $menu , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>