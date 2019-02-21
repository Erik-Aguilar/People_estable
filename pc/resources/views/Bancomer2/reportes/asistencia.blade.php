@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Asistencia Bancomer</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'Bancomer2Controller@AsistenciaDatos',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="form-group">
                    {{ Form::label('Fecha Inicio','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha_i','',array('required' => 'required', 'class'=>"form-control")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Fecha Fin','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha_f','',array('required' => 'required', 'class'=>"form-control")) }}
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
