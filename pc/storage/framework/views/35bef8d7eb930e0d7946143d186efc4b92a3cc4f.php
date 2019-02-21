<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'CoordinadorController@ActualizaUser',
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
                        <div class="form-group">

                            <div class="col-sm-10">
                                <?php echo e(Form::text('id',$user[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Nombre','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre',$user[0]->nombre,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Paterno','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('paterno',$user[0]->paterno,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Materno','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('materno',$user[0]->materno,array('class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Teléfono fijo','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::number('telefono_fijo',$datosCandidato[0]->telefono_fijo,array('class'=>"form-control", 'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Teléfono celular','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::number('telefono_cel',$datosCandidato[0]->telefono_cel,array('class'=>"form-control", 'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Usuario externo','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('user_ext',$user[0]->user_ext,array('class'=>"form-control", 'placeholder'=>"PC0000", 'readonly'=>'readonly'))); ?>

                    </div>
                </div>

                <div class="form-group" style='display: none;'>
                    <div class="col-sm-10">
                        <?php echo e(Form::text('puesto',$datosCandidato[0]->puesto,array('class'=>"form-control",'id'=>'puesto'))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Supervisor','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('supervisor', $super,
                    $user[0]->supervisor, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'sup']  )); ?>

                    </div>
                </div>

                
                <div class="form-group">
                    <?php echo e(Form::label('Analista de calidad','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('analistaCalidad',$analistaCalidad,
                        $DetalleEmpleado[0]->analistaCalidad, ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Validador','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('validador',$teamLeader,
                        $DetalleEmpleado[0]->teamLeader, ['class'=>"form-control", 'placeholder'=>""]  )); ?>

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
                        'Facebook'=>'Facebook'],
                    $datosCandidato[0]->campaign, ['class'=>"form-control", 'placeholder'=>"",'id'=>'campaign','onChange'=>'validacion()']  )); ?>


                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Estatus','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                          <?php echo e(Form::select('estatus', [
                        'Inactivo' => 'Inactivo',
                        'Activo' => 'Activo'],
                    $user[0]->estatus, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>    
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
<script>
    function validacion()
{
    var val=$('#puesto').val();
    var camp=$('#campaign').val();
    console.log(val);
    $.ajax({

                url:   "coor/"+val+"/"+camp,

                type:  'get',
                beforeSend: function () {
                        console.log('espere');

                },
                success:  function (data)
                {
                    console.log(data);

                    $('#sup').empty();

                    $('#sup').append(new Option('', ''));
                    for(i=0;i<data.length;i++)
                    {
                        $('#sup').append('<option value="'+data[i].id+'">'+data[i].nombre_completo+'</option>');
                    }

                }
        });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.coordinador.layoutCoordinador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>