@extends('layout.Incidencias.incidencias')
@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
          <h3 class="panel-title">Incidencias </h3>
      </div>
      <div class="panel-body">
        {{ Form::open(['action' => 'IncidenciasController@GuardaDatosAgente',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}
        <div class="form-group">
          {{ Form::label('No. empleado','',array('class'=>"col-sm-2 control-label")) }}
          <div class="col-sm-10">
            {{ Form::text('no_emp',$datos[0]->id,array('class'=>"form-control", 'placeholder'=>"",'id'=>'no_emp','maxlength'=>'10', 'readonly' => 'true')) }}
          </div>
        </div>

        <div class="form-group">
          {{ Form::label('Nombre','',array('class'=>"col-sm-2 control-label")) }}
          <div class="col-sm-10">
            {{ Form::text('nombre',$datos[0]->nombre_completo,array('class'=>"form-control", 'placeholder'=>"",'id'=>'no_emp', 'readonly' => 'true')) }}
          </div>
        </div>

        <div class="form-group">
            {{ Form::label('Motivo *','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
              {{ Form::select('motivo', [
              'Vacaciones' => 'Vacaciones',
              'Enfermedad' => 'Enfermedad',
              'Personal' => 'Personal',
              'Permiso' => 'Permiso',
              'DefuncionDirecta' => 'Defuncion pariente directo',
              'DefuncionIndirecta' => 'Defuncion pariente indirecto',
              'Tramites' => 'Tramites',
              'Retardo' => 'Retardo',
              'Otro'=>'Otro'],'', ['id'=>'area','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
            </div>
        </div>



        <div class="form-group">
            {{ Form::label('Fecha Inicio *','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
                {{ Form::date('fecha_i','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('Fecha Fin *','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
                {{ Form::date('fecha_f','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('Observaciones','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
                {{ Form::textarea('notes', null, ['rows'=>"2" ,'cols'=>"80"]) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('Comprobante','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
                {{ Form::file('thefile', ['class' => 'field']) }}
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
</div>
@stop
