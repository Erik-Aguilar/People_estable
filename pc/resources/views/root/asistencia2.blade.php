@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Asistencia</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'RootController@ReporteAsistencia',
                                'method' => 'post',
                                'class'=>"form-horizontal"
                            ]) }}

                <div class="form-group">
                    {{ Form::label('Fecha inicio *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('inicio','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Fecha fin *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fin','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

@if(session('puesto') === 'Jefe de BO')
<div class="form-group">
    {{ Form::label('Area','',array('class'=>"col-sm-2 control-label")) }}
    <div class="col-sm-10">
        {{ Form::select('area', [
      'Back-Office' => 'Back-Office',
      'Validación' => 'Validación'],
      'Back-Office', ['class'=>"form-control", 'placeholder'=>"", "onchange"=>"LlenarSelect()",'readonly'=>'readonly']  ) }}
    </div>
</div>
@elseif(session('puesto') === 'Coordinador de Capacitacion')

@else
<div class="form-group">
    {{ Form::label('Area','',array('class'=>"col-sm-2 control-label")) }}
    <div class="col-sm-10">
        {{ Form::select('area', [
      'Operaciones' => 'Operaciones',
      'Validación' => 'Validación',
      'Calidad' => 'Calidad',
      'Back-Office' => 'Back-Office',
      'Reclutamiento' => 'Reclutamiento',
      'Sistemas' => 'Sistemas',
      'Administración' => 'Administración',
      'Edición' => 'Edición',
      'Capacitación' => 'Capacitación',
      'Direccion General'=>'Direccion General'],
      null, ['class'=>"form-control", 'placeholder'=>"", "onchange"=>"LlenarSelect()"]  ) }}
    </div>
</div>
@endif


@if(session('puesto') === 'Jefe de BO')
<div class="form-group">
    {{ Form::label('Campaña','',array('class'=>"col-sm-2 control-label")) }}
    <div class="col-sm-10">
        {{ Form::select('campaign', [
        'TM Prepago' => 'TM Prepago'],
    'TM Prepago', ['class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly']  ) }}
    </div>
</div>
@elseif(session('puesto') === 'Coordinador de Capacitacion')

@else
<div class="form-group">
    {{ Form::label('Campaña','',array('class'=>"col-sm-2 control-label")) }}
    <div class="col-sm-10">
        {{ Form::select('campaign', [
        'TM Prepago' => 'TM Prepago',
        'TM Pospago'=>'TM Pospago',
        'Inbursa' => 'Inbursa',
        'PeopleConnect' => 'PeopleConnect',
        'PyMES' => 'PyMES',
        'Facebook'=>'Facebook',
        'Mapfre'=>'Mapfre',
        'Bancomer'=>'Bancomer',
        'Banamex'=>'Banamex'],
    null, ['class'=>"form-control", 'placeholder'=>""]  ) }}
    </div>
</div>
@endif

@if(session('puesto') === 'Jefe de BO')
<div class="form-group">
    {{ Form::label('Turno','',array('class'=>"col-sm-2 control-label")) }}
    <div class="col-sm-10">
        {{ Form::select('turno', [],
    '', ['class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly']  ) }}
    </div>
</div>
@elseif(session('puesto') === 'Coordinador de Capacitacion')

@else
<div class="form-group">
    {{ Form::label('Turno','',array('class'=>"col-sm-2 control-label")) }}
    <div class="col-sm-10">
        {{ Form::select('turno', [
        'Matutino' => 'Matutino',
        'Vespertino' => 'Vespertino',
        'Turno Completo (M)' => 'Turno Completo (M)',
        'Turno Completo (V)' => 'Turno Completo (V)',
        'Doble Turno'=>'Doble Turno'],
    null, ['class'=>"form-control", 'placeholder'=>""]  ) }}
    </div>
</div>
@endif


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
