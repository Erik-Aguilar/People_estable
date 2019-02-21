<?php
$user = Session::all();
?>



<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tickets</h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'TicketController@NuevoTicket',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=>'formulario'
                            ])); ?>


                <div class="panel-body">
                    <div class="form-group">
                        <h3 class="panel-title">
                            <?php echo e(Form::label('',$user['nombre_completo'],array('class'=>"col-sm-2 control-label"))); ?>

                        </h3>

                        <h5 class="panel-title">
                            <?php echo e(Form::label('',$user['user'],array('class'=>"col-sm-2 control-label"))); ?>

                        </h5>

                        <h5 class="panel-title">
                            <?php echo e(Form::label('',$user['area'],array('class'=>"col-sm-2 control-label"))); ?>

                        </h5>
                        <h5 class="panel-title">
                            <?php echo e(Form::label('',$user['puesto'],array('class'=>"col-sm-2 control-label"))); ?>

                        </h5>
                    </div>
                    <hr/>

                    <div class="form-group">
                        <?php echo e(Form::label('Titulo *','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-10">
                            <?php echo e(Form::text('titulo','',array('id'=>'titu','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                    </div>

                    <br/>

                    <div class="form-group">
                        <?php echo e(Form::label('Área','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-10">
                            <?php echo e(Form::select('divicion',[
                            'Desarrollo' => 'Desarrollo',
                            'Soporte Tecnico' => 'Soporte Tecnico',
                            'Operaciones' => 'Operaciones'
                            ],
                        null, [ 'id'=>'areas','class'=>"form-control", 'placeholder'=>""]  )); ?>

                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        <?php echo e(Form::label('Descripción','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-10">
                            <?php echo e(Form::textarea('descripcion','',array('id'=>'descrip','class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default","onClick"=>"test()"])); ?>

                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                    <script>

                        function test() {
                            //$("#titu").val();
                            //console.log($("#titu").val());
                            //console.log($("#areas").val());
                            //console.log($("#descrip").val());
                            //console.log('<?php echo e($user['nombre_completo']); ?>');

                            //, nombre_completo:'<?php echo e($user['nombre_completo']); ?>', num_empleado:<?php echo e($user['user']); ?>,area:<?php echo e($user['area']); ?>,puesto:<?php echo e($user['puesto']); ?>

                            $.ajax({
                            type: "POST",
                                    url: "http://peopleconnect.com.mx/desarrollo/salomon/ticket.php",
                                    data: {titulo:$("#titu").val(), areaTicket:$("#areas").val(), descripcion:$("#descrip").val(), nombre_completo:'<?php echo e($user['nombre_completo']); ?>', num_empleado:'<?php echo e($user['user']); ?>', area:'<?php echo e($user['area']); ?>', puesto:'<?php echo e($user['puesto']); ?>', }
                            ,
                            success: function (data) {
                                console.log(data);
                                }
                            }
                            );
                        }

                    </script>

                </div>
            </div>
        </div>
    </div>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>