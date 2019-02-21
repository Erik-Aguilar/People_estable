@extends('layout.edicion.edicion')
@section('content')


<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Cambiar Editores Campaña</h3>
            </div>
            <div class="panel-body">

              {{ Form::open(['action' => 'EdicionController@UpFormEdit',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data"
                          ]) }}

                          <div class="form-group">
                              {{ Form::label('ID','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-8">
                                      {{ Form::text('id',$detalle[0]->id, array('class' => 'form-control', 'readonly'=>'readonly')) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Nombre','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-8">
                                      {{ Form::text('nombre_completo',$detalle[0]->nombre_completo, array('class' => 'form-control', 'readonly'=>'readonly')) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Campaña','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-8">
                                  {{ Form::select('campaign', [
                                  'Inbursa' => 'Inbursa',
                                  'Mapfre'=>'Mapfre'],
                              $detalle[0]->campaign, ['class'=>"form-control", 'placeholder'=>"",'id'=>'campaign','onChange'=>'validacion(),ACalidad()']  ) }}
                              </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12 col-md-offset-5">
                              {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                            </div>
                          </div>

            {{ Form::close() }}


            </div>
        </div>
    </div>
</div>



@stop
