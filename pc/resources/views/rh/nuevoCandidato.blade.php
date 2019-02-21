@extends('layout.rh.admin')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Nuevo Candidato</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'RhController@NuevoCandidato',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="form-group">
                    {{ Form::label('Nombre *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Paterno *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('paterno','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Materno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('materno','',array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Teléfono','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('telefono','',array('class'=>"form-control", 'placeholder'=>"55345678")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Celular *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('celular','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"5512345678")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Fecha de nacimiento *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha_nacimiento','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Dirección *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::textarea('direccion','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('En caso de emergencia llamar a  *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('nom_emergencia1','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"Nombre del Contacto Emergencia 1")) }}
                        {{ Form::number('emergencia1','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"Telefono 1")) }}
                        {{ Form::text('nom_emergencia2','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"Nombre del Contacto Emergencia 2")) }}
                        {{ Form::number('emergencia2','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"Telefono 2")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Área *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('area', [
                        'TM Pospago' => 'TM Pospago',
                        'TM Prepago' => 'TM Prepago',
                        'RH' => 'RH',
                        'Calidad' => 'Calidad',
                        'Banamex' => 'Banamex',
                        'Bancomer'=>'Bancomer',
                        'Administración' => 'Administración'],
                    '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Puesto *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('puesto', [
                        'Operador Call Center' => 'Operador Call Center',
                        'Validador' => 'Validador',
                        'Analista'=>'Analista',
                        'Team Leader' => 'Team Leader',
                        'Reclutador' => 'Reclutador',
                        'Recepción' => 'Recepción'],
                    '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Turno *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('turno', [
                        'Matutino' => 'Matutino',
                        'Vespertino' => 'Vespertino',
                        'Matutino completo' => 'Matutino completo',
                        'Vespertino completo' => 'Vespertino completo'],
                    '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>
                
                <div class="form-group">
                    {{ Form::label('Tipo de contrato *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('tipo_contrato', [
                        'un_mes' => 'Un mes',
                        'dos_meses' => 'Dos meses',
                        'indefinido' => 'Indefinido'],
                    null, ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>
                           
                <div class="form-group">
                    {{ Form::label('Fotografía *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::file('foto',['required' => 'required', 'class'=>"form-control", 'placeholder'=>""] ) }}
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
