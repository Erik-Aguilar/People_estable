@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte Tip Ventas FaceBook | Chateador</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='25'>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Movistar</th>
                            <th>No le Interesa</th>
                            <th>Reagenda</th>
                            <th>Plan de renta</th>
                            <th>Venta</th>
                            <th>CAC</th>
                            <th>Buzon</th>
                            <th>No Contesta</th>
                            <th>Fuera de Servicio</th>
                            <th>Linea Inactiva</th>
                            <th>Sin Estatus</th>
                            <th>Total</th>
                            <th>Conversion</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($datos as $datosValue)
                        <tr >
                            <td class="center">{{ $datosValue->fecha}}</td>
                            <td>{{ $datosValue->movistar}}</td>
                            <td>{{ $datosValue->interesa}}</td>
                            <td>{{ $datosValue->reagenda}}</td>
                            <td>{{ $datosValue->renta}}</td>
                            <td>{{ $datosValue->venta}}</td>
                            <td>{{ $datosValue->cac}}</td>
                            <td>{{ $datosValue->buzon}}</td>
                            <td>{{ $datosValue->no_contesta}}</td>
                            <td>{{ $datosValue->fuera}}</td>
                            <td>{{ $datosValue->linea_inactiva}}</td>
                            <td>{{ $datosValue->sin_estatus}}</td>
                            <td>{{ $datosValue->total}}</td>
                            <td>{{ $datosValue->conversion}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-12 ">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte numero de Telefono</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" data-page-length='25'>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Sin Num</th>
                            <th>Con numero</th>
                            <th>Total</th>
                            <th>Conversion</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sin_con as $datosValue)
                        <tr >
                            <td class="center">{{ $datosValue->fecha}}</td>
                            <td>{{ $datosValue->sin_numero}}</td>
                            <td>{{ $datosValue->numero}}</td>
                            <td>{{ $datosValue->total}}</td>
                            <td>{{ $datosValue->conversion}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>












<div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte Tip Ventas FaceBook | Cerrador</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='25'>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Movistar</th>
                            <th>No le Interesa</th>
                            <th>Reagenda</th>
                            <th>Plan de renta</th>
                            <th>Venta</th>
                            <th>CAC</th>
                            <th>Buzon</th>
                            <th>No Contesta</th>
                            <th>Fuera de Servicio</th>
                            <th>Linea Inactiva</th>
                            <th>Sin Estatus</th>
                            <th>Total</th>
                            <th>Conversion</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($datos2 as $datosValue)
                        <tr >
                            <td class="center">{{ $datosValue->fecha}}</td>
                            <td>{{ $datosValue->movistar}}</td>
                            <td>{{ $datosValue->interesa}}</td>
                            <td>{{ $datosValue->reagenda}}</td>
                            <td>{{ $datosValue->renta}}</td>
                            <td>{{ $datosValue->venta}}</td>
                            <td>{{ $datosValue->cac}}</td>
                            <td>{{ $datosValue->buzon}}</td>
                            <td>{{ $datosValue->no_contesta}}</td>
                            <td>{{ $datosValue->fuera}}</td>
                            <td>{{ $datosValue->linea_inactiva}}</td>
                            <td>{{ $datosValue->sin_estatus}}</td>
                            <td>{{ $datosValue->total}}</td>
                            <td>{{ $datosValue->conversion}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



















@stop
@section('content2')
        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
@stop
