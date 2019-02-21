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
                                {{ Form::label('Información del Ticket','',array('class'=>"col-sm-2 control-label")) }}
                            </div>
                            </thead>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Titulo</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->titulo,'') }}</td>
                            </tr>
                            <tr>
                                <td class="zui-table table table-bordered" style="width: 6%; padding-right:20px; background: #f4f1ed;" align="right">Área asignada</td>
                                <td class="zui-table table table-bordered" style="width: 25%; padding-left:20px; background: #f4f1ed;">{{ Form::label($valores[0]->divicion,'') }}</td>
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
                        {{ Form::label('Datos internos','',array('class'=>"col-sm-2 control-label")) }}
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('N° de solicitud: ','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::text('id',$valores[0]->id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Encargado: ','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::select('encargado', $encargado,
                                   $valores[0]->encargado, ['required'=>'required', 'id'=>'encar','placeholder'=>"", 'class'=>"form-control", "onChange"=>"encarga()"]  ) }}
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
                            {{ Form::label('Tiempo estimado*: ','',array('class'=>"col-sm-2 control-label")) }}
                           <!--- <div class="col-sm-10">
                                {{ Form::text('tiempo_estimado',$valores[0]->tiempo_estimado,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                                <input type="time" name="time" />
                            </div>-->
                           {{ Form::label('Días ','',array('class'=>"col-sm-1 control-label")) }}
                            <div class="col-sm-2">
                                {{ Form::select('Dia', [
                                    '0' => '0',
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',
                                    '5' => '5',
                                    '6' => '6',
                                    '7' => '7',
                                    '8' => '8',
                                    '9' => '9',
                                    '10' => '10',
                                    '11' => '11',
                                    '12' => '12',
                                    '13' => '13',
                                    '14' => '14',
                                    '15' => '15',
                                    '16' => '16',
                                    '17' => '17',
                                    '18' => '18',
                                    '19' => '19',
                                    '20' => '20',
                                    '21' => '21',
                                    '22' => '22',
                                    '23' => '23',
                                    '24' => '24',
                                    '25' => '25',
                                    '26' => '26',
                                    '27' => '27',
                                    '28' => '28',
                                    '29' => '29',
                                    '30' => '30',
                                    '31' => '31'],
                                    $valores[0]->tiempo_dias, ['class'=>"form-control"]  ) }}
                            </div>
                           
                           {{ Form::label('Horas ','',array('class'=>"col-sm-1 control-label")) }}
                            <div class="col-sm-2">
                                {{ Form::select('horas', [
                                    '0' => '0',
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',
                                    '5' => '5',
                                    '6' => '6',
                                    '7' => '7',
                                    '8' => '8',
                                    '9' => '9',
                                    '10' => '10',
                                    '11' => '11',
                                    '12' => '12',
                                    '13' => '13',
                                    '14' => '14',
                                    '15' => '15',
                                    '16' => '16',
                                    '17' => '17',
                                    '18' => '18',
                                    '19' => '19',
                                    '20' => '20',
                                    '21' => '21',
                                    '22' => '22',
                                    '23' => '23',
                                    '24' => '24'],
                                    $valores[0]->tiempo_horas, ['class'=>"form-control"]  ) }}
                            </div>
                            {{ Form::label('Minutos ','',array('class'=>"col-sm-1 control-label")) }}
                            <div class="col-sm-2">
                                {{ Form::select('minu', [
                                    '0' => '0',
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',
                                    '5' => '5',
                                    '6' => '6',
                                    '7' => '7',
                                    '8' => '8',
                                    '9' => '9',
                                    '10' => '10',
                                    '11' => '11',
                                    '12' => '12',
                                    '13' => '13',
                                    '14' => '14',
                                    '15' => '15',
                                    '16' => '16',
                                    '17' => '17',
                                    '18' => '18',
                                    '19' => '19',
                                    '20' => '20',
                                    '21' => '21',
                                    '22' => '22',
                                    '23' => '23',
                                    '24' => '24',
                                    '25' => '25',
                                    '26' => '26',
                                    '27' => '27',
                                    '28' => '28',
                                    '29' => '29',
                                    '30' => '30',
                                    '31' => '31',
                                    '32' => '32',
                                    '33' => '33',
                                    '34' => '34',
                                    '35' => '35',
                                    '36' => '36',
                                    '37' => '37',
                                    '38' => '38',
                                    '39' => '39',
                                    '40' => '40',
                                    '41' => '41',
                                    '42' => '42',
                                    '43' => '43',
                                    '44' => '44',
                                    '45' => '45',
                                    '46' => '46',
                                    '47' => '47',
                                    '48' => '48',
                                    '46' => '49',
                                    '50' => '50',
                                    '50' => '50',
                                    '51' => '51',
                                    '52' => '52',
                                    '53' => '53',
                                    '54' => '54',
                                    '55' => '55',
                                    '56' => '56',
                                    '57' => '57',
                                    '58' => '58',
                                    '59' => '59'],
                                    $valores[0]->tiempo_mins, ['class'=>"form-control"]  ) }}
                            </div>
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
            $("#vob").prop('disabled',false);
            $("#asig").prop('disabled',false);
        } else if ($("#encar").val() == '') {
            $("#estatus").val('Enviado');
            $("#vob").prop('disabled',true);
            $("#asig").prop('disabled',true);
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
</script>

@stop