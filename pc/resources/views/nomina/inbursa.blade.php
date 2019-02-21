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
                <div class="col-md-12 ">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ $campaign }}</h3>
                        </div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Fecha capacitación</th>
                                        <th>Dias laborables</th>
                                        <th>Faltas</th>
                                        <th>Dias Adicionales</th>
                                        <th>Dias efectivos</th>
                                        <th>Sueldo Periodo</th>
                                        <th>Complemento</th>
                                        <!-- <th>Calificacion calidad</th>
                                        <th>Calidad</th> -->
                                        <th>Bono A y P</th>
                                        <th>Ventas</th>
                                        <th>Comisiones ventas</th>
                                        <th>Sueldo + complemento</th>
                                        <th>Complemento periodo </th>
                                        <th>Sueldo + complemento 2</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $value)
                                    @if($key != '')
                                    <tr >
                                        <td>{{ $key }}</td>
                                        <td>{{ $value['nombre'] }}</td>
                                        <td>{{ $value['fechaCapa'] }}</td>
                                        <td>{{ $value['dias'] }}</td>
                                        <td>{{ $value['faltas'] }}</td>
                                        <td>{{ $value['diasAdicionales'] }}</td>
                                        <td>{{ $value['diasEfectivos'] }}</td>
                                        <td>{{ $value['sueldoPeriodo'] }}</td>
                                        <td>{{ $value['complemento'] }}</td>
                                        <td>{{ $value['bonoAP'] }}</td>
                                        <td>{{ $value['ventas'] }}</td>
                                        <td>{{ $value['comisiones'] }}</td>
                                        <td>{{ $value['comisiones'] + $value['sueldoPeriodo'] +  $value['bonoAP'] + $value['complemento'] }}</td>
                                        <td>{{ $value['complementoPeriodo'] }}</td>
                                        <td>{{ $value['sueldoMasComplemento'] }}</td>



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
        "order": [[ 1, 'asc' ]]
    });
  });
        </script>
    @stop
