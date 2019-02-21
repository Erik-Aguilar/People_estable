@extends($menu)
@section('content')
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tickets levantados</h3>
            </div>
            <div class="panel-body">
                <div class="zui-wrapper">
                    <div class="zui-scroller">
                        <table class="zui-table table table-bordered">
                            <thead>

                                <tr>
                                    <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">N° de Ticket</th>
                                    <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Titulo de petición</th>
                                    <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Área</th>
                                    <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Estatus</th>
                                    <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Fecha creada</th>
                                    <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Ultima Actualizacion</th>
                                    <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Encargado</th>
                                    <th rowspan="2" style="height: 61px; padding-top:20px; background: #f4f1ed;">Asignado</th>
                                </tr>
                            </thead>

                            @foreach($valores as $key => $values)
                            <tr id="{{$values -> id}}"  onclick="move(this);" onMouseOver="highlightBG(this, '#A9E2F3');highlightNext(this, 'red')" 
                                onMouseOut="highlightBG(this, 'white');highlightNext(this, 'black')" >
                                <td  class="center">{{ $values -> id}}</td>
                                <!--<a href="{{ url('VerSistemaTicket/'.$values -> id) }}">{{ $values -> id}}</a>-->
                                <td style="text-align: center;"> {{$values -> titulo}} </td>
                                <td style="text-align: center;"> {{$values -> divicion}} </td>
                                <td style="text-align: center;"> {{$values -> estatus}} </td>
                                <td style="text-align: center;"> {{$values -> hora_envio}} </td>
                                <td style="text-align: center;"> {{$values -> hora_actua}} </td>
                                <td style="text-align: center;"> {{$values -> encargado}} </td>
                                <td style="text-align: center;"> {{$values -> asignado}} </td>
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

<script>
                                    function move(td) {
                                        window.location.href = "VerSistemaTicket/" + td.id;

                                        console.log(td.id);
                                    }
                                    function highlightNext(element, color) {
                                        var next = element;
                                        do {
                                            next = next.nextSibling;
                                        } while (next && !('nodeName' in next && next.nodeName === 'TD'));
                                        if (next) {
                                            next.style.color = color;
                                        }
                                    }

                                    function highlightBG(element, color) {
                                        element.style.backgroundColor = color;
                                    }
</script>

@stop