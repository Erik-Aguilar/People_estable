<?php
$user = Session::all();
?>

@extends($menu)

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tickets</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'TicketController@NuevoTicket',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=>'formulario'
                            ]) }}

                <div class="panel-body">
                    <div class="form-group">
                        <h3 class="panel-title">
                            {{ Form::label('',$user['nombre_completo'],array('class'=>"col-sm-2 control-label")) }}
                        </h3>

                        <h5 class="panel-title">
                            {{ Form::label('',$user['user'],array('class'=>"col-sm-2 control-label")) }}
                        </h5>

                        <h5 class="panel-title">
                            {{ Form::label('',$user['area'],array('class'=>"col-sm-2 control-label")) }}
                        </h5>
                        <h5 class="panel-title">
                            {{ Form::label('',$user['puesto'],array('class'=>"col-sm-2 control-label")) }}
                        </h5>
                    </div>
                    <hr/>

                    <div class="form-group">
                        {{ Form::label('Titulo *','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-10">
                            {{ Form::text('titulo','',array('id'=>'titu','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>

                    <br/>

                    <div class="form-group">
                        {{ Form::label('Área','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-10">
                            {{ Form::select('divicion',[
                            'Desarrollo' => 'Desarrollo',
                            'Soporte Tecnico' => 'Soporte Tecnico',
                            'Operaciones' => 'Operaciones'
                            ],
                        null, [ 'id'=>'areas','class'=>"form-control", 'placeholder'=>""]  ) }}
                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        {{ Form::label('Descripción','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-10">
                            {{ Form::textarea('descripcion','',array('id'=>'descrip','class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            {{ Form::submit('Enviar',['class'=>"btn btn-default","onClick"=>"test()"]) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                    <script>

                        function test() {
                            //$("#titu").val();
                            //console.log($("#titu").val());
                            //console.log($("#areas").val());
                            //console.log($("#descrip").val());
                            //console.log('{{$user['nombre_completo']}}');

                            //, nombre_completo:'{{$user['nombre_completo']}}', num_empleado:{{$user['user']}},area:{{$user['area']}},puesto:{{$user['puesto']}}
                            $.ajax({
                            type: "POST",
                                    url: "http://peopleconnect.com.mx/desarrollo/salomon/ticket.php",
                                    data: {titulo:$("#titu").val(), areaTicket:$("#areas").val(), descripcion:$("#descrip").val(), nombre_completo:'{{$user['nombre_completo']}}', num_empleado:'{{$user['user']}}', area:'{{$user['area']}}', puesto:'{{$user['puesto']}}', }
                            ,
                            success: function (data) {
                                console.log(data);
                                }
                            }
                            );
                        }

                    </script>

                </div>
            </div>
        </div>
    </div>

    @stop
