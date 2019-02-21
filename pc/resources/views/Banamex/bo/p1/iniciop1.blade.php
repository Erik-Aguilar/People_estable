@extends($menu)
@section('content')

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista Back-Office Banamex</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th> DN </th>
                                        <th> Estatus </th>
                                        <th> Estatus 1 </th>
                                        <th> Estatus 2 </th>
                                        <th> Estatus 3 </th>
                                        <th> Folio </th>
                                        <th> Estatus P1 </th>
                                        <th> Estatus 2 P1 </th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $value)
                                    <tr >
                                        <td> <a href="{{ url('BoBanamexp1/'.$value->v_id)}}"> {{$value->dn}} </a> </td>
                                    <td> {{$value->status}} </td>
                                    <td> {{$value->estatus_bo1}} </td>
                                    <td> {{$value->estatus_bo2}} </td>
                                    <td> {{$value->estatus_bo3}} </td>
                                    <td> {{$value->folio}} </td>
                                    <td> {{$value->estatusp1}} </td>
                                    <td> {{$value->estatus2p1}} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @stop
        @section('content2')

        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <script>
$(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true,
        "order": [[ 3, 'desc' ]]
    });
});
        </script>
    @stop
