@extends('layout.Inbursa.validador')
@section('content')
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de Edición por Avance</h3>
            </div>
            <div class="panel-body">
              <div class="zui-wrapper">
                <div class="zui-scroller">
                <table class="zui-table table table-bordered">
                <thead>
                	<tr>
                    	<th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">FECHA</th>
                    </tr>
                </thead>

                @foreach()
                    <tr>
                        <td style="text-align: center;"> {{}} </td>
                    </tr>

                @endforeach

                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@stop