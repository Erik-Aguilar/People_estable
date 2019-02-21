@extends('layout.demos.reporte')
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Ver Editores</h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                      <tr>
                        <th>Numero de Empleado</th>
                        <th>Nombre</th>
                        <th>Campaña</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($editor as $valueeditor)
                             <tr>
                               <td><a href="{{ url('/CambioEditor/'.$valueeditor->id)}}" >{{ $valueeditor->id }}</a></td>
                               <td>{{ $valueeditor->nombre_completo }}</td>
                               <td>{{ $valueeditor->campaign }}</td>
                             </tr>
                             @endforeach
                  </tbody>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!--alertify -->

<script>

    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });



</script>

@stop
