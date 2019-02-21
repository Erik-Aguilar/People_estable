@extends($menu)
@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Asistencia Telefonica</h3>
      </div>
      <div class="panel-body">
        {{ Form::open(['action' => 'SupervisorController@GuardaPaseAsistenciapos',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}
        <div style="display: none;">
            {{ Form::text('total',count($users),array('class'=>"form-control")) }}
          </div>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre Operador</th>
              <th>Hora</th>
              <th>Asistencia</th>
              <th>Motivo Falta</th>
              <th>Observaciones</th>
            </tr>
          </thead>
          <tbody>
          @foreach($users as $key => $userValue)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$userValue->paterno}} {{$userValue->materno}} {{$userValue->nombre}}</td>
              <td><div id='login{{$key}}'>{{$userValue->login}}</div></td>
              <td>
                {{ Form::select("asistencia$key", [
                      'Si' => 'Si',
                      'No' => 'No'],
                      $userValue->asistencia, ['id'=>"asistencia$key",'required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
              </td>
              <td>
                {{ Form::select("MotivoFalta$key", [
                      'Enfermedad' => 'Enfermedad',
                      'Personal' => 'Personal',
                      'No contesta' => 'No contesta',
                      'Sin motivo' => 'Sin motivo',
                      'Defuncion' => 'Defuncion',
                      'Tramites' => 'Tramites',
                      'Vacaciones' => 'Vacaciones'],
                      $userValue->motivo_falta, ['id'=>"area$key", 'class'=>"form-control", 'placeholder'=>""]  ) }}
              </td>
              <td>
                {{ Form::text("observaciones$key",$userValue->observaciones,array('class'=>"form-control")) }}
              </td>
              <td style="display: none;">
                {{ Form::text("user$key",$userValue->id,array('class'=>"form-control",'id'=>'total')) }}
                {{ Form::text("nombre$key",$userValue->paterno.' '.$userValue->materno.' '.$userValue->nombre,array('class'=>"form-control",'id'=>'total')) }}
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
        <div class="">
                {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
        </div>
      </div>
    </div>
  </div>
</div>
@stop
@section('content2')
<script>
/*var total =$('#total').text();
var cont=0;
var log=$('#login1').text();
  console.log(log);
while(cont<total)
{
  if($('#login'+cont).text()=='')
  {
    $('#asistencia').empty();

                    $('#asistencia').append(new Option('', ''));
                    $('#asistencia').append('<option value=No>'No'</option>');
  }
  else
  {

  }

}
var log=$('#login0').text();
  console.log(log);
  */
</script>
@stop
