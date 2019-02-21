@extends($menu)
@section('content')
<?php
$value = Session::all();
$totalCitas=0;
$totalAsis=0;
$totalAct=0;
?>


            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Capacitacion</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                  <tr>
                                    <th>Reclutador</th>
                                    <th>Agendados</th>
                                    <th>Asistieron</th>
                                    <th>Activos</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($array as $key => $value)
                                  <tr>
                                    <td>{{$value['nombre']}}</td>
                                    <td>{{$value['num']}}</td>
                                    <td>{{$value['asistidos']}}</td>
                                    <td>{{$value['activos']}}</td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

<!--
        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>   -->
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <script>
$(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});
        </script>
    @stop
