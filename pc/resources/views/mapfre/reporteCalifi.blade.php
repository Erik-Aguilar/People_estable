@extends('layout.mapfre.reportes')
@section('content')
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de calificaciones Mapfre</h3>
            </div>
            <div class="panel-body">
              <div class="zui-wrapper">
                <div class="zui-scroller">
                <table class="table-bordered">
                <thead>
                	<tr>
                    	<th style="height: 61px; padding-top:20px; background: #f4f1ed;">POLIZA</th>
                    	<th style="height: 61px; padding-top:20px; background: #f4f1ed;">OPERABLE</th>
                    	<th style="height: 61px; padding-top:20px; background: #f4f1ed;">CALIF_CONTACTO</th>
                        <th style="height: 61px; padding-top:20px; background: #f4f1ed;">NOMBRE_BDD</th>
                    </tr>
                </thead>

                    <tr>
                    	<td style="height: 61px; padding-top:20px; background: #f4f1ed;">POLIZA</td>
                        <td style="height: 61px; padding-top:20px; background: #f4f1ed;">OPERABLE</td>
                        <td style="height: 61px; padding-top:20px; background: #f4f1ed;">CALIF_CONTACTO</td>
                        <td style="height: 61px; padding-top:20px; background: #f4f1ed;">NOMBRE_BDD</td>
                  	</tr>

                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

@stop