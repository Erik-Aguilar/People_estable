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
                                    <?php echo e(Form::label('id','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('id',$datos[0]->id,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <?php echo e(Form::label('Telefono1 asd','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->tel1,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <?php echo e(Form::label('Telefono2','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->tel2,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Telefono3','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->tel3,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <?php echo e(Form::label('Marca','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->marca,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>

                                 <div class="form-group">
                                    <?php echo e(Form::label('RFC','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->rfc,array('class'=>"form-control"))); ?>

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
                                    <?php echo e(Form::label('ciudad','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->ciudad,array('class'=>"form-control"))); ?>

                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <?php echo e(Form::label('estado','',array('class'=>"col-sm-3 control-label"))); ?>

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
                                    <?php echo e(Form::label('correo','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('telefono',$datos[0]->correo,array('class'=>"form-control"))); ?>

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

    function checkKeyCode(evt){
        var evt = (evt) ? evt : ((event) ? event : null);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if(event.keyCode==116){
            evt.keyCode=0;
            return false
        }
    }
    document.onkeydown=checkKeyCode;
    
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.inbursaSoluciones.agente.agente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>