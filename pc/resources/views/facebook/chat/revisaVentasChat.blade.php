@extends('layout.tmpre.chatSuper')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Revisar Ventas Facebook Chat </h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Usuario Chat</th>
                            <th>Nombre Cli</th>
                            <th>DN</th>                            
                            <th>Estatus Chat</th>                            
                            <th>Asignar a:</th>
                            <th>Fecha Agenda</th>
                            <th>Hora Agenda</th>
                            <th>Observaciones</th>
                            <th>Enviar</th>

                        </tr>
                    </thead>
                        
                    @foreach($datos as $value)
                        <form method="POST" action="{{ url('guardaRevision') }}">
                            <tbody>
                                <tr>
                                    <td style="display: none;">
                                        <div class="form-group">
                                            <div class="">
                                                {{ Form::text('id', $value->id, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="">
                                                {{ Form::text('nombreUsuario', $value->usuariochat, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="form-group">
                                            <div class="">
                                                {{ Form::text('nombreCliente', $value->nombre_cliente, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td> <div class="form-group">
                                        <div class="">
                                            {{ Form::text('telefono', $value->dn, ['class'=>"form-control", 'placeholder'=>"", 'maxlength'=>10]  ) }}
                                        </div>
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="form-group">
                                            <div class="">
                                                {{ Form::select('estatus', [
                                                    'Venta' => 'Venta', 
                                                    'CAC lejano' => 'CAC Lejano',
                                                    'Gestionado por otro Call' => 'Gestionado por otro Call', 
                                                    'Movistar' => 'Movistar',
                                                    'Linea Inactiva' => 'Linea Inactiva',
                                                    'No le interesa' => 'No le Interesa',
                                                    'Reagenda' => 'Reagenda',
                                                    'Plan de Renta' => 'Plan de Renta'
                                                    ],
                                                $value->estatus_chat_res,['class'=>"form-control", 'placeholder'=>""]  ) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="form-group">
                                            <div class="">
                                                    {{ Form::select('agente', $agentes, null, ['class'=>"form-control",'placeholder'=>""]  ) }}
                                            </div>
                                        </div> 
                                    </td>

                                    <td> 
                                        <div class="form-group">
                                            <div class="">
                                                    {{ Form::date('fechaAgenda', null, ['class'=>"form-control",'placeholder'=>""]  ) }}
                                            </div>
                                        </div> 
                                    </td>

                                    <td> 
                                        <div class="form-group">
                                            <div class="">
                                                    {{ Form::time('horaAgenda', null, ['class'=>"form-control",'placeholder'=>""]  ) }}
                                            </div>
                                        </div> 
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="">
                                                {{ Form::textarea('observaciones', $datos[0]->observaciones, [ 'class'=>"form-control", 'placeholder'=>"", 'rows'=>2, 'cols'=>10]  ) }}
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </form>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@stop
