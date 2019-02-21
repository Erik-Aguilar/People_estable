@extends('layout.tmpre.chatSuper')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Revisar Ventas Facebook Chat </h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Cuenta</th>
                            <th>Anuncio</th>
                            <th>Costo</th>                            
                            <th>Activo</th>                            
                            <th>Enviar</th>
                        </tr>
                    </thead>
                        
                    @foreach($datos as $value)
                        <form method="post" action="{{ url('ingresarAnuncios2' ) }}">
                            <tbody>
                                <tr>
                                    <td style="display: none;">
                                        <div class="form-group">
                                            <div class="">
                                                {{ Form::text('id', $value->idanuncios_fb, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="">
                                                {{ Form::text('cuenta', $value->cuenta, ['class'=>"form-control", 'placeholder'=>"", "readonly"=>'readonly']  ) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="form-group">
                                            <div class="">
                                                {{ Form::text('anuncio', $value->anuncio, ['class'=>"form-control", 'placeholder'=>"", "readonly"=>'readonly']  ) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td> <div class="form-group">
                                        <div class="">
                                            {{ Form::text('costo', $value->costo, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                                        </div>
                                        </div>
                                    </td>
                                    <td> <div class="form-group">
                                        <div class="">
                                            {{ Form::text('Fecha', $value->created_at, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                                        </div>
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="form-group">
                                            <div class="">
                                                {{ Form::select('estatus', [
                                                    '0' => 'Inactivo', 
                                                    '1' => 'Activo'],
                                                $value->activo,['class'=>"form-control", 'placeholder'=>""]  ) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </form>
                    @endforeach
                </table>
            </div>
        </div>
    </div>








    <div class="panel panel-default col-md-8 col-md-offset-2">
      <div class="panel-body">

        {{ Form::open(['action' => 'FaceBookVentasController@InsertaAnuncio',
                        'method' => 'post',
                        'class'=>"form-horizontal",
                        'accept-charset'=>"UTF-8",
                        'id'=>'myform',
                        'enctype'=>"multipart/form-data"
                    ]) }}
          <fieldset>
            <legend>Ingresa Anuncios</legend>
             
     
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Cuenta:</label>
              <div class="col-lg-7">
                        {{ Form::select('cuenta', [
                          'Anna' => 'Anna',
                          'Enrique' => 'Enrique',
                          ],
                    '', [ 'class'=>"form-control", 'placeholder'=>"", "required"=>'required']  ) }}
              </div>
            </div>

            <div class="form-group">
                {{ Form::label('Anuncio','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-7">
                    {{ Form::text('anuncio','',array('class'=>"form-control", "required"=>'required')) }}
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

@stop
