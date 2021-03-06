<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Asistencia</h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'CoordinadorController@ReporteAsistencia',
                                'method' => 'post',
                                'class'=>"form-horizontal"
                            ])); ?>


                <div class="form-group">
                    <?php echo e(Form::label('Fecha inicio *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::date('inicio','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Fecha fin *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::date('fin','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Área','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('area', [
                      'Operaciones' => 'Operaciones',
                      'Validación' => 'Validación',
                      'Calidad' => 'Calidad',
                      'Back-Office' => 'Back-Office',
                      'Reclutamiento' => 'Reclutamiento',
                      'Sistemas' => 'Sistemas',
                      'Administración' => 'Administración',
                      'Edición' => 'Edición',
                      'Capacitación' => 'Capacitación',
                      'Direccion General'=>'Direccion General'],
                      null, ['class'=>"form-control", 'placeholder'=>"", "onchange"=>"LlenarSelect()"]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Campaña','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('campaign', [
                        'TM Prepago' => 'TM Prepago',
                        'Inbursa' => 'Inbursa',
                        'PeopleConnect' => 'PeopleConnect',
                        'PyMES' => 'PyMES',
                        'Facebook'=>'Facebook',
                        'Mapfre'=>'Mapfre'],
                    null, ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Turno','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('turno', [
                        'Matutino' => 'Matutino',
                        'Vespertino' => 'Vespertino',
                        'Turno Completo (M)' => 'Turno Completo (M)',
                        'Turno Completo (V)' => 'Turno Completo (V)',
                        'Doble Turno'=>'Doble Turno'],
                    null, ['class'=>"form-control", 'placeholder'=>""]  )); ?>

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

<?php echo $__env->make('layout.coordinador.layoutCoordinador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>