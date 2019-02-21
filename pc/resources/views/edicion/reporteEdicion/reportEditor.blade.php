@extends( $menu )
@section('content')
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de edición por editor</h3>
            </div>
            <div class="panel-body">
              <div class="zui-wrapper">
                <div class="zui-scroller">
                <table class="zui-table table table-bordered">
                <thead>

                	<tr>
                    	<th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">NOMBRE DEL EDITOR</th>
                    	<th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">AUDIOS EDITADOS</th>
                    	<th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">CUMPLIMIENTO</th>
                    </tr>
                </thead>

                    @foreach($valores as $key => $values)
                    <tr>
                        <td style="text-align: center;"> {{$values -> nombre_completo}} </td>
                        <td style="text-align: center;"> {{$values -> audios_editados}} </td>
                        <td style="text-align: center;"> {{$values -> cumplimiento}} </td>
                    </tr>
                    @endforeach

                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>   -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>


@stop
