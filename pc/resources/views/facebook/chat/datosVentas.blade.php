@extends('layout.tmpre.basic')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Datos Ventas Facebook Chat </h3>
            </div>
            <div class="panel-body">

                 {{ Form::open(['action' => 'FaceBookVentasController@guardaCambiosChat',
                        'method' => 'post',
                        'class'=>"form-horizontal",
                        'accept-charset'=>"UTF-8",
                        'enctype'=>"multipart/form-data"
                    ]) }}
          <fieldset>
            <legend>FaceBook Chat</legend>
            
            <div class="form-group" id="phonediv">
              <label for="" class="col-lg-2 control-label">Teléfono</label>
              <div class="col-lg-7">
                <input type="text" class="form-control" name="telefono" id="telefono" value="{{ $datos[0]->dn }}" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Estatus Chat:</label>
              <div class="col-lg-7">
                {{ Form::text('estatusChat', $datos[0]->estatus_chat_res, [ 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'']  ) }}
              </div>
            </div>


            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Nombre Usuario FB:</label>
              <div class="col-lg-7">
                        {{ Form::text('nombreUsuario', $datos[0]->usuariochat, [ 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'']  ) }}
              </div>
            </div>

            @if($datos[0]->estatus_chat_res == 'Reagenda')
              <div class="form-group">
                <label for="select" class="col-lg-2 control-label">Fecha Agenda</label>
                <div class="col-lg-7">
                          {{ Form::date('fechaAgenda', $datos[0]->fecha_agenda, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                </div>
              </div>

              <div class="form-group">
                <label for="select" class="col-lg-2 control-label">Hora Agenda</label>
                <div class="col-lg-7">
                  {{ Form::time('horaAgenda', $datos[0]->hora_agenda, ['class'=>"form-control", 'placeholder'=>""] )}}
                </div>
              </div>
            @endif

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Tel Contacto</label>
              <div class="col-lg-7">
                {{ Form::text('telContacto',$datos[0]->tel_contacto,array('class'=>"form-control",'maxlength'=>'10','minlength'=>'10')) }}
              </div>
            </div>


            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Observaciones:</label>
              <div class="col-lg-7">
                        {{ Form::textarea('observaciones', $datos[0]->observaciones, [ 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'']  ) }}
              </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Estatus Chat Operador:</label>
              <div class="col-lg-7">
                        {{ Form::select('estatus', [
                          'Menor de Edad' => 'Menor de Edad',
                          'CAC Lejano' => 'CAC Lejano',
                          'Fuera de Servicio' => 'Fuera de Servicio',
                          'Restringido' => 'Restringido',
                          'Plan de Renta' => 'Plan de Renta', 
                          'No Contesta' => 'No Contesta', 
                          'Venta' => 'Venta'
                        ],
                    $datos[0]->estatus_operador, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'sup']  ) }}
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

@stop
