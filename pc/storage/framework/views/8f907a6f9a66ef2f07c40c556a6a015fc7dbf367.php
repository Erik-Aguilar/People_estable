<?php
$user = Session::all();
?>



<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tickets sistema</h3>
            </div>
            <div class="panel-body">
                <?php echo e(Form::open(['action' => 'TicketController@SistemaGuardaTicket',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=>'formulario'
                            ])); ?>


                <div class="panel panel-default">
                    <div class="panel-body">
                        <!--<div class="form-group">
                            <div class="col-sm-30">
                                <?php echo e(Form::label('Datos del Solicitante','',array('class'=>"col-sm-2 control-label"))); ?>

                            </div>
                        </div>-->

                        <table border="0">
                            <thead>
                                <tr>
                            <div class="form-group">
                                <div class="col-sm-30">
                                    <?php echo e(Form::label('Datos del Solicitante','',array('class'=>"col-sm-2 control-label"))); ?>

                                </div>
                            </div>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo e(Form::label('Nombre: ','',array('class'=>"col-sm-2 control-label"))); ?></td>
                                    <td><?php echo e(Form::label($valores[0]->nombre_completo,'',array('class'=>"col-sm-10 control-label"))); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo e(Form::label('N° de empleado: ','',array('class'=>"col-sm-2 control-label"))); ?></td>
                                    <td><?php echo e(Form::label($valores[0]->quien_solicita,'',array('class'=>"col-sm-8 control-label"))); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo e(Form::label('Area: ','',array('class'=>"col-sm-2 control-label"))); ?></td>
                                    <td><?php echo e(Form::label($valores[0]->area,'',array('class'=>"col-sm-8 control-label"))); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo e(Form::label('Puesto: ','',array('class'=>"col-sm-2 control-label"))); ?></td>
                                    <td><?php echo e(Form::label($valores[0]->puesto,'',array('class'=>"col-sm-8 control-label"))); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo e(Form::label('Campaña: ','',array('class'=>"col-sm-2 control-label"))); ?></td>
                                    <td><?php echo e(Form::label($valores[0]->campaign,'',array('class'=>"col-sm-8 control-label"))); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <!--<div class="form-group">
                            <div class="col-sm-30">
                                <?php echo e(Form::label('Datos del Solicitante','',array('class'=>"col-sm-2 control-label"))); ?>

                            </div>
                        </div>-->

                        <table border="0">
                            <thead>
                                <tr>
                            <div class="form-group">
                                <div class="col-sm-30">
                                    <?php echo e(Form::label('Solicitud','',array('class'=>"col-sm-2 control-label"))); ?>

                                </div>
                            </div>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo e(Form::label('titulo: ','',array('class'=>"col-sm-2 control-label"))); ?></td>
                                    <td><?php echo e(Form::label($valores[0]->titulo,'',array('class'=>"col-sm-10 control-label"))); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo e(Form::label('Divicion: ','',array('class'=>"col-sm-2 control-label"))); ?></td>
                                    <td><?php echo e(Form::label($valores[0]->divicion,'',array('class'=>"col-sm-8 control-label"))); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo e(Form::label('Descripcion: ','',array('class'=>"col-sm-2 control-label"))); ?></td>
                                    <td><?php echo e(Form::label($valores[0]->descripcion,'',array('class'=>"col-sm-8 control-label"))); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo e(Form::label('Fecha/hora: ','',array('class'=>"col-sm-2 control-label"))); ?></td>
                                    <td><?php echo e(Form::label($valores[0]->hora_envio,'',array('class'=>"col-sm-8 control-label"))); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                                <div class="col-sm-30">
                                    <?php echo e(Form::label('Datos internos','',array('class'=>"col-sm-2 control-label"))); ?>

                                </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <?php echo e(Form::label('N° de solicitud: ','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::text('id',$valores[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                            </div>
                        </div>
                                
                        <div class="form-group">
                            <?php echo e(Form::label('Asignar','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::select('asignado', [
                                    '' => '',
                                    'Erick Aguilar' => 'Erick Aguilar',
                                    'Eymmy Castro' => 'Eymmy Castro',
                                    'Salomon Diaz' => 'Salomon Diaz'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly']  )); ?>

                            </div>
                        </div>
                        
                        <div class="form-group">
                            <?php echo e(Form::label('Estatus','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::select('estatus', [
                                    '' => '',
                                    'Enviado' => 'Enviado',
                                    'En_desarollo' => 'En desarrollo',
                                    'Pendiente' => 'Pendiente',
                                    'Finalizado' => 'Finalizado'],
                                    $valores[0]->estatus, ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                            </div>
                        </div>
                        
                        <div class="form-group">
                            <?php echo e(Form::label('Tiempo estimado *','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::text('tiempo_estimado','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                            </div>
                        </div>
                        
                        <div class="form-group">
                            <?php echo e(Form::label('Comentarios tecnico ','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::textarea('comen_tecnico','',array('class'=>"form-control", 'placeholder'=>""))); ?>

                            </div>
                        </div>
                        
                        <div class="form-group">
                            <?php echo e(Form::label('Comentarios a solicitante ','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::textarea('comen_solicita','',array('class'=>"form-control", 'placeholder'=>""))); ?>

                            </div>
                        </div>
                        
                        <div class="form-group">
                            <?php echo e(Form::label('BoVo','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::select('divicion', [
                                    'No' => 'No',
                                    'Si' => 'Si'],
                                    '', ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                            </div>
                        </div>
                        
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

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>