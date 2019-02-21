@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reportes Rh</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'ReportesReclutamientoController@Reporte',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="form-group">
                    {{ Form::label('Fecha','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha_i','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Campaña','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('campaign', [
                        'TM Prepago' => 'TM Prepago',
                        'TM Pospago' => 'TM Pospago',
                        'Inbursa' => 'Inbursa',
                        'Mapfre'=>'Mapfre',
                        'Conaliteg'=>'Conaliteg',
                        'Banamex'=>'Banamex',
                        'Bancomer'=>'Bancomer',
                        'Auri'=>'Auri'
                        ],null, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Turno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('turno', [
                        'Matutino' => 'Matutino',
                        'Vespertino' => 'Vespertino'
                        ],null, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Tipo de reporte','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('tipo', [
                        'Capacitacion' => 'Capacitacion',
                        'Activos' => 'Activos'],null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
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
