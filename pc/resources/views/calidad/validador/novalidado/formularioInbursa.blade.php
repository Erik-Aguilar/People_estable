@extends('layout.calidad.prepago.prepago')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Inbursa</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'CalidadPreController@AuditadosInbursa',
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
                        @if(!$valida)
                      {{ Form::select('validador',$validadores,
                      null, ['id'=>'val','class'=>"form-control", 'placeholder'=>"Validadores",'onChange'=>'vali()']  ) }}
                      @else
                      {{ Form::select('validador',$validadores,
                      $valida[0]->validador, ['id'=>'val','class'=>"form-control", 'placeholder'=>"Validadores",'onChange'=>'vali()']  ) }}
                      @endif
                    </div>
                    <div class="col-sm-3">
                        @if(!$valida)
                      {{ Form::select('validador',$supervisor,
                      null, ['id'=>'sup','class'=>"form-control", 'placeholder'=>"Supervisores",'onChange'=>'supe()']  ) }}
                      @else
                      {{ Form::select('validador',$supervisor,
                      $valida[0]->validador, ['id'=>'sup','class'=>"form-control", 'placeholder'=>"Supervisores",'onChange'=>'supe()']  ) }}
                      @endif
                    </div>
                    <div class="col-sm-3">
                      @if(!$valida)
                        {{ Form::select('validador',$analista,
                      null, ['id'=>'cal','class'=>"form-control", 'placeholder'=>"Analista de Calidad",'onChange'=>'cali()']  ) }}
                      @else
                        {{ Form::select('validador',$analista,
                      $valida[0]->validador, ['id'=>'cal','class'=>"form-control", 'placeholder'=>"Analista de Calidad",'onChange'=>'cali()']  ) }}
                      @endif
                    </div>
                    <div class="col-sm-3" style="display: none;">
                      {{ Form::text('validador_f',null,array('id'=>'val_f','class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                            
                            
                <div class="form-group">
                    {{ Form::label('Imputable al validador*','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      @if(!$valida)  
                      {{ Form::select('imputable', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @else
                      {{ Form::select('imputable', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $valida[0]->imputable, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Fecha de validacion','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        @if(!$valida)
                         {{ Form::date('fechaValidacion','',array('required' => 'required','class'=>"form-control", 'placeholder'=>"********")) }}
                         @else
                         {{ Form::date('fechaValidacion',$valida[0]->fecha_val,array('required' => 'required','class'=>"form-control", 'placeholder'=>"********")) }}
                         @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Fecha de monitoreo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        @if(!$valida)
                         {{ Form::date('fechaMon',date('Y-m-d'),array('required' => 'required','class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly')) }}
                        @else
                         {{ Form::date('fechaMon',$valida[0]->fecha_monitoreo,array('required' => 'required','class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly')) }}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Presentacion','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      @if(!$valida)  
                      {{ Form::select('presentacion', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @else
                      {{ Form::select('presentacion', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $valida[0]->presentacion, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Aviso de Privacidad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        @if(!$valida)
                      {{ Form::select('aviso', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @else
                      {{ Form::select('aviso', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $valida[0]->aviso_priv, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Escucha Activa','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        @if(!$valida)
                      {{ Form::select('escucha', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @else
                      {{ Form::select('escucha', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $valida[0]->escucha_activa, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Captura de datos','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      @if(!$valida)  
                      {{ Form::select('captura', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @else
                      {{ Form::select('captura', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $valida[0]->captura, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Manejo de objeciones','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        @if(!$valida)
                      {{ Form::select('objeciones', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @else
                      {{ Form::select('objeciones', [
                      '1' => 'Si',
                      '0' => 'No'],
                      $valida[0]->manejo_objeciones, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Error Critico','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        @if(!$valida)
                      {{ Form::select('error', [
                      'No'=>'No',
                      'No Tipificar' => 'No Tipificar',
                      'NIP para cancelacion' => 'NIP para cancelacion',
                      'Informacion Falsa'=>'Informacion Falsa',
                      'No Solicitar Referencia'=>'No Solicitar Referencia'
                      ],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @else
                      {{ Form::select('error', [
                      'No'=>'No',
                      'No Tipificar' => 'No Tipificar',
                      'NIP para cancelacion' => 'NIP para cancelacion',
                      'Informacion Falsa'=>'Informacion Falsa',
                      'No Solicitar Referencia'=>'No Solicitar Referencia'
                      ],
                      $valida[0]->error_critico, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Observaciones','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        @if(!$valida)
                        {{ Form::text('observaciones',null,array('class'=>"form-control", 'placeholder'=>"")) }}
                        @else
                        {{ Form::text('observaciones',$valida[0]->comentarios,array('class'=>"form-control", 'placeholder'=>"")) }}
                        @endif
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
