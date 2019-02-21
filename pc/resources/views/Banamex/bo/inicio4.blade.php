@extends('layout.Banamex.bo.bo')
@section('content')

<style>
    iframe{
        position:absolute;
        height: 255000%;
    }
</style>
@if($datos != 0)
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos de venta</h3>
                    </div>
                    <div class="panel-body">

                        {{ Form::open(['action' => 'BoBanamexController@GuardaDatos',
                                'method' => 'post',
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",

                        ]) }}
                        <div class="form-group">
                            {{ Form::label('Numero de venta','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('id',$datos[0]->v_id,array('class'=>"form-control", 'readonly'=>'readonly')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Nombre','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('nombre',$datos[0]->nombre,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Paterno','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('paterno',$datos[0]->paterno,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Materno','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('materno',$datos[0]->materno,array('class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            </div>
                        </div>


                        <br><br>

                        <div class="form-group">
                            {{ Form::label('Exitosa / No Exitosa','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::select('exito', [
                                    'Exitosa' => 'Exitosa',
                                    'NoExitosa'=>'No Exitosa'],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Exitosa()",'id'=>'ventaExitosa']  ) }}
                            </div>
                        </div>

                        <div class="form-group" style='display: none;' id='ventaAutenticada'>
                            {{ Form::label('Autenticada','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::select('autenticada', [
                                    'Autenticada' => 'Autenticada',
                                    'NoAutenticada'=>'No Autenticada'],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Autenticadaa()", 'id'=>'ventaAutenticadaf']  ) }}
                            </div>
                        </div>

                        <div class="form-group" style='display: none;' id='noExitosa'>
                            {{ Form::label('No Autenticada','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::select('aprobada', [
                                    'Pre-Asignada' => 'Pre-Asignada',
                                    'En Proceso'=>'En Proceso',
                                    'Duplicidad Banamex'=>'Duplicidad Banamex',
                                    'Error Tipificacion CRM'=>'Error Tipificacion CRM',
                                    'Pendientes Captura'=>'Pendientes Captura',
                                    'Duplicidad CRM'=>'Duplicidad CRM'],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required',  "onchange"=>"NoAprobada()", 'id'=>'noExitosaf']  ) }}
                            </div>
                        </div>

                         <div class="form-group" style='display: none;' id='ventaAprobada'>
                            {{ Form::label('Aprobada','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::select('aprobada', [
                                    'Aprobada' => 'Aprobada',
                                    'NoAprobada'=>'No Aprobada'
                                    ],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Aprobada()", 'id'=>'ventaAprobadaf']  ) }}
                            </div>
                        </div>


                         <div class="form-group" style='display: none;' id='folio'>
                            {{ Form::label('Folio Banamex','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('Folio Banamex','',array('class'=>"form-control", 'required' => 'required', 'id'=>'foliof' )) }}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10">
                                {{ Form::submit('Enviar',['class'=>"btn btn-default" ,"onClick"=>"return ValidaCaracteres()"] ) }}
                            </div>
                        </div>

                        {{ Form::close() }}

                    </div>
            </div>
        </div>
        <div class="col-md-5">
          @else
              <div>
              no hay registros se actualizara en 1 min
              </div>

              <head>
                  <meta http-equiv="refresh" content="10" />
              </head>

          @endif
@stop
@section('content2')

<script type="text/javascript">

    function Exitosa(){
        console.log($('#ventaExitosa').val());
        if($('#ventaExitosa').val()=='Exitosa'){
            $('#ventaAutenticada').show();
            $("#ventaAutenticadaf").prop('disabled',false);
            // $('#noExitosa').hide();
            // $("#noExitosaf").prop('disabled',true);
        }
        else{
            $('#ventaAutenticada').hide();
            $('#folio').hide();
            $('#ventaAprobada').hide();
            // $('#noExitosa').show();
            $("#ventaAutenticadaf").prop('disabled',true);
            $("#ventaAprobadaf").prop('disabled',true);
            $("#noExitosaf").prop('disabled',true);
            $("#foliof").prop('disabled',true);
        }
    }
function ValidaCaracteres(){
if($("#ventaExitosa").val()=='Exitosa'){
  if($("#foliof").val().length < 17){
    alert('Longitud de folio erronea');
    return false;
  }
  else {
    return true;
  }
}
}
function NoAprobada(){
    if($('#noExitosaf').val()=='Pre-Asignada'||$('#noExitosaf').val()=='En Proceso'||$('#noExitosaf').val()=='Duplicidad Banamex'){
      $("#foliof").prop('disabled',false);
      $('#folio').show();
    }else {
      $("#foliof").prop('disabled',true);
      $('#folio').hide();
    }
}

    function Autenticadaa(){
      console.log($('#ventaAutenticadaf').val());
      if($('#ventaAutenticadaf').val()=='Autenticada'){

        $('#ventaAprobada').show();
        // $("#ventaAutenticada").prop('disabled',false);
        $("#ventaAprobadaf").prop('disabled',false);
        $('#noExitosa').hide();
        $("#noExitosaf").prop('disabled',true);

      }
      else{
        $('#ventaAprobada').hide();
        $('#folio').hide();
        $("#ventaAprobadaf").prop('disabled',true);
        /*$("#ventaAutenticadaf").prop('disabled',true);*/
        $('#noExitosa').show();
        $("#noExitosaf").prop('disabled',false);
        $("#foliof").prop('disabled',true);
      }
    }

    function Aprobada(){
      console.log($('#ventaAprobadaf').val());
      if($('#ventaAprobadaf').val()=='Aprobada'){

        $('#folio').show();
        $("#ventaAprobada").prop('disabled',false);
        $("#foliof").prop('disabled',false);
      }
      else{
        $('#folio').show();
        $("#ventaAprobada").prop('disabled',false);
        /*$("#ventaAutenticadaf").prop('disabled',true);*/
        $("#foliof").prop('disabled',false);
      }
    }

</script>
