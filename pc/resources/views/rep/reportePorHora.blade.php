@extends('layout.soporte.basic')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Reportes por 15 Minutos </h3>
            </div>
            <div class="panel-body">
                {{ Form::open(['action' => 'ReportesController@archivos',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}
                <div class="form-group">
                    {{ Form::label('Subir Archivos','',array('class'=>"col-sm-2 control-label")) }}

                    <div class="form-group" style="display: none">
                        <div class="col-sm-10">
                             {{ Form::text('valida','x',array('class'=>"form-control")) }}
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        {{ Form::submit('Subir Archivos',['class'=>"btn btn-default"]) }}
                    </div>
                </div>
                {{ Form::close() }}
                

                <div>
                    {{ Form::open(['action' => 'ReportesController@archivos',
                            'method' => 'post',
                            'class'=>"form-horizontal",
                            'accept-charset'=>"UTF-8",
                            'enctype'=>"multipart/form-data"
                        ]) }}
                    <div class="form-group">
                        {{ Form::label('Ejecuta Stgreportesmov','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="form-group" style="display: none">
                            <div class="col-sm-10">
                                 {{ Form::text('valida','stgbo',array('class'=>"form-control")) }}
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            {{ Form::submit('Ejecutar',['class'=>"btn btn-default"]) }}
                        </div>
                    </div>
                    {{ Form::close() }}     
                </div>

                 <div>
                    {{ Form::open(['action' => 'ReportesController@archivos',
                            'method' => 'post',
                            'class'=>"form-horizontal",
                            'accept-charset'=>"UTF-8",
                            'enctype'=>"multipart/form-data"
                        ]) }}
                    <div class="form-group">
                        {{ Form::label('Ejecuta Stgreportesmov','',array('class'=>"col-sm-2 control-label"))}}
                        <div class="form-group" style="display: none">
                            Form::date('name');
                            <div class="col-sm-10">
                                 {{ Form::text('valida','stgbo',array('class'=>"form-control")) }}
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            {{ Form::submit('Ejecutar',['class'=>"btn btn-default"]) }}
                        </div>
                    </div>
                    {{ Form::close() }}     
                </div>






















            </div>
        </div>
    </div>
</div>

@stop
