<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte edición por Tipificación</h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'EdicionController@reportePorTipificacion',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ])); ?>


                <div class="form-group">
                    <?php echo e(Form::label('Fecha Inicio','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::date('fecha_i','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Fecha Fin','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::date('fecha_f','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********", ))); ?>

                    </div>
                </div>

                 <div class="form-group">
                    <?php echo e(Form::label('Campaña','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('campaign', [
                        'Inbursa' => 'Inbursa',
                        'Mapfre'=>'Mapfre'],
                    null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required']  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Tipo de reporte','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('tipo', [
                        'vista' => 'Vista web',
                        'descarga'=>'Descarga'],
                    null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required']  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default"])); ?>

                    </div>
                </div>


                <?php echo e(Form::close()); ?>

                

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make( $menu , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>