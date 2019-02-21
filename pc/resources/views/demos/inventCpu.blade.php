@extends('layout.demos.reporte')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Invetario CPU</h3>
            </div>
            <div class="panel-body">

              <div class="row">
                <div class="form-group col-md-3">
                  {{ Form::label('tipo', 'Tipo') }}
                  {{ Form::select('tipo', [
                  'PC' => 'PC',
                  'Servidor' => 'Servidor',
                  'Laptop' => 'Laptop'],
              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'()']  ) }}
                </div>
                <div class="form-group col-md-3">
                  {{ Form::label('marca', 'Marca') }}
                  {{ Form::select('marca', [
                  '' => '',
                  '' => '',
                  '' => '',
                  '' => '',
                  '' => ''],
              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'()']  ) }}
                </div>
                <div class="form-group col-md-3">
                  {{ Form::label('modelo', 'Modelo') }}
                  {{ Form::select('modelo', [
                  '' => '',
                  '' => '',
                  '' => '',
                  '' => '',
                  '' => ''],
              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'()']  ) }}
                </div>
                <div class="form-group col-md-3">
                  {{ Form::label('no_serie', 'Número de serie') }}
                  {{ Form::text('no_serie', null, array('placeholder' => 'Introduce el número de serie', 'class' => 'form-control')) }}
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-3">
                  {{ Form::label('procesador', 'Procesador') }}
                  {{ Form::select('procesador', [
                  '' => '',
                  '' => '',
                  '' => '',
                  '' => '',
                  '' => ''],
              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'()']  ) }}
                </div>
                <div class="form-group col-md-3">
                  {{ Form::label('memoria', 'Memoria') }}
                  {{ Form::select('memoria', [
                  '' => '',
                  '' => '',
                  '' => '',
                  '' => '',
                  '' => ''],
              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'()']  ) }}
                </div>
                <div class="form-group col-md-3">
                  {{ Form::label('ubicacion', 'Ubicación') }}
                  {{ Form::select('ubicacion', [
                  'Operación' => 'Operación',
                  'RRHH' => 'RRHH',
                  'Sistemas' => 'Sistemas',
                  'Dirección' => 'Dirección',
                  'Site' => 'Site',
                  'Site' => 'Site',
                  'Roma' => 'Roma',
                  'Trigo' => 'Trigo'],
              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'()']  ) }}
                </div>
                <div class="form-group col-md-3">
                  {{ Form::label('descripcion', 'Descripción') }}
                  {{ Form::textarea('notes', null, array('class'=>'form-control','size' => 'x1')) }}
                </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-5 col-sm-10">
                      {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                  </div>
              </div>

            </div>
        </div>
    </div>
</div>

@stop
