@extends("layout.calidad.pospago.pospago")
@section('content')
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DN</th>
                                        <th>Tipificacion</th>
                                        <th>Fecha de Validacion</th>
                                        <th>Auditados</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rechazos as $key => $rechazosValue)
                                    <tr >
                                        <td>{{ $key+1 }}</td>
                                        <td><a href="{{ url('rechazos/lista/'.$rechazosValue->dn) }}">{{ $rechazosValue->dn }}</a></td>
                                        <td>{{ utf8_decode($rechazosValue->tipificar) }}</td>
                                        <td>{{ $rechazosValue->fecha_val }}</td>
                                        <td>{{ $rechazosValue->estatus }}</td>
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
        <script>

            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>
    @stop
