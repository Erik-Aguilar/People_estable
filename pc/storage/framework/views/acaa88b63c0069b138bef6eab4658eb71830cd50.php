<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'CalidadPreController@updateVentas',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name' => "formulario"
                            ])); ?>


                <div class="row">
                    <div class="col-md-10 col-md-push-2">
                        <h3>
                            <?php echo e($datos[0]->nombre_completo); ?>

                        </h3>
                        <div class="form-group" >
                            <div class="col-sm-10" style='display: none;'>
                                <?php echo e(Form::text('idVentas',$datos[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                            </div>
                            <div class="col-sm-10" style='display: none;'>
                                <?php echo e(Form::text('id',$datos[0]->nombre,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('DN','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('dn',$datos[0]->dn,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Fecha de venta','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::date('fechaVenta',$datos[0]->fecha_venta,array('required' => 'required','class'=>"form-control", 'placeholder'=>"********"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Fecha de monitoreo','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::date('fechaMon',$datos[0]->fecha_monitoreo,array('required' => 'required','class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Informacion Brindada','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('informacion', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $datos[0]->inf_brindada, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Captura de datos','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('captura', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $datos[0]->captura_datos, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('sondeo y escucha Activa','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('sondeo', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $datos[0]->sondeo, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Manejo de Objeciones','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('objeciones', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $datos[0]->manejo_objeciones, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Cierre de venta','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('venta', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $datos[0]->cierre_venta, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Protocolo de transferencia','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('transferencia', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $datos[0]->transferencia, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Lenguaje','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('lenguaje', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $datos[0]->lenguaje, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Modulacion y Diccion','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('modulacion', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $datos[0]->modulacion_diccion, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Manejo de la llamada','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('llamada', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $datos[0]->manejo_llamada, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Error Critico','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('error', [
                      '0' => 'Si',
                      '1' => 'No'],
                      $datos[0]->error_critico, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Observaciones','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('observaciones',$datos[0]->observaciones,array('class'=>"form-control", 'placeholder'=>""))); ?>

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