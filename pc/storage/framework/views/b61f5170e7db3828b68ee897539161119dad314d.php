<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'RechazosController@CapturaUpdate',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=>'formulario'
                            ])); ?>



                <div class="form-group">
                    <?php echo e(Form::label('DN *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('dn',$bo[0]['dn'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"","readOnly"=>'readOnly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Fecha de Validación *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::date('fechaVal',date('Y-m-d',strtotime($bo[0]['fecha_val'])),array('required' => 'required','class'=>"form-control","readOnly"=>'readOnly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Operador *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('operadorName',$bo[0]['operador'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"","readOnly"=>'readOnly'))); ?>

                        <div style="display:none">
                          <?php echo e(Form::text('operador',$bo[0]['operador_id'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'display'=>'none'))); ?>

                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Validador *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('validadorName',$bo[0]['validador'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"","readOnly"=>'readOnly'))); ?>

                        <div style="display:none">
                          <?php echo e(Form::text('validador',$bo[0]['validador_id'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo e(Form::label('Analista de BO *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('analistaBo',$backO,
                        $bo[0]['analistaBo'], ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>



                <div class="form-group">
                    <?php echo e(Form::label('Imputable A: *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('imputable', [
                        'Validador' => 'Validador',
                        'Operador-Validador' => 'Operador, Validador',
                        'Validador-Back-Office' => 'Validador, Back-Office',
                        'Operador' => 'Operador',
                        'BackOffice'=>'BackOffice',
                        'No Aplica'=>'No Aplica'],
                    $bo[0]['imputable'], ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('¿Recuperación Exitosa? *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('recuperacion', [
                        'Si' => 'Si',
                        'No' => 'No'],
                    $bo[0]['recuperacion'], ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Nip Proporcionado por Cliente *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                    <?php echo e(Form::text('nip',$bo[0]['nip'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                  </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Comentarios *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::textarea('comentarios',$bo[0]['comentarios'],array('required' => 'required','class'=>"form-control", 'placeholder'=>""))); ?>

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

<?php echo $__env->make("layout.calidad.prepago.prepago", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>