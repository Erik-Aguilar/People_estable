@extends('layout.demos.reporte')
@section('content')
<style media="screen">


.margin {
  margin-top: 10px;
  margin-left: 10px;
  margin-right: 10px;
  overflow-x: scroll;
  overflow-y: visible;
  padding-bottom: 5px;
  font: sans-serif;
  text-align : justify;
}
</style>

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
          <h3 class="panel-title">SCRIPT Venta Prepago</h3>
      </div>
      <div class="panel-body">
        
                {{ Form::open(['action' => 'ReportesController@ReportePerInci',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="form-group">
                    {{ Form::label('Fecha Inicio','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha_i','2016-11-19',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Fecha Fin','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha_f','2016-11-19',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
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