@extends('layout.rh.admin')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">
                {{ Form::open(['action' => 'RhController@verCandidato',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="row">
                    <div class="col-md-10 col-md-push-2">
                        <h3>
                            {{ $user[0]->nombre}} {{$user[0]->paterno  }} {{$user[0]->materno  }}
                        </h3>
                        <div class="form-group">
                            <div class="col-sm-10">
                                {{ Form::text('id',$user[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-pull-10">
                        <img src="{{asset('storage/1.jpg')}}" class="img-responsive" style="width: 150px; height: 120px;">
                    </div>
                </div>
                <br>
                <div class="form-group">
                    {{ Form::label('Fecha de reclutamiento *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('fcr',$user[0]->nombre,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Medio Uno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('medio1',$user[0]->paterno,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Medio Dos','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('medio2',$user[0]->materno,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                 <div class="form-group">
                    {{ Form::label('Medio Tres','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('medio3', [
                        'Matutino' => 'Matutino',
                        'Vespertino' => 'Vespertino',
                        'Turno Completo' => 'Turno Completo'],$user[0]->turno, ['class'=>"form-control", 'placeholder'=>""]  ) }}
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
