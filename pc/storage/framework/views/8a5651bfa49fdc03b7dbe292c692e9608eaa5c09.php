<?php
$user = Session::all();
?>



<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo e(Form::label($valores[0]->id,'')); ?>  -  <?php echo e(Form::label($valores[0]->titulo,'')); ?></h3>
            </div>
            <div class="panel-body">
                

                <div class="panel panel-default">
                    <div class="panel-body">
                        <table>
                            <thead>
                            <div class="form-group">
                                <?php echo e(Form::label('Datos del Solicitante','',array('class'=>"col-sm-2 control-label"))); ?>

                            </div>
                            </thead>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Nombre</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->nombre_completo,'')); ?></td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Núm. de empleado</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->quien_solicita,'')); ?></td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Área</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->area,'')); ?></td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Puesto</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->puesto,'')); ?></td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Campaña</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->campaign,'')); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-body">
                        <table>
                            <thead>
                            <div class="form-group">
                                <?php echo e(Form::label('Información del Ticket','',array('class'=>"col-sm-2 control-label"))); ?>

                            </div>
                            </thead>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Número de Ticket</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->id,'')); ?></td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Titulo</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->titulo,'')); ?></td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Descripción</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->descripcion,'')); ?></td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Fecha / hora</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->hora_envio,'')); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                            
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table>
                            <thead>
                            <div class="form-group">
                                <?php echo e(Form::label('Atención del Ticket','',array('class'=>"col-sm-2 control-label"))); ?>

                            </div>
                            </thead>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Área asiganda</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->divicion,'')); ?></td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Encargado</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->nom_encargado,'')); ?></td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Asignado</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->nom_asignado,'')); ?></td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Tiempo estimado de termino</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->tiempo_estimado,'')); ?></td>
                            </tr>
                            <tr id ="trid">
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">VoBo del Área</td>
                                <td id="<?php echo e($valores[0]->BoVoSistemas); ?>"  class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;"><?php echo e(Form::label($valores[0]->BoVoSistemas,'')); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php echo e(Form::label('Observaciones','',array('class'=>"col-sm-2 control-label"))); ?>

                    </div>
                    
                    <div class="form-group">
                            <?php echo e(Form::label('Estatus: ','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::select('estatus', [
                                    'Enviado' => 'Enviado',
                                    'En_desarollo' => 'En desarrollo',
                                    'Pendiente' => 'Pendiente',
                                    'Finalizado' => 'Finalizado'],
                                    $valores[0]->estatus, ['class'=>"form-control",'readonly'=>'readonly', "id"=>'estatus', 'disabled' => 'false']  )); ?>

                            </div>
                        </div>
                    
                    
                    <div class="form-group">
                            <?php echo e(Form::label('Comentarios','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::textarea('comen_solicita','',array('class'=>"form-control", 'placeholder'=>""))); ?>

                            </div>
                        </div>

                    <div class="panel-body">
                        <div class="zui-scroller">
                            <table class="zui-table table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Encargado</th>
                                        <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Fecha</th>
                                        <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Hora</th>
                                        <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Comentarios del área</th>
                                        <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Tus comentarios</th>
                                        <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Estatus</th>
                                    </tr>
                                </thead>

                                <?php foreach($ticket_histo as $key => $values): ?>
                                <tr>
                                    <td style="text-align: left;"> <?php echo e($values -> nombre_completo); ?> </td>
                                    <td style="text-align: left;"> <?php echo e($values -> dia); ?> </td>
                                    <td style="text-align: left;"> <?php echo e($values -> hora); ?> </td>
                                    <td style="text-align: left;"> <?php echo e($values -> comentario_tecnico); ?> </td>
                                    <td style="text-align: left;"> <?php echo e($values -> comentarios_solicitante); ?> </td>
                                    <td style="text-align: left;"> <?php echo e($values -> estatus); ?> </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>

                        <div class="form-group">
                            <?php echo e(Form::label('VoBo','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::select('BoVo', [
                                    'No' => 'No',
                                    'Si' => 'Si'],
                                    $valores[0]->BoVoSolicitante, ['class'=>"form-control",'id'=>'vob', "onChange"=>"bovoSis()"]  )); ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default"])); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>

   $(document).ready(function () {
       console.log($(this).text() );
       
        $("#trid td").click(function(){
               alert($(this).text());
       });
       
        
    });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>