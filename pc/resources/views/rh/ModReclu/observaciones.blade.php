@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Capacitacion | {{$candidato[0]->nombre_completo}}</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'CapacitadorController@updateObservaciones',
                                'method' => 'post', 
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="form-group" style='display:none;'>
                    {{ Form::label($candidato[0]->nombre_completo,'',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('id',$candidato[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                    </div>
                </div>
                
                <div class="form-group" style='display:none;'>
                    {{ Form::label('Fecha de capacitacion','',array('class'=>"col-sm-2 control-label",)) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha',$candidato[0]->fecha_capacitacion,array('required' => 'required', 'class'=>"form-control Fase2", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Asistencia del Dia 1','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('primerDia', [
                        'Si' => 'Si',
                        'No' => 'No'],
                    $candidatoVal->primerDia, ['id'=>'dia1','class'=>"form-control", 'placeholder'=>""] ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Asistencia del Dia 2','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('segundoDia', [
                        'Si' => 'Si',
                        'No' => 'No'],
                    $candidatoVal->segundoDia, ['id'=>'dia2','class'=>"form-control", 'placeholder'=>"",'onChange'=>'val()'] ) }}
                    </div>
                </div>

                <div class="form-group" style='display: none;' id='estatusform'>
                    {{ Form::label('Estatus del Candidato *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('estatus', [
                        'VoBo' => 'VoBo',
                        'No VoBo' => 'No VoBo'],
                    $candidatoVal->estatus, ['required'=>'required','id'=>'estatus','class'=>"form-control", 'placeholder'=>""] ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Fecha Entrega','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha_E',$candidatoVal->fechaEntrega,array('class'=>"form-control", 'placeholder'=>"********")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Observaciones','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::textarea('observaciones',$candidatoVal->observaciones,['class'=>'form-control'])}}
                    </div>
                </div>

            

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
@stop
@section('content2')
<script>
$( document ).ready(function() {
  if($("#dia2").val()=='Si'){
    $('#estatusform').attr("style",'');
    $("#estatus").prop('disabled', false);
  }
  else{
    $('#estatusform').attr("style",'display:none');
    $("#estatus").prop('disabled', true);
  }
});
function val(){
  if($("#dia2").val()=='Si'){
    $('#estatusform').attr("style",'');
    $("#estatus").prop('disabled', false);
  }
  else{
    $('#estatusform').attr("style",'display:none');
    $("#estatus").prop('disabled', true);
  }

}
</script>
@stop
