@extends('layout.rep.basic')
@section('content')
<?php
$cont=1;
?>
            <div class="row">
                <div class="col-md-12 ">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Fecha de Ingreso</th>
                                        @while($cont<=$mayor)
                                            <th>{{$cont}}</th>
                                            <?php
                                            $cont++;
                                            ?>
                                        @endwhile
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($array as $valueArray)
                                    <tr>
                                    <td>{{$valueArray[0]}}</td>
                                    <?php 
                                    $cont2=1; 
                                    ?>
                                        @while($cont2<=$mayor)
                                            <td>{{$valueArray[$cont2]}}</td>
                                            <?php $cont2++; ?>
                                        @endwhile
                                    
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
        order:[0,'desc']
    });
});
        </script>
    @stop
