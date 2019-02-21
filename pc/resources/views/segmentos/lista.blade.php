@extends('layout.admin.plan')
@section('content')
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Segmentos</h3>
                        </div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th># de Segmento</th>
                                        <th>Posicion Inicial</th>
                                        <th>Posicion Final</th>
                                        <th>Break</th>
                                        <th>Supervisor</th>
                                        <th>Validador</th>
                                        <th>Analista de Calidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($array as $value)
                                    <tr>
                                        <td><a href="{{ url('Administracion/segmento/ver/'.$value['id']) }}"> {{ $value['segmento']}} </a></td>
                                        <td>{{ $value['pos_inicial'] }}</td>
                                        <td>{{ $value['pos_final'] }}</td>
                                        <td>{{ $value['break'] }}</td>
                                        <td>{{ $value['supervisor'] }}</td>
                                        <td>{{ $value['validador'] }}</td>
                                        <td>{{ $value['analista_calidad'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop
@section('content2')
        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
</script>
    @stop
