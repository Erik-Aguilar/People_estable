<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'BoBanamexController@Guardarp1',
                                          'method' => 'post',
                                          'class'=>"form-horizontal",
                                          'accept-charset'=>"UTF-8",
                                          'enctype'=>"multipart/form-data"
                                      ])); ?>


                <div class="form-group">
                    <?php echo e(Form::label('DN','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('dn',$datos[0]->dn,array('required' => 'required', 'class'=>"form-control",'placeholder'=>"", 'readonly'=>''))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Estatus *','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('estatus', [
                                  'Invitación TDC' => 'Invitación TDC',
                                  'No contacto' => 'No contacto',
                                  'Numero incorrecto' => 'Numero incorrecto'],
                              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Estatus 2*','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('estatus2', [
                                  'Recogio TDC' => 'Recogio TDC',
                                  'No Recogio TDC' => 'No Recogio TDC'],
                              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>


                <div class="form-group">
                    <?php echo e(Form::label('Referencia 1','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('ref_1',$datos[0]->telefono,array('required' => 'required', 'class'=>"form-control",
                                  'placeholder'=>"", 'readonly'=>''))); ?>

                    </div>
                </div>


                <div class="form-group">
                    <?php echo e(Form::label('Referencia 2','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('ref_2',$datos[0]->tel_domicilio,array('required' => 'required', 'class'=>"form-control",
                                  'placeholder'=>"", 'readonly'=>''))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Historial','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::textarea('hist',
                                  "Estatus: ". $datos[0]->status.
				                          "\nNombre: ".$datos[0]->nombre.' '.$datos[0]->paterno.' '.$datos[0]->materno.
                                  "\nEstatus 1: ".$datos[0]->estatus_bo1.
                                  "\nEstatus 2: ".$datos[0]->estatus_bo2.
                                  "\nEstatus 3: ".$datos[0]->estatus_bo3.
                                  "\nFecha de venta:\n".$datos[0]->fecha.""
                                  ,array('class'=>"form-control", 'readonly'=>""))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Observaciones','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::textarea('observaciones','',array('class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>


                <div class="form-group" style="display: none">
                    <div class="col-sm-10">
                        <?php echo e(Form::text('id',$datos[0]->v_id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

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

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>
<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>

<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>