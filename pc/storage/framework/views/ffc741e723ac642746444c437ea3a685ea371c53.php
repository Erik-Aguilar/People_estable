<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-body">
                <?php echo e(Form::open([
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario"
                                ])); ?>


                <div class="form-group">
                    <?php echo e(Form::label('Telefono','',array('class'=>"col-sm-3 control-label"))); ?>

                    <div class="col-sm-8">
                        <?php echo e(Form::text('telefono',$datos[0]->telefono,array('class'=>"form-control"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('colonia','',array('class'=>"col-sm-3 control-label"))); ?>

                    <div class="col-sm-8">
                        <?php echo e(Form::text('telefono',$datos[0]->colonia,array('class'=>"form-control"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Ciudad','',array('class'=>"col-sm-3 control-label"))); ?>

                    <div class="col-sm-8">
                        <?php echo e(Form::text('telefono',$datos[0]->ciudad,array('class'=>"form-control"))); ?>

                    </div>
                </div>
                                
                <div class="form-group">
                    <?php echo e(Form::label('Estado','',array('class'=>"col-sm-3 control-label"))); ?>

                    <div class="col-sm-8">
                        <?php echo e(Form::text('estado',$datos[0]->estado,array('class'=>"form-control"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('imagen','',array('class'=>"col-sm-3 control-label"))); ?>

                    <div class="col-sm-8">
                        <?php echo e(Form::text('telefono',$datos[0]->imagen,array('class'=>"form-control"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('link','',array('class'=>"col-sm-3 control-label"))); ?>

                    <div class="col-sm-8">
                        <?php echo e(Form::text('link',$datos[0]->link,array('class'=>"form-control"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Marca','',array('class'=>"col-sm-3 control-label"))); ?>

                    <div class="col-sm-8">
                        <?php echo e(Form::text('marca',$datos[0]->marca,array('class'=>"form-control"))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('modelo','',array('class'=>"col-sm-3 control-label"))); ?>

                    <div class="col-sm-8">
                        <?php echo e(Form::text('modelo',$datos[0]->modelo,array('class'=>"form-control"))); ?>

                    </div>
                </div>
                                
                <div class="form-group">
                    <?php echo e(Form::label('Tipificacion','',array('class'=>"col-sm-3 control-label"))); ?>

                    <div class="col-sm-8">
                        <?php echo e(Form::text('tipificacion',$datos[0]->tipificacion,array('class'=>"form-control"))); ?>

                    </div>
                </div>
                                
                <div class="form-group">
                    <?php echo e(Form::label('Detalle','',array('class'=>"col-sm-3 control-label"))); ?>

                    <div class="col-sm-8">
                        <?php echo e(Form::text('Detalle',$datos[0]->detalle,array('class'=>"form-control"))); ?>

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

<?php echo $__env->make('layout.VivaAnuncios.viva', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>