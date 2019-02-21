@extends($layout)
@section('content')

<div class="container-fluid">
  <div class="row">
  <div class="col-md-8 col-md-offset-2">
    <legend>
      <img src="{{ asset('assets/img/auri_logo.png') }}">

    </legend>
    <br>
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">Hoy</a></li>
      <li><a href="#profile" data-toggle="tab">Vencido</a></li>
      <!-- <li><a href="#tomorrow" data-toggle="tab">Completo</a></li> -->
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane fade active in" id="home">
        <table class="table table-striped table-hover ">
          <thead>
            <tr class="info">
              <th>#</th>
              <th>Empresa</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Última llamada</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($citas as $key => $value)
              <tr class="active">
                <td>{{$key+1}}</td>
                <td><a href="/auri/agendado/{{$value->id}}">{{$value->empresa}}</td>
                <td>{{$value->fecha}}</td>
                <td>{{$value->hora}}</td>
                <td>{{$value->ult}}</td>
              </tr>
            @endforeach
          </tbody>
      </table>
      </div>
      <div class="tab-pane fade" id="profile" style="background-color:gray">
        <table class="table table-striped " id="dataTables-example">
          <thead>
            <tr class="info">
              <th>#</th>
              <th>Empresa</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Última llamada</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($vencidos as $key => $value)
              <tr class="active">
                <td>{{$key+1}}</td>
                <td><a href="/auri/agendado/{{$value->id}}">{{$value->empresa}}</a></td>
                <td>{{$value->fecha}}</td>
                <td>{{$value->hora}}</td>
                <td>{{$value->ult}}</td>
              </tr>
            @endforeach
          </tbody>
      </table>
      </div>
      <!-- <div class="tab-pane fade" id="tomorrow">
        <table class="table table-striped table-hover" id="dataTables-example">
          <thead>
            <tr class="info">
              <th>#</th>
              <th>Empresa</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Última llamada</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div> -->
    </div>


  </div>

  <!-- <div class="col-md-4">
    <br><br><br><br><br><br><br>
    <div id="datetimepicker12" style="margin-left:50%"></div>
  </div> -->

</div>
</div>
@stop

@section('content2')
<script >

        $('#datetimepicker12').datetimepicker({
            inline: true,

        });


</script>

<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!--alertify -->
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.core.css">
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.default.css">
<script src="http://blog.reaccionestudio.com/ejemplos/alertify_js/lib/alertify.js"></script>

<script>
    // function elim(id, paterno, materno, nombre){
    //     //un confirm
    //     alertify.confirm("<h1>¿Esta seguro que desea eliminar a:?<br>"+id+" "+nombre+" "+paterno+" "+materno+" </h1>", function (e) {
    //         if (e) {
    //             //window.locationf="Administracion/admin/delete/"+;
    //             alertify.success("Has pulsado '" + alertify.labels.ok + "'");
    //             location.href='/Administracion/admin/delete/'+id;
    //         } else { alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
    //         }
    //     });
    //     return false
    // }

    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

@stop
