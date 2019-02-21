<?php $__env->startSection('content'); ?>
<?php
$value = Session::all();
?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Validacion Inbursa</h3>
            </div>
            <div class="panel-body">
            <?php echo e(Form::open(['action' => 'ValidacionInbController@Valida',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name' => "formulario"
                            ])); ?>

            	<div class="form-group">
                    <?php echo e(Form::label('Folio','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('folio','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

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
<script>
</script>

<?php echo $__env->make('layout.Inbursa.validador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>