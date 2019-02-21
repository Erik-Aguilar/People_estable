@extends('layout.tmpos.basic')

@section('content')
<?php
$value = Session::all();
#dd($value);
#echo gettype($value);
#$dat=json_decode($value);
#echo "lalala".$dat->user;
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Estado del Agente  | {{$value['nombre_completo']}}</h3>
            </div>
            <div class="panel-body">
            <div style="text-align:right">
            <table class="table table-bordered" style="text-align:right">
                <thead>
                    <tr>
                        <th style="text-align:center">
                            <p>Estado Actual</p>
                        </th>
                        <th style="text-align:center">
                            <label >Tipos de estado</label> 
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="6" style="text-align:center">
                            <label id="mensaje" ></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label id="test">Salida al tocador</label>
                            <button class="btn btn-info glyphicon glyphicon-tree-deciduous" id="bathroom"></button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                          <label>Break</label>
                            <button class="btn btn-info glyphicon glyphicon-time" id="break"></button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Validacion</label>
                            <a href='{{asset("/tm/pos/estadoAgente/downval")}}' class="btn btn-info glyphicon glyphicon-tree-deciduous" id="bathroom"></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Retroalimentacion</label>
                            <button class="btn btn-info glyphicon glyphicon glyphicon-education" id="retroalimentacion"></button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>llamadaOutbound</label>
                            <button class="btn btn-info glyphicon glyphicon-earphone" id="llamada"></button>
                        </td>
                    </tr>
                </tbody>
                

            </table>
                
            </div>
            </div>
        </div>
    </div>
</div>



<script>
        document.getElementById('bathroom').disabled=true;
        document.getElementById('break').disabled=true;
        //document.getElementById('validacion').disabled=true;
        document.getElementById('retroalimentacion').disabled=true;
        document.getElementById('llamada').disabled=true;
        document.getElementById('mensaje').innerHTML="En Validacion";
</script>

@endsection

<script>
    if (typeof (EventSource) !== "undefined") {
        var source = new EventSource(" {{ url('eventos/pos/val9') }}");
        var pass = 'Password: {{ Form::password("password","",array("required" => "required")) }}';
        source.onmessage = function (event) {
            var datos =$.parseJSON(event.data);
            //alert(datos.validacion);
            if (datos.validacion > 0) {
                $("#semaforo").css("color", "green");
                $("#semaforo").css("background", "green");
                $("#semaforo").val(1);
                // $("#pass").html('');
            } else {
                // $("#pass").html(pass);
                $("#semaforo").css("color", "red");
                $("#semaforo").css("background", "red");
                $("#semaforo").val(0);
            }

        };
    } else {
        document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
    }
</script>
