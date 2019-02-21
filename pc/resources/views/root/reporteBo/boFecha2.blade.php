@extends($menu)
@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte Marcacion / Ventas</h3>
            </div>
            <div class="panel-body">

              {{ Form::open(['action' => 'BoController@BoMarcacionDatos2',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data"
                          ]) }}


                <div class="form-group">
                    {{ Form::label('Fecha Venta Inicio','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha_i','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Fecha Venta Fin','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha_f','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Area','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('proceso', [
                      'P1' => 'Proceso 1'],
                      '', ['id'=>'area','required' => 'required', 'class'=>"form-control", 'placeholder'=>"", "onchange"=>"LlenarSelect(),validacion()"]  ) }}
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
