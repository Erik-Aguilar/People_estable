<?php
$user = Session::all();
?>

@extends($menu)

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Form::label($valores[0]->id,'') }}  -  {{ Form::label($valores[0]->titulo,'') }}</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(['action' => 'TicketController@SistemaGuardaTicket',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=>'formulario'
                            ]) }}

                <div class="panel panel-default">
                    <div class="panel-body">
                        <table>
                            <thead>
                            <div class="form-group">
                                {{ Form::label('Datos del Solicitante','',array('class'=>"col-sm-2 control-label")) }}
                            </div>
                            </thead>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Nombre</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->nombre_completo,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Núm. de empleado</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->quien_solicita,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Área</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->area,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Puesto</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->puesto,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Campaña</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->campaign,'') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-body">
                        <table>
                            <thead>
                            <div class="form-group">
                                {{ Form::label('Información del proyecto','',array('class'=>"col-sm-2 control-label")) }}
                            </div>
                            </thead>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Titulo</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->titulo,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Campaña</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->campana,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Descripción</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->descripcion,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Fecha / hora</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->hora_envio,'') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        {{ Form::label('Detalles del proyecto','',array('class'=>"col-sm-2 control-label")) }}
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('N° de solicitud: ','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::text('id',$valores[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Asignar: ','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::select('asignado', $sistemas,
                                   $valores[0]->asignado, ['class'=>"form-control",'id'=>'asig', 'placeholder'=>"",'disabled' => 'false']  ) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Estatus: ','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::select('estatus', [
                                    'Enviado' => 'Enviado',
                                    'En_desarollo' => 'En desarrollo',
                                    'Pendiente' => 'Pendiente',
                                    'Finalizado' => 'Finalizado'],
                                    $valores[0]->estatus, ['class'=>"form-control",'readonly'=>'readonly', "id"=>'estatus','disabled' => 'false']  ) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Porcentaje de termino*: ','',array('class'=>"col-sm-2 control-label")) }}
                            <!--- <div class="col-sm-10">
                                 {{ Form::text('tiempo_estimado',$valores[0]->tiempo_estimado,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                                 <input type="time" name="time" />
                             </div>-->
                            <div class="col-sm-2">
                                {{ Form::select('Dia', [
                                    '0%' => '0%',
                                    '5%' => '5%',
                                    '10%' => '10%',
                                    '15%' => '15%',
                                    '20%' => '20%',
                                    '25%' => '25%',
                                    '30%' => '30%',
                                    '35%' => '35%',
                                    '40%' => '40%',
                                    '55%' => '55%',
                                    '60%' => '60%',
                                    '65%' => '65%',
                                    '70%' => '70%',
                                    '75%' => '75%',
                                    '80%' => '80%',
                                    '95%' => '95%',
                                    '100%' => '100%'],
                                    $valores[0]->porcen_termino, ['class'=>"form-control"]  ) }}
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="panel-body">
                                    {{ Form::button('Mostar',['class'=>"btn btn-default","onClick"=>"mostrarFormulario('contenedor')"]) }}
                                    {{ Form::label('Vista (From end)','',array('class'=>"col-sm-2 control-label")) }}
                                </div>
                            </div>
                            <div class="panel-body" style="display:none" id="contenedor">

                                <div class="form-group">
                                    {{ Form::label('Fecha Inicio','',array('class'=>"col-sm-2 control-label")) }}
                                    <div class="col-sm-10">
                                        {{ Form::date('fecha_i','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Fecha Fin','',array('class'=>"col-sm-2 control-label")) }}
                                    <div class="col-sm-10">
                                        {{ Form::date('fecha_f','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********", )) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('estatus','',array('class'=>"col-sm-2 control-label")) }}
                                    <div class="col-sm-10">
                                        {{ Form::select('estatusVista', [
                                    'En_proceso' => 'En proceso',
                                    'terminado' => 'terminado'],
                                    $valores[0]->BoVoSistemas, ['class'=>"form-control",'id'=>'vob', "onChange"=>"bovoSis()"]  ) }}
                                    </div>
                                </div>

                                <div class="zui-scroller">
                                    <table class="zui-table table table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Nombre</th>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Fecha</th>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Hora</th>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Comentarios</th>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Estatus</th>
                                            </tr>
                                        </thead>

                                        @foreach($valores as $key => $values)
                                        <tr>
                                            <td style="text-align: left;"> {{$values -> nombre_completo}} </td>
                                            <td style="text-align: left;"> {{$values -> dia}} </td>
                                            <td style="text-align: left;"> {{$values -> hora}} </td>
                                            <td style="text-align: left;"> {{$values -> comentario}} </td>
                                            <td style="text-align: left;"> {{$values -> estatus}} </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>


                                <div class="form-group">
                                    {{ Form::label('Comentarios','',array('class'=>"col-sm-2 control-label")) }}
                                    <div class="col-sm-10">
                                        {{ Form::textarea('comentario','',array('class'=>"form-control", 'placeholder'=>"")) }}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="panel-body">
                                    {{ Form::button('Mostar',['class'=>"btn btn-default","onClick"=>"mostrarDesarrollo('contDesarollo')"]) }}
                                    {{ Form::label('Desarrollo','',array('class'=>"col-sm-2 control-label")) }}
                                </div>
                            </div>
                            <div class="panel-body" style="display:none" id="contDesarollo">

                                <div class="form-group">
                                    {{ Form::label('Fecha Inicio','',array('class'=>"col-sm-2 control-label")) }}
                                    <div class="col-sm-10">
                                        {{ Form::date('fecha_i','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Fecha Fin','',array('class'=>"col-sm-2 control-label")) }}
                                    <div class="col-sm-10">
                                        {{ Form::date('fecha_f','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********", )) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('estatus','',array('class'=>"col-sm-2 control-label")) }}
                                    <div class="col-sm-10">
                                        {{ Form::select('estatusVista', [
                                    'En_proceso' => 'En proceso',
                                    'terminado' => 'terminado'],
                                    $valores[0]->BoVoSistemas, ['class'=>"form-control",'id'=>'vob', "onChange"=>"bovoSis()"]  ) }}
                                    </div>
                                </div>

                                <div class="zui-scroller">
                                    <table class="zui-table table table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Nombre</th>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Fecha</th>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Hora</th>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Comentarios</th>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Estatus</th>
                                            </tr>
                                        </thead>

                                        @foreach($valores as $key => $values)
                                        <tr>
                                            <td style="text-align: left;"> {{$values -> nombre_completo}} </td>
                                            <td style="text-align: left;"> {{$values -> dia}} </td>
                                            <td style="text-align: left;"> {{$values -> hora}} </td>
                                            <td style="text-align: left;"> {{$values -> comentario}} </td>
                                            <td style="text-align: left;"> {{$values -> estatus}} </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>


                                <div class="form-group">
                                    {{ Form::label('Comentarios','',array('class'=>"col-sm-2 control-label")) }}
                                    <div class="col-sm-10">
                                        {{ Form::textarea('comentario','',array('class'=>"form-control", 'placeholder'=>"")) }}
                                    </div>
                                </div>

                            </div>
                        </div>



                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="panel-body">
                                    {{ Form::button('Mostar',['class'=>"btn btn-default","onClick"=>"mostrarDesarrollo('contDesarollo')"]) }}
                                    {{ Form::label('Prueba','',array('class'=>"col-sm-2 control-label")) }}
                                </div>
                            </div>
                            <div class="panel-body" style="display:none" id="contDesarollo">

                                <div class="form-group">
                                    {{ Form::label('Fecha Inicio','',array('class'=>"col-sm-2 control-label")) }}
                                    <div class="col-sm-10">
                                        {{ Form::date('fecha_i','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********")) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Fecha Fin','',array('class'=>"col-sm-2 control-label")) }}
                                    <div class="col-sm-10">
                                        {{ Form::date('fecha_f','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"********", )) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('estatus','',array('class'=>"col-sm-2 control-label")) }}
                                    <div class="col-sm-10">
                                        {{ Form::select('estatusVista', [
                                    'En_proceso' => 'En proceso',
                                    'terminado' => 'terminado'],
                                    $valores[0]->BoVoSistemas, ['class'=>"form-control",'id'=>'vob', "onChange"=>"bovoSis()"]  ) }}
                                    </div>
                                </div>

                                <div class="zui-scroller">
                                    <table class="zui-table table table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Nombre</th>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Fecha</th>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Hora</th>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Comentarios</th>
                                                <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Estatus</th>
                                            </tr>
                                        </thead>

                                        @foreach($valores as $key => $values)
                                        <tr>
                                            <td style="text-align: left;"> {{$values -> nombre_completo}} </td>
                                            <td style="text-align: left;"> {{$values -> dia}} </td>
                                            <td style="text-align: left;"> {{$values -> hora}} </td>
                                            <td style="text-align: left;"> {{$values -> comentario}} </td>
                                            <td style="text-align: left;"> {{$values -> estatus}} </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>


                                <div class="form-group">
                                    {{ Form::label('Comentarios','',array('class'=>"col-sm-2 control-label")) }}
                                    <div class="col-sm-10">
                                        {{ Form::textarea('comentario','',array('class'=>"form-control", 'placeholder'=>"")) }}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                {{ Form::label('N° de solicitud: ','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-10">
                                    {{ Form::text('id',$valores[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('Asignar: ','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-10">
                                    {{ Form::select('asignado', $sistemas,
                                   $valores[0]->asignado, ['class'=>"form-control",'id'=>'asig', 'placeholder'=>"",'disabled' => 'false']  ) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('Estatus: ','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-10">
                                    {{ Form::select('estatus', [
                                    'Enviado' => 'Enviado',
                                    'En_desarollo' => 'En desarrollo',
                                    'Pendiente' => 'Pendiente',
                                    'Finalizado' => 'Finalizado'],
                                    $valores[0]->estatus, ['class'=>"form-control",'readonly'=>'readonly', "id"=>'estatus','disabled' => 'false']  ) }}
                                </div>
                            </div>

                            <div class="zui-scroller">
                                <table class="zui-table table table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Encargado</th>
                                            <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Fecha</th>
                                            <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Hora</th>
                                            <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Comentario tecnico</th>
                                            <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Comentario al solicitante</th>
                                            <th rowspan="2" style="height: 61px; width:100px; padding-left:10px; background: #f4f1ed;">Estatus</th>
                                        </tr>
                                    </thead>

                                    @foreach($valores as $key => $values)
                                    <tr>
                                        <td style="text-align: left;"> {{$values -> nombre_completo}} </td>
                                        <td style="text-align: left;"> {{$values -> dia}} </td>
                                        <td style="text-align: left;"> {{$values -> hora}} </td>
                                        <td style="text-align: left;"> {{$values -> comentario_tecnico}} </td>
                                        <td style="text-align: left;"> {{$values -> comentarios_solicitante}} </td>
                                        <td style="text-align: left;"> {{$values -> estatus}} </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>

                            @if(session('area')=='Sistemas')
                            <div class="form-group">
                                {{ Form::label('Comentarios del técnico ','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-10">
                                    {{ Form::textarea('comen_tecnico','',array('class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                            </div>
                            @endif

                            @if(session('area')!='Sistemas')
                            <div class="form-group">
                                {{ Form::label('Comentarios del solicitante ','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-10">
                                    {{ Form::textarea('comen_solicita','',array('class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                            </div>
                            @endif

                            <div class="form-group">
                                {{ Form::label('VoBo','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-10">
                                    {{ Form::select('BoVoSistemas', [
                                    'No' => 'No',
                                    'Si' => 'Si'],
                                    $valores[0]->BoVoSistemas, ['class'=>"form-control",'id'=>'vob', "onChange"=>"bovoSis()"]  ) }}
                                </div>
                            </div>


                            <div class="my-rating-8"></div>

                            


                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <script>
        function encarga() {
            console.log($("#encar").val());
            if ($("#encar").val() != '') {
                $("#estatus").val('En_desarollo');
                $("#vob").prop('disabled', false);
                $("#asig").prop('disabled', false);
            } else if ($("#encar").val() == '') {
                $("#estatus").val('Enviado');
                $("#vob").prop('disabled', true);
                $("#asig").prop('disabled', true);
                $("#asig").val('');
            }
        }

        function bovoSis() {
            console.log($("#vob").val());
            if ($("#vob").val() == 'Si') {
                $("#estatus").val('Pendiente');
            } else if ($("#vob").val() == 'No') {
                $("#estatus").val('En_desarollo');

            }
        }

        function mostrarFormulario(id) {
            var contenedor = document.getElementById(id);
            //contenedor.style.display = "block";
            if (contenedor.style.display == "none") {
                contenedor.style.display = "block"
            } else if (contenedor.style.display == "block") {
                contenedor.style.display = "none"
            }
        }

        function mostrarDesarrollo(id) {
            var contDesarollo = document.getElementById(id);
            //contenedor.style.display = "block";
            if (contDesarollo.style.display == "none") {
                contDesarollo.style.display = "block"
            } else if (contDesarollo.style.display == "block") {
                contDesarollo.style.display = "none"
            }
        }

        $(".my-rating-8").starRating({
  useFullStars: true
});


    </script>
    @stop