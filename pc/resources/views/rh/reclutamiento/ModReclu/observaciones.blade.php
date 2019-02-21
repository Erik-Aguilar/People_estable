@extends('layout.capacitador.admin')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Capacitacion | {{$candidato[0]->nombre_completo}}</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'CapacitadorController@updateObservaciones',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="form-group" style='display:none;'>
                    {{ Form::label($candidato[0]->nombre_completo,'',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('id',$candidato[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                    </div>
                </div>
                 <div class="form-group" style='display:none;'>
                    {{ Form::label('Fecha de capacitacion','',array('class'=>"col-sm-2 control-label",)) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha',$candidato[0]->fecha_capacitacion,array('required' => 'required', 'class'=>"form-control Fase2", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Dia 1','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('primerDia', [
                        'Falta' => 'Falta',
                        'VoBo' => 'VoBo',
                        'No VoBo' => 'No VoBo'],
                    $candidatoVal->primerDia, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""] ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Dia 2','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('segundoDia', [
                        'Falta' => 'Falta',
                        '0' => '0',
                        '1' => '1',
                        '2'=>'2',
                        '3'=>'3',
                        '4'=>'4',
                        '5'=>'5'],
                    $candidatoVal->segundoDia, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""] ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Observaciones','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::textarea('observaciones',$candidatoVal->observaciones,['class'=>'form-control'])}}
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
