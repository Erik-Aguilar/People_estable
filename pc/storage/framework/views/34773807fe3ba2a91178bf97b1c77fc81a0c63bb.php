<?php
$user = Session::all();
?>



<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tickets</h3>
            </div>
            <div class="panel-body">
                
                <?php echo e(Form::open(['action' => 'TicketController@NuevoTicket',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=>'formulario'
                            ])); ?>

                
                <div class="panel-body">
                <div class="form-group">
                    <h3 class="panel-title">
                        <?php echo e(Form::label('',$user['nombre_completo'],array('class'=>"col-sm-2 control-label"))); ?>

                    </h3>

                    <h5 class="panel-title">
                        <?php echo e(Form::label('',$user['user'],array('class'=>"col-sm-2 control-label"))); ?>

                    </h5>

                    <h5 class="panel-title">
                        <?php echo e(Form::label('',$user['area'],array('class'=>"col-sm-2 control-label"))); ?>

                    </h5>
                    <h5 class="panel-title">
                        <?php echo e(Form::label('',$user['puesto'],array('class'=>"col-sm-2 control-label"))); ?>

                    </h5>
                </div>
                <hr/>
                
                <div class="form-group">
                    <?php echo e(Form::label('Titulo *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('titulo',null,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>
                
                <br/>

                <div class="form-group">
                    <?php echo e(Form::label('Divición','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('divicion', [
                            '' => '',
                            'Sistemas' => 'Sistemas',
                            'Soporte' => 'Soporte'],
                        '', ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>
                
                <hr/>
                
                <div class="form-group">
                    <?php echo e(Form::label('Descripción *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('descripcion','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>
                
                <hr/>
                
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

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>