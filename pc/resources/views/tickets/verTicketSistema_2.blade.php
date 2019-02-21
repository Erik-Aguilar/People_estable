<?php
$user = Session::all();
?>

@extends($menu)

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tickets sistema</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(['action' => 'TicketController@SistemaGuardaTicket',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=>'formulario'
                            ]) }}

                <div class="panel panel-default">
                    <div class="panel-body">
                        <!--<div class="form-group">
                            <div class="col-sm-30">
                                {{ Form::label('Datos del Solicitante','',array('class'=>"col-sm-2 control-label")) }}
                            </div>
                        </div>-->

                        <table border="0">
                            <thead>
                                <tr>
                            <div class="form-group">
                                <div class="col-sm-30">
                                    {{ Form::label('Datos del Solicitante','',array('class'=>"col-sm-2 control-label")) }}
                                </div>
                            </div>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ Form::label('Nombre: ','',array('class'=>"col-sm-2 control-label")) }}</td>
                                    <td>{{ Form::label($valores[0]->nombre_completo,'',array('class'=>"col-sm-10 control-label")) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('N° de empleado: ','',array('class'=>"col-sm-2 control-label")) }}</td>
                                    <td>{{ Form::label($valores[0]->quien_solicita,'',array('class'=>"col-sm-8 control-label")) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('Area: ','',array('class'=>"col-sm-2 control-label")) }}</td>
                                    <td>{{ Form::label($valores[0]->area,'',array('class'=>"col-sm-8 control-label")) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('Puesto: ','',array('class'=>"col-sm-2 control-label")) }}</td>
                                    <td>{{ Form::label($valores[0]->puesto,'',array('class'=>"col-sm-8 control-label")) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('Campaña: ','',array('class'=>"col-sm-2 control-label")) }}</td>
                                    <td>{{ Form::label($valores[0]->campaign,'',array('class'=>"col-sm-8 control-label")) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <!--<div class="form-group">
                            <div class="col-sm-30">
                                {{ Form::label('Datos del Solicitante','',array('class'=>"col-sm-2 control-label")) }}
                            </div>
                        </div>-->

                        <table border="0">
                            <thead>
                                <tr>
                            <div class="form-group">
                                <div class="col-sm-30">
                                    {{ Form::label('Solicitud','',array('class'=>"col-sm-2 control-label")) }}
                                </div>
                            </div>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ Form::label('titulo: ','',array('class'=>"col-sm-2 control-label")) }}</td>
                                    <td>{{ Form::label($valores[0]->titulo,'',array('class'=>"col-sm-10 control-label")) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('Divicion: ','',array('class'=>"col-sm-2 control-label")) }}</td>
                                    <td>{{ Form::label($valores[0]->divicion,'',array('class'=>"col-sm-8 control-label")) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('Descripcion: ','',array('class'=>"col-sm-2 control-label")) }}</td>
                                    <td>{{ Form::label($valores[0]->descripcion,'',array('class'=>"col-sm-8 control-label")) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('Fecha/hora: ','',array('class'=>"col-sm-2 control-label")) }}</td>
                                    <td>{{ Form::label($valores[0]->hora_envio,'',array('class'=>"col-sm-8 control-label")) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                                <div class="col-sm-30">
                                    {{ Form::label('Datos internos','',array('class'=>"col-sm-2 control-label")) }}
                                </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('N° de solicitud: ','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::text('id',$valores[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",,'readonly'=>'readonly')) }}
                            </div>
                        </div>
                                
                        <div class="form-group">
                            {{ Form::label('Asignar','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::select('asignado', [
                                    '' => '',
                                    'Erik Aguilar' => 'Erik Aguilar',
                                    'Eymmy Castro' => 'Eymmy Castro',
                                    'Salomon Diaz' => 'Salomon Diaz'],
                                    '', ['class'=>"form-control", 'placeholder'=>""]  ) }}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('Estatus','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::select('estatus', [
                                    '' => '',
                                    'Enviado' => 'Enviado',
                                    'En_desarollo' => 'En desarrollo',
                                    'Pendiente' => 'Pendiente',
                                    'Finalizado' => 'Finalizado'],
                                    $valores[0]->estatus, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('Tiempo estimado *','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::text('tiempo_estimado','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('Comentarios tecnico ','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::textarea('comen_tecnico','',array('class'=>"form-control", 'placeholder'=>"")) }}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('Comentarios a solicitante ','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::textarea('comen_solicita','',array('class'=>"form-control", 'placeholder'=>"")) }}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('BoVo','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::select('divicion', [
                                    'No' => 'No',
                                    'Si' => 'Si'],
                                    '', ['class'=>"form-control", 'placeholder'=>""]  ) }}
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>

@stop
