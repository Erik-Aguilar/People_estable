@extends('layout.root.plan')
@section('content')

<style type="text/css">
    .modal-header
{
    background:#ff3333;
    color:white;
}

</style>

            <div class="row">
                <div class="col-md-12 ">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title"><a href="{{ url('Nomina/nomina/csv') }}">Descargar</a></h2>
                        </div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Fecha inicio</th>
                                        <th>Campaña</th>
                                        <th>Area</th>
                                        <th>Puesto</th>
                                        <th>Turno</th>
                                        <th>Grupo</th>
                                        <th>Sueldo Mensual</th>
                                        <th>Complemento</th>
                                        <th>Bono AyP</th>
                                        <th>Calidad</th>
                                        <th>Productividad</th>
                                        <th>Dias laborables</th>
                                        <th>Faltas</th>
                                        <th>Dias adicionales</th>
                                        <th>Sueldo periodo</th>
                                        <th>Complemento periodo</th>
                                        <th>AyP periodo</th>
                                        <th>Calificacion calidad</th>
                                        <th>Bono calidad periodo</th>
                                        <th>Ventas</th>
                                        <th>Productividad periodo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($val as $key => $value)
                                    @if($key != '')
                                    <tr >
                                        <td>{{ $value['id'] }}</td>
                                        <td>{{ $value['nombre'] }}</td>
                                        <td>{{ $value['fechaCapa'] }}</td>
                                        <td>{{ $value['campania'] }}</td>
                                        <td>{{ $value['area'] }}</td>
                                        <td>{{ $value['puesto'] }}</td>
                                        <td>{{ $value['turno'] }}</td>
                                        <td>{{ $value['grupo'] }}</td>
                                        <td>{{ $value['sueldoMensual'] }}</td>
                                        <td>{{ $value['complemento'] }}</td>
                                        <td>{{ $value['bonoAp'] }}</td>
                                        <td>{{ $value['calidad'] }}</td>
                                        <td>{{ $value['productividad'] }}</td>
                                        <td>{{ $value['diasLaborables'] }}</td>
                                        <td>{{ $value['faltas'] }}</td>
                                        <td>{{ $value['diasAdicionales'] }}</td>
                                        <td>{{ $value['sueldoPeriodo'] }}</td>
                                        <td>{{ $value['complementoPeriodo'] }}</td>
                                        <td>{{ $value['bonoApPeriodo'] }}</td>
                                        <td>{{ $value['calificacionCalidad'] }}</td>
                                        <td>{{ $value['bonoCalidad'] }}</td>
                                        <td>{{ $value['ventas'] }}</td>
                                        <td>{{ $value['productividadPerido'] }}</td>
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
        "order": [[ 0, 'asc' ]]
    });
  });
        </script>
    @stop
