@extends('layout.capacitador.admin')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Incidencias</h3>
      </div>
      <div class="panel-body">

        {{ Form::open(['action' => 'IncidenciaController@NuevaIncidencia',
                        'method' => 'post',
                        'class'=>"form-horizontal",
                        'accept-charset'=>"UTF-8",
                        'enctype'=>"multipart/form-data"
                    ]) }}




        <div class="form-group">
            {{ Form::label('Numero empleado *','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
                {{ Form::text('empleado','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"" ,'maxlength' => 10)) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('Nombre *','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
                {{ Form::text('nombre_completo','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('Fecha *','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
                {{ Form::date('fecha_1','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
            </div>
        </div>
        <div class="form-group">
                    {{ Form::label('al','',array('class'=>"col-sm-2 control-label")) }}
        </div>
        <div class="form-group">
            {{ Form::label('Fecha *','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
                {{ Form::date('fecha_2','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('Observaciones *','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
                {{ Form::textarea('observaciones','',array('class'=>"form-control", 'placeholder'=>"")) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('Comprobante *','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
                {{ Form::file('foto',[ 'class'=>"form-control", 'placeholder'=>""] ) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {{ Form::submit('Enviar',['class'=>"btn btn-primary"]) }}
            </div>
        </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
@stop
