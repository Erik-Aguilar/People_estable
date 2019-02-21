@extends('layout.capacitador.admin')
@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Numero de Empleado</h3>
      </div>
      <div class="panel-body">

        {{ Form::open(['action' => 'IncidenciaController@Incidencia',
                        'method' => 'post',
                        'class'=>"form-horizontal",
                        'accept-charset'=>"UTF-8",
                        'enctype'=>"multipart/form-data"
                    ]) }}

        <div class="form-group">
          {{ Form::label('Numero de Empleado','',array('class'=>"col-sm-4 control-label")) }}
          <div class="col-sm-8">
              {{ Form::text('empleado','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"Num empleado")) }}
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
