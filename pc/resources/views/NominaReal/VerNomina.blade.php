@extends('layout.error.error')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Nomina Real</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>No. Empleado</th>
                            <th>Nombre</th>
                            <th>Area</th>
                            <th>Puesto</th>
                            <th>Campania</th>
                            <th>Turno</th>

                            <th>Sueldo</th>
                            <th>Complemento</th>

                            <th>Dias Laborados </th>
                            <th>Asistencias</th>
                            <th>Retardos</th>
                            <th>Faltas por Retardo</th>
                            <th>Faltas</th>
                            <th>Dias Efectivos</th>

                            <th>Sueldo a Cobrar</th>
                            <th>Complemento a Cobrar</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr >
                                <td> {{$datosCandidato->id}} </td>
                                <td> {{$datosCandidato->nombre_completo}} </td>
                                <td> {{$datosCandidato->area}} </td>
                                <td> {{$datosCandidato->puesto}} </td>
                                <td> {{$datosCandidato->campaign}} </td>
                                <td> {{$datosCandidato->turno}} </td>

                                <td> {{$esquemaPago[0]->sueldo}} </td>
                                <td> {{$esquemaPago[0]->complemento}} </td>

                                <td> {{$datosHA[0]->dias_laborados}} </td>
                                <td> {{$datosHA[0]->asistencias}}</td>
                                <td> {{$datosHA[0]->retardos}} </td>
                                <td> {{$datosHA[0]->faltas_por_retardo  }} </td>
                                <td> {{$datosHA[0]->faltas}} </td>
                                <td> {{$datosHA[0]->dias_efectivos}} </td>

                                <td> {{$sueldoCobrar}} </td>
                                <td> {{$complementoCobrar}} </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
@stop
