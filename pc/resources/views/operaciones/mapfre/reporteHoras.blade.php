@extends('layout.mapfre.reportes')
@section('content')
<div class="row">
    <div class="col-lg-10 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de Horas Mapfre</h3>
            </div>
            <div class="panel-body">
              <div class="zui-wrapper">
                <div class="zui-scroller">
                <table class="zui-table table table-bordered">
                <thead>
                	<tr>
                    	<th rowspan="2" style="height: 20px; width: 25%; padding-top:20px; background: #f4f1ed;">ID_EJECUTIVO</th>
                    	<th rowspan="2" style="height: 20px; width: 25%; padding-top:20px; background: #f4f1ed;">HORARIO</th>
                    	<th rowspan="2" style="height: 20px; width: 25%; padding-top:20px; background: #f4f1ed;">ID_CONEXION</th>
                    	<th rowspan="2" style="height: 20px; width: 25%; padding-top:20px; background: #f4f1ed;">TIPO_TELEFONOSMARCADOS</td>
                    	<th rowspan="2" style="height: 20px; width: 25%; padding-top:20px; background: #f4f1ed;">FECHA</td>
                    	<th rowspan="2" style="height: 20px; width: 25%; padding-top:20px; background: #f4f1ed;">CLAVE_INTERVALO</td>
                        <th rowspan="2" style="height: 20px; width: 25%; padding-top:20px; background: #f4f1ed;">TIEMPO</th>
                        <th rowspan="2" style="height: 20px; width: 25%; padding-top:20px; background: #f4f1ed;">FACTURABLE</th>
                  	</tr>
                </thead>
                <tbody>
                    
                </tbody>

                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

@stop