@extends('layout.mapfre.agente')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Agente</h3>
            </div>


            <div class="panel-body">

                {{ Form::open(['action' => 'MapfreController@BuscarRegistro',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}



                <div class="form-group">
                    {{ Form::label('Póliza','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('poliza','',array('class'=>"form-control", 'placeholder'=>"")) }}
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
@section('content2')

@stop
