<?php
$user = Session::all();
?>

@extends($menu)

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tickets</h3>
            </div>

            <div class="panel-body">

                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="col-sm-30">
                            {{ Form::label('Datos del Solicitante','',array('class'=>"col-sm-2 control-label")) }}
                        </div>
                    </div>
                    <div class="panel-body">
                        <table>
                            <thead>

                            </thead>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Nombre</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->nombre_completo,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Núm. de empleado</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->quien_solicita,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Área</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->area,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Puesto</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->puesto,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Campaña</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->campaign,'') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>


                <div class="panel panel-default">


                    <div class="panel-body">
                        <div class="col-sm-30">
                            {{ Form::label('Información del Ticket','',array('class'=>"col-sm-2 control-label")) }}
                        </div>
                    </div>

                    <div class="panel-body">
                        <table>
                            <thead>
                            </thead>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Titulo</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->titulo,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Área asignada</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->divicion,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Descripción</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->descripcion,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Fecha / hora</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->hora_envio,'') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-sm-30">
                                {{ Form::label('Observaciones','',array('class'=>"col-sm-2 control-label")) }}
                            </div>
                        </div>
                    </div>

                        <div class="form-group">
                            {{ Form::label('Estatus','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::select('estatus', [
                                    'Enviado' => 'Enviado',
                                    'En_desarollo' => 'En desarrollo',
                                    'Pendiente' => 'Pendiente',
                                    'Finalizado' => 'Finalizado'],
                                    $valores[0]->estatus, ['class'=>"form-control", 'placeholder'=>"",'disabled' => 'disabled']  ) }}
                            </div>
                        </div>

                        <div class="zui-scroller">
                            <table class="zui-table table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Comentarios del área</th>
                                        <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Tus comentarios</th>
                                    </tr>
                                </thead>

                                @foreach($ticket_com as $key => $values)
                                <tr>
                                    <td style="text-align: center;"> {{$values -> comentario_tecnico}} </td>
                                    <td style="text-align: center;"> {{$values -> comentarios_solicitante}} </td>
                                </tr>
                                @endforeach

                            </table>

                        </div>

                        <div class="form-group">
                            {{ Form::label('Comentario','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::textarea('Comentario','',array('class'=>"form-control", 'placeholder'=>"")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('VoBo','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::select('BoVoSistemas', [
                                    'No' => 'No',
                                    'Si' => 'Si'],
                                    $valores[0]->BoVoSistemas, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
</div>

@stop
