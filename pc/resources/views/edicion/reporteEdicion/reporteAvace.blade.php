@extends( $menu )
@section('content')
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de edición por avance</h3>
            </div>
            <div class="panel-body">
              <div class="zui-wrapper">
                <div class="zui-scroller">
                <table class="zui-table table table-bordered">
                <thead>
                	<tr>
                    	<th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">DÍA</th>
                    	<th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">VENTAS</th>
                    	<th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">ACEPTADAS</th>
                        <th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">RECHAZADAS</th>
                    	<th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">NO ENCONTRADAS</th>
                        <th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">TOTAL EDITADOS</th>
                    	<th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">% AVANCE</th>
                    </tr>
                </thead>

                @foreach($ventas as $key => $values)
                    <tr>
                        <td style="text-align: center;"> {{$values -> fecha_capt}} </td>
                        <td style="text-align: center;"> {{$values -> Ventas}} </td>
                        <td style="text-align: center;"> {{$values -> edi_acep}} </td>
                        <td style="text-align: center;"> {{$values -> edi_recha}} </td>
                        <td style="text-align: center;"> {{$values -> no_entada}} </td>
                        <td style="text-align: center;"> {{$values -> total_edi}} </td>
                        <td style="text-align: center;"> {{$values -> Avence}} </td>
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
