@extends('a.layout-master')
@section('content')

@if ($path=='')
<div class="alert alert-dismissible alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Vaya!</strong> Algo salió mal.
  Por favor vuelve a intentarlo o comunícate con el área de sistemas.
  <!-- <br><strong>Reintentar</strong> -->
  <br>
  <strong>
    <h2>
      <a href="{{URL('/Inbursa/Calidad/Audios/Inicio')}}" class="alert-link">Volver</a>
    </h2>

  </strong>
</div>

@else

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Calidad</h3>
    </audio>
  </div>
  <div class="panel-body">
    {{ Form::open(['action' => 'V2\Inbursa\CalidadController@CalidadAudiosGuardar',
                    'method' => 'post',
                    'class'=>"form-horizontal",
                    'accept-charset'=>"UTF-8",
                    'enctype'=>"multipart/form-data",
                    'name' => "formulario"
                ]) }}

      <fieldset>
        <legend>Folio {{$info[0]->id}}</legend>
        <div class="form-group">
          <label for="inputEmail" class="col-lg-2 control-label">Grabación</label>
          <div class="col-lg-10">
            <audio src="{{asset($path)}}" controls style="width:100%; max-width:600px">
          </div>
        </div>


        <div class="form-group">
            {{ Form::label('Campaña','',array('class'=>" col-sm-2 control-label")) }}
            <div class="col-sm-9">
              {{ Form::text('campania','Inbursa Vidatel',
              array('required' => 'required', 'class'=>"form-control", 'readonly'=>'readonly')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('DN','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-9">
                {{ Form::text('dn',$info[0]->telefono,
                array('required' => 'required', 'class'=>"form-control", 'readonly'=>'readonly')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Fecha de venta','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-9">
                 {{ Form::date('fechaVenta',$info[0]->fecha_capt,
                 array('class'=>"form-control", 'required' => 'required', 'readonly'=>'readonly' )) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Auditor','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-9">
              {{ Form::text('auditor',session('user'),
              array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Editor','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-9">
              {{ Form::text('editor',$info[0]->quienSubio,
              array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Saludo institucional','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-9">
              {{ Form::select('saludo', [
              'Si' => 'Si',
              'No' => 'No'],
              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Manejo de script','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-9">
              {{ Form::select('script', [
              'Si' => 'Si',
              'No' => 'No'],
              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Manejo de objeciones','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-9">
              {{ Form::select('objeciones', [
              'Si' => 'Si',
              'No' => 'No'],
              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Cierre de venta','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-9">
              {{ Form::select('cierre', [
              'Si' => 'Si',
              'So' => 'No'],
              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Despedida Institucional','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-9">
              {{ Form::select('despedida', [
              'Si' => 'Si',
              'No' => 'No'],
              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Error Critico','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-9">
              {{ Form::select('error', [
              'Si' => 'Si',
              'No' => 'No'],
              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Motivos de Error Critico','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-9">
              {{ Form::select('errorMotivo', [
              'Corte evidente en audio' => 'Corte evidente en audio',
              'Frases informativas sin editar' => 'Frases informativas sin editar',
              'Coherencia en la llamada' => 'Coherencia en la llamada',
              'Espacios de conversacion' => 'Espacios de conversacion'],
              '', ['class'=>"form-control", 'placeholder'=>""]  ) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Observaciones','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-9">
                {{ Form::text('observaciones','',array('class'=>"form-control", 'placeholder'=>"")) }}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                {{ Form::submit('Enviar',['class'=>"btn btn-primary"]) }}
            </div>
        </div>
        {{ Form::close() }}


      </fieldset>
    </form>



  </div>
</div>

@endif







@stop
@section('contentScript')
<script type="text/javascript">

</script>
@stop
