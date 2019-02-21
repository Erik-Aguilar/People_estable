<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'CalidadPreController@Validacion',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name' => "formulario"
                            ])); ?>


                <div class="row">
                    <div class="col-md-10 col-md-push-2">
                        <h3>
                            <?php echo e($user[0]->nombre_completo); ?>

                        </h3>
                        <div class="form-group" style='display: none;'>

                            <div class="col-sm-10">
                                <?php echo e(Form::text('id',$user[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                            </div>
                        </div>
                        <div class="form-group" style='display: none;'>
                            <div class="col-sm-10">
                                 <?php echo e(Form::date('date',$date,array('class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly'))); ?>

                            </div>
                        </div>
                        <div class="form-group" style='display: none;'>
                            <div class="col-sm-10">
                                 <?php echo e(Form::date('end_date',$end_date,array('class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly'))); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('DN','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('dn',null,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Fecha de validacion','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::date('fechaValidacion','',array('required' => 'required','class'=>"form-control", 'placeholder'=>"********"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Fecha de monitoreo','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::date('fechaMon',date('Y-m-d'),array('required' => 'required','class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Presentacion','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('presentacion', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Aviso de Privacidad','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('aviso', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Escucha Activa','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('escucha', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Captura de datos','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('captura', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Manejo de objeciones','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('objeciones', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Error Critico','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('error', [
                      'No'=>'No',
                      'No Tipificar' => 'No Tipificar',
                      'NIP para cancelacion' => 'NIP para cancelacion',
                      'Informacion Falsa'=>'Informacion Falsa',
                      'No Solicitar Referencia'=>'No Solicitar Referencia'
                      ],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Observaciones','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('observaciones',null,array('class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default"])); ?>

                    </div>
                </div>
                <?php echo e(Form::close()); ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.calidad.prepago.prepago', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>