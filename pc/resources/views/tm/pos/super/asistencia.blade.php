@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Nuevo Empleado</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'SupervisorController@ReporteAsistenciapos',
                                'method' => 'post',
                                'class'=>"form-horizontal"
                            ]) }}

                <div class="form-group">
                    {{ Form::label('Fecha inicio *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('inicio','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Fecha fin *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fin','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
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
