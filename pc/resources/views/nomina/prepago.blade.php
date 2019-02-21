@extends('layout.nomina.basic')
@section('content')

<style type="text/css">
    .modal-header
{
    background:#ff3333;
    color:white;
}

</style>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">TM Prepago</h3>
                        </div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th># empleado</th>
                                        <th>Nombre</th>
                                        <th>Ventas</th>
                                        <th>Comisiones</th>
                                        <th>Faltas</th>
                                        <th>Dias</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $value)
                                    @if($key != '')
                                    <tr >
                                        <td>{{$key}}</td>
                                        <td>{{$value['nombre']}}</td>
                                        <td>{{$value['ventas']}}</td>
                                        <td>{{$value['comisiones']}}</td>
                                        <td>{{$value['faltas']}}</td>
                                        <td>{{$value['dias']}}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <script>
  $(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true,
        "order": [[ 3, 'desc' ]]
    });
  });
        </script>
    @stop
