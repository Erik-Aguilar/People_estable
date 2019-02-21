@extends('layout.mapfre.reportes')
@section('content')

<div class="row">
    <div class="col-lg-9 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de Horas Mapfre</h3>
            </div>
            <div class="panel-body">
              <div class="zui-wrapper">
                <div class="zui-scroller">
                <table class="zui-table table table-bordered">
                	<tr>
                    	<th rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">POLIZA</th>
                    	<th rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">TIPO_TELEFONO</th>
                    	<th rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">EJECUTIVO</th>
                    	<th rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">FECHA</td>
                    	<th rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">HORA</td>
                    	<th rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">COD_INTERVALO</td>
                        <th rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">CALIF_CONTACTO</th>
                        <th rowspan="5" style="height: 61px; width: 100%; padding-top:20px; background: #f4f1ed;">ESTATUS</th>
                  	</tr>

                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

@stop 