<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'CalidadController@Ventas',
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
                    <?php echo e(Form::label('Fecha de venta','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::date('fechaVenta','',array('class'=>"form-control", 'placeholder'=>"********"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Fecha de monitoreo','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                         <?php echo e(Form::date('fechaMon',date('Y-m-d'),array('class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly'))); ?>

                    </div>
                </div>


                <div class="form-group">
                    <?php echo e(Form::label('Script de Colocacion','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('script', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Informacion Brindada','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('informacion', [
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
                    <?php echo e(Form::label('sondeo y escucha Activa','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('sondeo', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Manejo de Objeciones','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('objeciones', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Cierre de venta','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('venta', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Lenguaje','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('lenguaje', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Modulacion y Diccion','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('modulacion', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Manejo de la llamada','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('llamada', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Error Critico','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                      <?php echo e(Form::select('error', [
                      '0' => 'Si',
                      '1' => 'No'],
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


<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.calidad.inbursa.inbursa', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>