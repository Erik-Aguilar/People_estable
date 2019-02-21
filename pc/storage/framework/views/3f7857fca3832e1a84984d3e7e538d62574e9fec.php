<?php $__env->startSection('camp'); ?>
	<?php echo e($campana); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo Form::open(['route' => 'reporte.dia', 'method' => 'POST']); ?>

	<center>
		<div class="Container">
			<table class="table table-striped table-sm table-hover table-bordered" style="width:25%">
				<tbody>
				<th colspan="2"><center><?php echo e($fecha); ?></center></th>
				<tr><td><b>Estaciones</b></td><td><?php echo $estaciones; ?></td></tr>
				<tr><td><center>Matutino</center></td><td><?php echo $estaciones_mat; ?></td></tr>
				<tr><td><center>Vespertino</center></td><td><?php echo $estaciones_vesp; ?></td></tr>
				<tr><td><b>Horas</b></td><td><?php echo $horas; ?></td></tr>
				<tr><td><center>Matutino</center></td><td><?php echo $horas_mat; ?></td></tr>
				<tr><td><center>Vespertino</center></td><td><?php echo $horas_vesp; ?></td></tr>
				<tr><td><b>Ventas</b></td><td><?php echo $ventas; ?></td></tr>
				<tr><td><center>Matutino</center></td><td><?php echo $ventas_mat; ?></td></tr>
				<tr><td><center>Vespertino</center></td><td><?php echo $ventas_vesp; ?></td></tr>
				<tr><td><b>VPH</b></td><td><?php echo $VPH; ?></td></tr>
				<tr><td><center>Matutino</center></td><td><?php echo $VPH_mat; ?></td></tr>
				<tr><td><center>Vespertino</center></td><td><?php echo $VPH_vesp; ?></td></tr>
				<?php if($hora >= $hora_aux): ?>
				<tr><td><b>Ausentismo</b></td><td><?php echo $ausentismo; ?></td></tr>
				<tr><td><center>Matutino</center></td><TD> <?php echo $ausentismo_mat; ?></td></tr>
				<tr><td><center>Vespertino</center></td><td><?php echo $ausentismo_vesp; ?></td></tr>
				<?php endif; ?>
			</table>
		</div>
	</center>
<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.reporteplantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>