<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Subir Reporte Inbursa </h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'ReportesController@subeInbursa',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ])); ?>


                <div class="form-group">
                    <?php echo e(Form::label('Reporte','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::file('archivo')); ?>

                    </div>
                </div>
                

                <div class="form-group">
                    <?php echo e(Form::label('Fecha de Reporte','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                       <?php echo e(Form::date('fecha','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default"])); ?>

                    </div>
                </div>
                <?php echo e(Form::close()); ?>


            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.soporte.basic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>