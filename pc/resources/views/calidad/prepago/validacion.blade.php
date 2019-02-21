@extends('layout.calidad.prepago.prepago')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'CalidadPreController@Validacion',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name' => "formulario"
                            ]) }}

                <div class="row">
                    <div class="col-md-10 col-md-push-2">
                        <h3>
                            {{ $user[0]->nombre_completo  }}
                        </h3>
                        <div class="form-group" style='display: none;'>

                            <div class="col-sm-10">
                                {{ Form::text('id',$user[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group" style='display: none;'>
                            <div class="col-sm-10">
                                 {{ Form::date('date',$date,array('class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group" style='display: none;'>
                            <div class="col-sm-10">
                                 {{ Form::date('end_date',$end_date,array('class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('DN','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('dn',null,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Fecha de validacion','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                         {{ Form::date('fechaValidacion','',array('required' => 'required','class'=>"form-control", 'placeholder'=>"********")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Fecha de monitoreo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                         {{ Form::date('fechaMon',date('Y-m-d'),array('required' => 'required','class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Validacion Exitosa','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('validacionExitosa', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Saludo/Motivo ','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('saludo', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Manejo de objeciones','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('objeciones', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Validacion de datos generales','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('datosGenerales', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Escucha Activa','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('escucha', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Aviso de privacidad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('privacidad', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Manejo de llamada','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('llamada', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Error Critico','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('error', [
                      '0' => 'Si',
                      '1' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Observaciones','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('observaciones',null,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Dictamen','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('dictamen', [
                      'Operador' => 'operador',
                      'Validado' => 'Validado',
                      'Operador y Validador'=>'Operador y Validador',
                      'Cliente'=>'Cliente'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                    </div>
                </div>
                {{ Form::close() }}


@stop
