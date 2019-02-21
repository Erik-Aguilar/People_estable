@extends($menu)
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Genera Base</h3>
            </div>
            <div class="panel-body">
              {{ Form::open(['action' => 'BoController@AsignaBaseDatos',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario",
                          ]) }}
              <div class="form-group">
                <div class="col-sm-12">

                  <div class="col-sm-6 ">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h3 class="panel-title">Agentes TM Prepago</h3>
                      </div>
                      <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Agente</th>
                              <th>Proceso 1</th>
                              <th>Proceso 2</th>
                              <th>WhatsApp</th>
                              <th>Sin Proceso</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($datos as $key=>$value)
                            <tr>
                              <td>{{$value->nombre_completo}}</td>
                              <td style="text-align:center">{{Form::radio($value->id, '1',['required'=>'required'])}}</td>
                              <td style="text-align:center">{{Form::radio($value->id, '2',['required'=>'required'])}}</td>
                              <td style="text-align:center">{{Form::radio($value->id, 'wa',['required'=>'required'])}}</td>
                              <td style="text-align:center">{{Form::radio($value->id, '',['required'=>'required'])}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>


                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 ">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h3 class="panel-title">Agentes TM Pospago</h3>
                      </div>
                      <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Agente</th>
                              <th>Proceso 1</th>
                              <th>Proceso 2</th>
                              <th>WhatsApp</th>
                              <th>Sin Proceso</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($datos2 as $key2=>$value2)
                            <tr>
                              <td>{{$value2->nombre_completo}}</td>
                              <td style="text-align:center">{{Form::radio($value2->id, '1',['required'=>'required'])}}</td>
                              <td style="text-align:center">{{Form::radio($value2->id, '2',['required'=>'required'])}}</td>
                              <td style="text-align:center">{{Form::radio($value2->id, 'wa',['required'=>'required'])}}</td>
                              <td style="text-align:center">{{Form::radio($value2->id, '',['required'=>'required'])}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>


                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <div>
                {{ Form::submit('Enviar',['id'=>'sendB','class'=>"btn btn-default"]) }}
              </div>
              {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('content2')
<script>
function Genera(){
  var val=[];
  var val2=[];
  var val3=[];

  $('input:checkbox[name=estatus]:checked').each(function(i){
    val[i]=$(this).val();
  });
  $('input:checkbox[name=zonaAbril]:checked').each(function(i){
    val2[i]=$(this).val();
  });
  $('input:checkbox[name=zonaMayo]:checked').each(function(i){
    val3[i]=$(this).val();
  });
  console.log(val);
  $.ajax({
    type: "POST",
    url: '/bo/asigna_base/asigna',
    data: form.serialize(),
    success: function(data){
      console.log(data);
    }
  });
}

</script>
@stop
