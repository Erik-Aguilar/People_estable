@extends('layout.bo.jefebo')
@section('content')
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte Marcación {{$proc}}</h3>
            </div>
            <div class="panel-body">
              <div class="zui-wrapper">
                <div class="zui-scroller">
                <table class="zui-table table table-bordered">
                <thead>
                    
                	<tr>
                		<th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;"></th>
                		<th colspan="6" style="height: 61px; padding-top:20px; background: #f4f1ed;">{{$repBo[0] -> fecha}}</th>
                		<th colspan="6" style="height: 61px; padding-top:20px; background: #f4f1ed;">{{$repBo[1] -> fecha}}</th>
                		<th colspan="6" style="height: 61px; padding-top:20px; background: #f4f1ed;">{{$repBo[2] -> fecha}}</th>
                		
                    	
                    </tr>
                    
                </thead>
                <tbody>
					<tr>
    					<td>Registros pendientes</td>
    					<td colspan="6">{{$repBo[0] -> pendientes}}</td>
    					<td colspan="6">{{$repBo[1] -> pendientes}}</td>
    					<td colspan="6">{{$repBo[2] -> pendientes}}</td>
					</tr>
					<tr>
                		<th  style="height: 61px; padding-top:20px; background: #f4f1ed;"></th>
                    	<th colspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;"># de registros</th>
                    	<th colspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Porcantaje del total</th>
                    	<th colspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Promedio del registro</th>

                    	<th colspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;"># de registros</th>
                    	<th colspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Porcantaje del total</th>
                    	<th colspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Promedio del registro</th>

                    	<th colspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;"># de registros</th>
                    	<th colspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Porcantaje del total</th>
                    	<th colspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Promedio del registro</th>
                    </tr>
                    <tr>
    					<td>DN</td>
    					<td colspan="2">{{$repBo[0] -> total}}</td>
    					<td colspan="2">{{$repBo[0] -> porTotal}}</td>
    					<td colspan="2"></td>

    					<td colspan="2">{{$repBo[1] -> total}}</td>
    					<td colspan="2">{{$repBo[1] -> porTotal}}</td>
    					<td colspan="2"></td>

    					<td colspan="2">{{$repBo[2] -> total}}</td>
    					<td colspan="2">{{$repBo[2] -> porTotal}}</td>
    					<td colspan="2"></td>
					</tr>
					<tr>
    					<td>DN + REF 1</td>
    					<td colspan="2">{{$repBo[0] -> ref1}}</td>
    					<td colspan="2">{{$repBo[0] -> porRef1}}</td>
    					<td colspan="2"></td>

    					<td colspan="2">{{$repBo[1] -> ref1}}</td>
    					<td colspan="2">{{$repBo[1] -> porRef1}}</td>
    					<td colspan="2"></td>

    					<td colspan="2">{{$repBo[2] -> ref1}}</td>
    					<td colspan="2">{{$repBo[2] -> porRef1}}</td>
    					<td colspan="2"></td>
					</tr>

					<tr>
    					<td>DN + REF 2</td>
    					<td colspan="2">{{$repBo[0] -> ref2}}</td>
    					<td colspan="2">{{$repBo[0] -> porRef2}}</td>
    					<td colspan="2"></td>

    					<td colspan="2">{{$repBo[1] -> ref2}}</td>
    					<td colspan="2">{{$repBo[1] -> porRef2}}</td>
    					<td colspan="2"></td>

    					<td colspan="2">{{$repBo[2] -> ref2}}</td>
    					<td colspan="2">{{$repBo[2] -> porRef2}}</td>
    					<td colspan="2"></td>
					</tr>
					<tr>
    					<td>No marcado</td>
    					<td colspan="2"></td>
    					<td colspan="2"></td>
    					<td colspan="2"></td>

    					<td colspan="2"></td>
    					<td colspan="2"></td>
    					<td colspan="2"></td>

    					<td colspan="2"></td>
    					<td colspan="2"></td>
    					<td colspan="2"></td>
					</tr>
					<tr>
    					<td>Total</td>
    					<td colspan="2">{{$repBo[0] -> total}}</td>
    					<td colspan="2">{{$repBo[0] -> TotalPorc}}</td>
    					<td colspan="2"></td>

    					<td colspan="2">{{$repBo[1] -> total}}</td>
    					<td colspan="2">{{$repBo[1] -> TotalPorc}}</td>
    					<td colspan="2"></td>

    					<td colspan="2">{{$repBo[2] -> total}}</td>
    					<td colspan="2">{{$repBo[2] -> TotalPorc}}</td>
    					<td colspan="2"></td>
					</tr>
					
				</tbody>
				
				
                <thead>
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