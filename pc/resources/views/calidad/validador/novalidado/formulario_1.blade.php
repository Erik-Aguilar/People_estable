@extends('layout.calidad.prepago.prepago')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'CalidadPreController@Auditados',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name' => "formulario"
                            ]) }}

                <div class="row">
                    <div class="col-md-10 col-md-push-2">
                        <h3>
                            DN: {{ $dn  }}
                        </h3>
                </div>
                </div>
                <div class="form-group" style="display: none;">
                    {{ Form::label('DN','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('dn',$dn,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Validador *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-3">
                      {{ Form::select('validador',$validadores,
                      null, ['id'=>'val','class'=>"form-control", 'placeholder'=>"Validadores",'onChange'=>'vali()']  ) }}
                    </div>
                    <div class="col-sm-3">
                      {{ Form::select('validador',$supervisor,
                      null, ['id'=>'sup','class'=>"form-control", 'placeholder'=>"Supervisores",'onChange'=>'supe()']  ) }}
                    </div>
                    <div class="col-sm-3">
                      {{ Form::select('validador',$analista,
                      null, ['id'=>'cal','class'=>"form-control", 'placeholder'=>"Analista de Calidad",'onChange'=>'cali()']  ) }}
                    </div>
                    <div class="col-sm-3" style="display: none;">
                      {{ Form::text('validador_f',null,array('id'=>'val_f','class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Imputable al validador*','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('imputable', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
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
                    {{ Form::label('Presentacion','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('presentacion', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Aviso de Privacidad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('aviso', [
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
                    {{ Form::label('Captura de datos','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('captura', [
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
                    {{ Form::label('Error Critico','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('error', [
                      'No'=>'No',
                      'No Tipificar' => 'No Tipificar',
                      'NIP para cancelacion' => 'NIP para cancelacion',
                      'Informacion Falsa'=>'Informacion Falsa',
                      'No Solicitar Referencia'=>'No Solicitar Referencia'
                      ],
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
                    <div class="col-sm-offset-2 col-sm-10">
                        {{ Form::submit('Enviar',['class'=>"btn btn-default",'onClick'=>'return confirm()']) }}
                    </div>
                </div>
                {{ Form::close() }}
@stop
@section('content2')
  <script>
    function confirm(){
      if($('#val').val()=='' && $('#sup').val()=='' && $('#cal').val()=='')
      {
        alert("Es obligatorio seleccionar un validador");
        return false;
      }
    }
    function vali() {
      if($('#val').val()!=''){
        $('#sup').val("");
        $('#cal').val("");
        $('#val_f').val($('#val').val());
      }
    }
    function supe() {
      if($('#sup').val()!=''){
        $('#val').val("");
        $('#cal').val("");
        $('#val_f').val($('#sup').val());
      }
    }
    function cali() {
      if($('#cal').val()!=''){
        $('#sup').val("");
        $('#val').val("");
        $('#val_f').val($('#cal').val());
      }
    }
  </script>
@stop
