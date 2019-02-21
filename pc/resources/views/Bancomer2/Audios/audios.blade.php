@extends('layout.Banamex.coordinador.coordinador')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Audios</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(['action' => 'Bancomer2Controller@VerAudios',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=> "formulario"
                            ]) }}
                            <div class="form-group">
                              {{ Form::label('Campaña ','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-10">
                                  {{ Form::select('campania', [
                                    'Bancomer1' =>'Bancomer', 
                                    'Bancomer2' => 'Bancomer 2',
                                    'Banamex' => 'Banamex'],null,['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('Fecha','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-10">
                                    {{ Form::date('fecha','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                                </div>
                            </div>

                     </div>
                     </div>
                      {{ Form::close() }}
                     </div>
                     </div>
                     </div>

@stop
