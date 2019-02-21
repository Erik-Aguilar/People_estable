@extends('layout.demos.reporte')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Módulo de incidencias</h3>
            </div>
            <div class="panel-body">
              {{ Form::open(['action' => 'ReportesController@ReporteIncidencia',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data"
                          ]) }}
                <div class="form-group">
                  {{ Form::label('No. empleado *','',array('class'=>"col-sm-2 control-label")) }}
                  <div class="col-sm-10">
                    {{ Form::text('no_emp',NULL,array('class'=>"form-control", 'placeholder'=>"",'id'=>'no_emp','maxlength'=>'10','required')) }}
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
