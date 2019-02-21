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
                        <div class="form-group">
                            <h3 class="panel-title">
                                {{ Form::label('',$user['nombre_completo'],array('class'=>"col-sm-2 control-label")) }}
                            </h3>

                            <h5 class="panel-title">
                                {{ Form::label('',$user['user'],array('class'=>"col-sm-2 control-label")) }}
                            </h5>

                            <h5 class="panel-title">
                                {{ Form::label('',$user['area'],array('class'=>"col-sm-2 control-label")) }}
                            </h5>
                            <h5 class="panel-title">
                                {{ Form::label('',$user['puesto'],array('class'=>"col-sm-2 control-label")) }}
                            </h5>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-sm-30">
                                {{ Form::label('Datos de la petición','',array('class'=>"col-sm-2 control-label")) }}
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('Titulo *','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::text('titulo',$valores[0]->titulo,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'disabled' => 'disabled')) }}
                            </div>
                        </div>
                        <?php
                        echo "<br>";
                        echo "<br>";
                        ?>
                        <div class="form-group">
                            {{ Form::label('Área','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::select('divicion', [
                            'Sistemas' => 'Sistemas',
                            'Soporte' => 'Soporte'],
                        $valores[0]->divicion, ['class'=>"form-control", 'placeholder'=>"",'disabled' => 'disabled']  ) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Descripción *','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::textarea('descripcion',$valores[0]->descripcion,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'disabled' => 'disabled')) }}
                            </div>
                        </div>

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
                    <div class="panel-body">
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
