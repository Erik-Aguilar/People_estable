@extends($menu)
@section('content')
<style media="screen">
  div{
    font-size: 12px;
  }
</style>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Banamex folio</h3>
            </div>
            <div class="panel-body">

              {{ Form::open(['action' => 'BanamexController@Actualiza',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario"
                          ]) }}
                          <!-- style="display:none" -->
                <div class="form-group"  align='Center'>
                    {{ Form::label('Folio','',array('class'=>"col-sm-5 control-label")) }}
                    <div class="col-sm-2">
                        {{ Form::text('folio','',array('id'=>'folio','class'=>"form-control", 'placeholder'=>"",'required'=>'required')) }}
                    </div>
                    <div class="col-sm-1" >
                      {{ Form::submit('Buscar',['class'=>"btn btn-primary",'onClick'=>'return validaVenta()']) }}
                    </div>
                  </div>

                <div id="send">

                </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
@stop
@section('content2')

@stop
