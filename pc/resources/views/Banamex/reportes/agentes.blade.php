@extends($menu)
@section('content')
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Agentes</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Nombre</th>
                                        <th>Campaña</th>
                                        <th>Area</th>
                                        <th>Puesto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $key=>$value)
                                    <tr >
                                        <td>{{ $value->id}}</td>
                                        <td>{{ $value->nombre_completo}}</td>
                                        {{--*/
                                          //dd($key);
                                          /*--}}
                                        <td>
                                          {{Form::select('campaign', [
                                        'Bancomer' => 'Bancomer',
                                        'Bancomer3' => 'Bancomer3',
                                        'Banamex' => 'Banamex'],
                                        $value->campaign, ['required' => 'required', 'class'=>'form-control', 'placeholder'=>'','onchange'=>'cambia('.$value->id.',this.value)']  )}}</td>
                                        <td>{{ $value->area}}</td>
                                        <td>{{ $value->puesto}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
        <script>



        </script>
@stop
@section('content2')
<script>
  function cambia(id,val){
    console.log(id);
    console.log(val);
    $.ajax({
      type: "POST",
      url: "/banamex/agentes/id",
      data: {id:id,camp:val},
      success: function(data){
        console.log(data);
      }
    });

  }
</script>
    @stop
