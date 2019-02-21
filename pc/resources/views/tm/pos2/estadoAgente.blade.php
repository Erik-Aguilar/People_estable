@extends('layout.tmpos.basic')

@section('content')
<?php
$value = Session::all();
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
                            <a href="{{url('/tm/pos/estadoAgente/upbathroom')}}" class="btn btn-info glyphicon glyphicon-tree-deciduous" id="bathroom"></a>
                            <!--<button class="btn btn-info glyphicon glyphicon-tree-deciduous" onclick="window.location.href='/tm/pos/estadoAgente/upbathroom'" id="bathroom"></button>-->
                        </td>
                    </tr>
                    <tr>
                        <td>
                          <label>Break</label>
                          <a id="break" href="{{url('/tm/pos/estadoAgente/upbreak')}}" class="btn btn-info glyphicon glyphicon-tree-deciduous" id="bathroom"></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Validacion</label>
                            <a href="{{url('/tm/pos/estadoAgente/upval')}}" class="btn btn-info glyphicon glyphicon-tree-deciduous" id="val"></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Retroalimentacion</label>
                            <a href="{{url('/tm/pos/estadoAgente/upretro')}}" class="btn btn-info glyphicon glyphicon-tree-deciduous" id="retro"></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>llamadaOutbound</label>
                            <a href="{{url('/tm/pos/estadoAgente/upcall')}}" class="btn btn-info glyphicon glyphicon-tree-deciduous" id="call"></a>
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

<?php
    if($value['bathroom']==1)
    {
?>
        document.getElementById('mensaje').innerHTML="En el tocador";
        document.getElementById('break').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('val').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('retro').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('call').className='btn btn-default glyphicon glyphicon-tree-deciduous';

<?php
    }
?>
<?php
    if($value['Break']==1)
    {
?>
        document.getElementById('mensaje').innerHTML="En Break";
        document.getElementById('bathroom').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('val').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('retro').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('call').className='btn btn-default glyphicon glyphicon-tree-deciduous';
<?php
    }
?>
<?php
    if($value['Val']==1)
    {
?>  
        document.getElementById('mensaje').innerHTML="En Validacion";
        document.getElementById('break').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('bathroom').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('retro').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('call').className='btn btn-default glyphicon glyphicon-tree-deciduous';
<?php
    }
?>
<?php
    if($value['Retro']==1)
    {
?>
        document.getElementById('mensaje').innerHTML="En Retroalimentacion";
        document.getElementById('break').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('val').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('bathroom').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('call').className='btn btn-default glyphicon glyphicon-tree-deciduous';
<?php
    }
?>
<?php
    if($value['Call']==1)
    {
?>
        document.getElementById('mensaje').innerHTML="En llamadaOutbound";
        document.getElementById('break').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('val').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('retro').className='btn btn-default glyphicon glyphicon-tree-deciduous';
        document.getElementById('bathroom').className='btn btn-default glyphicon glyphicon-tree-deciduous';
<?php
    }
?>  
 
</script>

@endsection

<script>
/*    if (typeof (EventSource) !== "undefined") {
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
    }*/
</script>
