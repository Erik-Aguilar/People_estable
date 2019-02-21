@extends('layout.rep.basic')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reportes</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'ReportesController@Reportetotal',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="form-group">
                    {{ Form::label('campaña','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('campaign', [
                        'Inbursa'=>'Inbursa',
                        'TM PRepago'=>'TM Prepago',
                        'PeopleConnect'=>'PeopleConnect',
                        'PyMES'=>'PyMES'],
                    '', ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Turno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('turno', [
                        'Matutino'=>'Matutino',
                        'Matutino Completo'=>'Matutino Completo',
                        'Vespertino'=>'Vespertino',
                        'Turno Completo'=>'Turno Completo'],
                    '', ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Supervisor','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('supervisor',$supervisor,
                    '', ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Estatus','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('estatus', [
                        '1'=>'Activo',
                        '0'=>'Inactivo'],
                    '', ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Tipo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('tipo', [
                        'descarga'=>'Descarga',
                        'vista'=>'Vista'],
                    '', ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  ) }}
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
