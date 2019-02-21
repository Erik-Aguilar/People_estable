<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reportes Soluciones</h3>
            </div>
            <div class="panel-body">
			

                <?php echo e(Form::open(['action' => 'ReportesInbursaSolucionesController@tipoReporte',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ])); ?>

                <div class="form-group">
                    <?php echo e(Form::label('Reporte','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('reporte', [
                        'Ventas por día' => 'Ventas por Día',
                        'Ventas completo' => 'Ventas Completo',
                        'Ventas Totales' => 'Ventas Totales',
                        'Estatus 2' => 'Estatus 2'],
                    '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php echo e(Form::submit('Enviar',['class'=>"btn btn-primary"])); ?>

                    </div>
                </div>
                <?php echo e(Form::close()); ?>


            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>