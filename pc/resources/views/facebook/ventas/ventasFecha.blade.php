@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reportes Facebook</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'FaceBookVentasController@UpdateDatosVentasFechas',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="form-group">
                    {{ Form::label('Fecha','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Estatus','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('estatus', [
                      'Buzón'=>'Buzón',
                      'Gestionado por otro call-center' => 'Gestionado por otro call-center',
                      'Movistar' => 'Movistar',
                      'Numero incorrecto' => 'Numero incorrecto',
                      'Reagendar' => 'Reagendar',
                      'Plan' => 'Plan',
                      'Ok' => 'Ok',
                      'No ok' => 'No ok'],null, ['class'=>"form-control", 'placeholder'=>""]  ) }}
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
