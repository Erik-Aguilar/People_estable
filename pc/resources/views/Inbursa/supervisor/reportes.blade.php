@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reportes</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'InbursaController@tipoReporte',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}
                <div class="form-group">
                    {{ Form::label('Reporte','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('reporte', [
                        'Bajas completo' => 'Bajas completo',
                        'Ventas por día' => 'Ventas por día',
                        'Ventas completo' => 'Ventas completo',
                        'Pase de asistencia'=>'Pase de asistencia',
                        'ReporteVentas'=>'Reporte de Ventas'],
                    '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
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
