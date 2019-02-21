@extends('layout.tmpre.chatSuper')
@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="panel panel-default col-md-8 col-md-offset-2">
      <div class="panel-body">

        {{ Form::open(['action' => 'FaceBookVentasController@GuardaVentasChat',
                        'method' => 'post',
                        'class'=>"form-horizontal",
                        'accept-charset'=>"UTF-8",
                        'id'=>'myform',
                        'enctype'=>"multipart/form-data"
                    ]) }}
          <fieldset>
            <legend>FaceBook Chat</legend>
             
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Nombre Usuario FB:</label>
              <div class="col-lg-7">
                        {{ Form::text('nombreUsuario', '', [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'sup', 'required'=>"required"]  ) }}
              </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Nombre Cliente</label>
              <div class="col-lg-7">
                        {{ Form::text('nombreCliente', '', [ 'class'=>"form-control", 'placeholder'=>""]  ) }}
              </div>
            </div>

            
            <div class="form-group" id="phonediv">
              <label for="" class="col-lg-2 control-label">Teléfono</label>
              <div class="col-lg-7">
                <input type="text" maxlength="10" class="form-control" name="telefono" id="telefono" placeholder="5512345678">
              </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Asignar a:</label>
              <div class="col-lg-7">
                        {{ Form::select('agente', $agentes, null, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'sup']  ) }}
              </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Estatus Chat:</label>
              <div class="col-lg-7">
                        {{ Form::select('estatus', [
                          'Reagenda' => 'Reagenda',
                        ],
                    '', [ 'class'=>"form-control", 'placeholder'=>""]  ) }}
              </div>
            </div>

            <div class="form-group">
                {{ Form::label('Tel Contacto','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-7">
                    {{ Form::text('telefonoContacto','',array('class'=>"form-control",'id'=>'telefono','maxlength'=>'10','minlength'=>'10')) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('Fecha Agenda','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-7">
                    {{ Form::date('fechaAgenda','',array('class'=>"form-control", 'placeholder'=>"********")) }}
                </div>
            </div>

            <div class="form-group">
              {{ Form::label('Hora Agenda','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-7">
                    {{ Form::time('horaAgenda','',array('class'=>"form-control", 'placeholder'=>"********")) }}
                </div>
            </div>

            <div class="form-group">
              {{ Form::label('Anuncio','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-7">
                    {{ Form::select('anuncio',$anuncios, null,['class'=>"form-control", 'placeholder'=>""]) }}
                </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Observaciones:</label>
              <div class="col-lg-7">
                        {{ Form::textarea('observaciones', '', [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'sup']  ) }}
              </div>
            </div>

            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" id="subguardar" class="btn btn-primary" >Guardar</button>
              </div>
            </div>
          </fieldset>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

<style media="screen">
  .close{
    margin-right: 5%;
  }
</style>


@endsection
@section('content2')

@endsection
