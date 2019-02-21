@extends('layout.soporte.basic')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Subir Reporte Blaster </h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'ReportesController@subeBlaster',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="form-group">
                    {{ Form::label('Reporte','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::file('archivo') }}
                    </div>
                </div>
                

                <div class="form-group">
                    {{ Form::label('No. de Reporte','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('tipo', [
                        'b1'=>'Reporte de Blaster 1',
                        'b3'=>'Reporte de Blaster 3',
                        'b4'=>'Reporte de Blaster 4'],
                    '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>

@stop