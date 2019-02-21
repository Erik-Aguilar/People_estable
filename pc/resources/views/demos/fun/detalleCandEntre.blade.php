@extends('layout.demos.reporte')
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Referencias Repetidas</h3>
            </div>
            <div class="panel-body">

              {{ Form::open(['action' => 'DemosController@UpCandEntre',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data"
                          ]) }}

              <div class="row">
                <div class="form-group col-md-3">
                  {{ Form::label('id', 'Id') }}
                  {{ Form::text('id',$detalle[0]->id, array('class' => 'form-control', 'readonly'=>'readonly')) }}
                </div>
                <div class="form-group col-md-3">
                  {{ Form::label('nombre_completo', 'Nombre completo') }}
                  {{ Form::text('nombre_completo', $detalle[0]->nombre_completo, array('class' => 'form-control', 'readonly'=>'readonly')) }}
                </div>
                <div class="form-group col-md-3">
                  {{ Form::label('new_fecha', 'Nueva fecha de entrevista') }}
                  {{ Form::date('new_fecha', $detalle[0]->fecha, array('class' => 'form-control')) }}
                </div>
                <div class="form-group col-md-3">
                  {{ Form::label('new_hora', 'Nueva hora de entrevista') }}
                  {{ Form::time('new_hora', $detalle[0]->hora, array('class' => 'form-control')) }}
                </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-5 col-sm-10">
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
