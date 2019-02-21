@extends('layout.mapfre.reportes')
@section('content')

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de Validación Mapfre</h3>
            </div>
            <div class="panel-body">
              <div class="zui-wrapper">
                <div class="zui-scroller">
                <table class="zui-table table table-bordered">
                	<tr>
                    	<th rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">POLIZA</th>
                    	<th rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">FECHA_VALIDACION</th>
                    	<th rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">CALIF_CONTACTO_FINAL</th>
                        <th rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">TIPO_RECHAZO</th> 
                    </tr>

                    <tr>
                    	<td rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">NOMBRE</td>
                    	<td rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">CC</td>
                  	</tr>

                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

@stop