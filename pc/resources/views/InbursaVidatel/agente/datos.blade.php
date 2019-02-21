@extends('layout.InbursaVidatel.agente.agente')
@section('content')

<?php
$value = Session::all();
// dd($value);


$hora=date('H:i:s');
?>



<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-body">
              {{ Form::open(['action' => 'InbursaSolucionesController@FromularioInbSoluciones',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario",
                              'onsubmit'=>'return validar()'
                                ]) }}


                                <div class="form-group">
                                    {{ Form::label('Telefono','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('telefono',$datos[0]->telefono,array('class'=>"form-control")) }}
                                    </div>
                                </div>


                                <div class="form-group">
                                    {{ Form::label('Nombre','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('telefono',$datos[0]->nombre,array('class'=>"form-control")) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('apellidos','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('telefono',$datos[0]->apellidos,array('class'=>"form-control")) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                   {{ Form::label('RFC','',array('class'=>"col-sm-3 control-label")) }}
                                   <div class="col-sm-8">
                                       {{ Form::text('telefono',$datos[0]->rfc,array('class'=>"form-control")) }}
                                   </div>
                               </div>

                               <div class="form-group">
                                  {{ Form::label('Numero de casa','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::text('telefono',$datos[0]->numcasa,array('class'=>"form-control")) }}
                                  </div>
                              </div>


                                 <div class="form-group">
                                    {{ Form::label('Calle','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('telefono',$datos[0]->calle,array('class'=>"form-control")) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('ciudad','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('telefono',$datos[0]->ciudad,array('class'=>"form-control")) }}
                                    </div>
                                </div>


                                <div class="form-group">
                                    {{ Form::label('Colonia','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('telefono',$datos[0]->colonia,array('class'=>"form-control")) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('CP','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('telefono',$datos[0]->cp,array('class'=>"form-control")) }}
                                    </div>
                                </div>

               {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('/assets/js/jquery-3_2_1.min.js')}}" ></script>
<script type="text/javascript">

@stop
