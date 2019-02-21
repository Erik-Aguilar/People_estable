@extends('layout.bo.jefebo')
@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte Marcación BO</h3>

            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'BoController@repMarcacion',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="form-group">
                    {{ Form::label('Fecha','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha_i','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Proceso','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('proceso', [
                        'proceso1' => 'Proceso 1',
                        'proceso3'=>'Proceso 3'],
                    null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required']  ) }}
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
