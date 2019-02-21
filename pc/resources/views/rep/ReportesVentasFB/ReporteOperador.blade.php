@extends($menu)
@section('content')
<br><br> <br><br><br>
<div class="row">
    <div class="col-md-12 ">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte Tipificaciones Operador</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='25'>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Sin Num</th>
                            <th>Ges Otro Call</th>
                            <th>Linea Inactiva</th>
                            <th>Movistar</th>
                            <th>No le Interesa</th>
                            <th>Plan de renta</th>
                            <th>Reagenda</th>
                            <th>Buzon</th>
                            <th>CAC</th>
                            <th>Sin Estatus</th>
                            <th>Venta</th>
                            <th>Llamar</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($datos as $datosValue)
                        <tr >
                            <td class="center">{{ $datosValue->fecha}}</td>
                            <td>{{ $datosValue->sin_numero}}</td>
                            <td>{{ $datosValue->gestionado}}</td>
                            <td>{{ $datosValue->linea_inactiva}}</td>
                            <td>{{ $datosValue->movistar}}</td>
                            <td>{{ $datosValue->interesa}}</td>
                            <td>{{ $datosValue->renta}}</td>
                            <td>{{ $datosValue->reagenda}}</td>
                            <td>{{ $datosValue->buzon}}</td>
                            <td>{{ $datosValue->cac}}</td>
                            <td>{{ $datosValue->sin_estatus}}</td>
                            <td>{{ $datosValue->venta}}</td>
                            <td>{{ $datosValue->llamar}}</td>
                            <td>{{ $datosValue->total}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

