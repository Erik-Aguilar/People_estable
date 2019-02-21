@extends( $menu )
@section('content')
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte audios no encontrados Mapfre</h3>
            </div>
            <div class="panel-body">
              <div class="zui-wrapper">
                <div class="zui-scroller">
                <table class="zui-table table table-bordered">
                <thead>
                	<tr>
                    	<th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">Fecha Venta</th>
                    	<th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">Nombre del Vendedor</th>
                    	<th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">Número del cliente</th>
                    	<th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">Telefono Marcado</th>
                    	<th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">Nombre del editor</th>
                        <th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">Fecha reportado</th>
                    </tr>
                </thead>

                @foreach($dato as $key => $values)
                    <tr>
                        <td style="text-align: center;"> {{$values -> fechaVenta}} </td>
                        <td style="text-align: center;"> {{$values -> nombre_completo}} </td>
                        <td style="text-align: center;"> {{$values -> numcliente}} </td>
                        <td style="text-align: center;"> {{$values -> tel_marcado}}  </td>
                        <td style="text-align: center;"> {{$values -> nombreEditor}} </td>
                        <td style="text-align: center;"> {{$values -> fechaSubido}} </td>
                  	</tr>

                @endforeach

                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>


@stop