<?php $__env->startSection('content'); ?>

<?php
$value = Session::all();
// dd($value);


$hora=date('H:i:s');
?>



<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-body">
              <?php echo e(Form::open(['action' => 'InbursaSolucionesController@FromularioInbSoluciones',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario",
                              'onsubmit'=>'return validar()'
                                ])); ?>



                                <div class="form-group">
                                    <?php echo e(Form::label('Telefonos','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->telefonos,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Razon Social','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->razon_social,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Marca','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->marca,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                 <div class="form-group">
                                    <?php echo e(Form::label('Calle','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->calle,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Colonia','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->colonia,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Municipio','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->municipio,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Estado','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->estado,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('CP','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->cp,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('RFC','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->rfc,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                

                                <div class="form-group">
                                    <?php echo e(Form::label('Sector','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->sector,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Giro','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->giro,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Nombre 1','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->nombre1,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Apellidos 1','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->apellidos1,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Correo 1','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->correo1,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                 
                                 <div class="form-group">
                                    <?php echo e(Form::label('Nombre 2','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->nombre2,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Apellidos 2','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->apellidos2,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Correo 2','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->correo2,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>                                


                                <div class="form-group">
                                    <?php echo e(Form::label('Nombre 3','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->nombre3,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Apellidos 3','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->apellidos3,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Correo 3','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->correo3,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>


                                <div class="form-group">
                                    <?php echo e(Form::label('Nombre 4','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->nombre4,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Apellidos 4','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->apellidos4,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Correo 4','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->correo4,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>



               <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo e(asset('/assets/js/jquery-3_2_1.min.js')); ?>" ></script>
<script type="text/javascript">

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.inbursaSoluciones.agente.agente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>