@extends('layout.tmpre.basic')
@section('content')
<div class="row">
    <div class="">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Numero Asignados Facebook Chat: {{ session('user') }} {{ session('nombre') }} </h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Nombre FB</th>
                            <th>Numero</th>
                            <th>Estatus Operador</th>
                            <th>Agendada para</th>
                            <th>Fecha Ingreso</th>
                            <th>Fecha Actualizacion</th>
                            <th>Enviar</th>
                        </tr>
                    </thead>

                @foreach($datos as $value)
                    <form method="POST" action="{{ url('guardaCambiosChat') }}" name="formulario">
                        <tbody>
                                @if($value->estatus_chat_res == "Venta" || $value->estatus_chat_res == "CAC Lejano" || $value->estatus_chat_res == "Linea Inactiva" || $value->estatus_operador == "Venta" || $value->estatus_operador == "CAC Lejano" || $value->estatus_operador == "Linea Inactiva" || $value->estatus_operador == "Movistar" )
                                    
                                @else
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
                                                    {{ Form::text('nombreChat', $value->usuariochat, ['class'=>"form-control", 'placeholder'=>"", 'readonly'=>"readonly"]  ) }}
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group">
                                                <div class="">
                                                    {{ Form::text('telefono', $value->dn, ['class'=>"form-control", 'placeholder'=>"", 'maxlength'=>"10", 'readonly'=>"readonly"]  ) }}
                                                </div>
                                            </div>
                                        </td>

                                        <td> 
                                            <div class="form-group">
                                                <div class="">
                                                    {{ Form::select('estatus', [
                                                        'Contacto' => 'Contacto',
                                                        'No Contacto' => 'No Contacto'],
                                                    $value->estatus1,['class'=>"form-control", 'placeholder'=>"", 'onchange'=>'LlenarSelect()']  ) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="">
                                                    {{ Form::select('motivo', [
                                                        'Movistar' => 'Movistar',
                                                        'No le Interesa' => 'No le Interesa',
                                                        'Reagenda' => 'Reagenda',
                                                        'Plan de Renta' => 'Plan de Renta',
                                                        'Venta' => 'Venta',
                                                        'CAC Lejano' => 'CAC Lejano',
                                                        'Buzon' => 'Buzon',
                                                        'No Contesta' => 'No Contesta',
                                                        'Fuera de Servicio' => 'Fuera de Servicio',
                                                        'Linea Inactiva' => 'Linea Inactiva'
                                                    ] ,$value->estatus_operador,['class'=>"form-control", 'placeholder'=>"",'id'=>'motivo','onchange'=>'llenarReagenda()']  ) }}
                                                </div>
                                            </div>

                                            <div style='display: none;' id='reagenda'>
                                                <div class="form-group">
                                                    {{ Form::label('Fecha Agenda','',array('class'=>"control-label")) }}
                                                    {{ Form::date('fechaAgenda','',array('class'=>"form-control", "id"=>"fechaAgenda")) }}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('Hora Agenda','',array('class'=>"control-label")) }}
                                                    {{ Form::time('horaAgenda','',array('class'=>"form-control", "id"=>"horaAgenda")) }}
                                                </div>
                                            </div>
                                        </td>

                                        <td> 
                                            <div class="form-group">
                                                <div class="">
                                                    {{ Form::text('fechaAge', $value->fecha_agenda,['class'=>"form-control", 'placeholder'=>""]  ) }}

                                                    {{ Form::time('tiem', $value->hora_agenda,['class'=>"form-control", 'placeholder'=>""]  ) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td> 
                                            <div class="form-group">
                                                <div class="">
                                                    {{ Form::text('fecha', $value->fecha, ['class'=>"form-control", 'placeholder'=>"", 'readonly'=>"readonly"]  ) }}
                                                </div>
                                            </div>
                                        </td>

                                        <td> 
                                            <div class="form-group">
                                                <div class="">
                                                    {{ Form::text('fecha', $value->updated_at, ['class'=>"form-control", 'placeholder'=>"", 'readonly'=>"readonly"]  ) }}
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

                                @endif
                            
                        </tbody>
                    </form>
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    /*
    function LlenarSelect(){
        var listdesp = document.forms.formulario.estatus.selectedIndex;
        //alert(list)
        console.log(listdesp);
        console.log(formulario.motivo);
        console.log('asd');
        
        
        
        //formulario.motivo.length = 0;
        if (listdesp == 1)
            ListaDes1();
        if (listdesp == 2)
            ListaDes2();
    }

    function ListaDes1() {
        opcion1 = new Option("Movistar", "Movistar");
        opcion2 = new Option("No le interesa", "No le interesa");
        opcion3 = new Option("Reagenda", "Reagenda");
        opcion4 = new Option("Plan de Renta", "Plan de Renta");
        opcion5 = new Option("Venta", "Venta");
        opcion6 = new Option("CAC Lejano", "Movistar");
        opcion7 = new Option("Reagenda", "Reagenda");

        document.forms.formulario.motivo.options[1] = opcion1;
        document.forms.formulario.motivo.options[2] = opcion2;
        document.forms.formulario.motivo.options[3] = opcion3;
        document.forms.formulario.motivo.options[4] = opcion4;
        document.forms.formulario.motivo.options[5] = opcion5;
        document.forms.formulario.motivo.options[6] = opcion6;
        document.forms.formulario.motivo.options[7] = opcion7;
    }
    function ListaDes2() {
        opcion0 = new Option("Buzón", "Buzón");
        opcion1 = new Option("No contesta", "No contesta");
        opcion2 = new Option("Fuera de Servicio", "Fuera de Servicio");
        opcion3 = new Option("Linea Inactiva", "Linea Inactiva");
        

        document.forms.formulario.motivo.options[0] = opcion0;
        document.forms.formulario.motivo.options[1] = opcion1;
        document.forms.formulario.motivo.options[2] = opcion2;
        document.forms.formulario.motivo.options[3] = opcion3;
    }   


*/



    function llenarReagenda(){
        console.log($('#motivo').val());
        if ($('#motivo').val() == 'Reagenda'){
            
            $('#reagenda').attr("style", '');
            $("#fechaAgenda").prop('required', true);
            $("#horaAgenda").prop('required', true);

        }else{

            $('#reagenda').attr("style", 'display:none');
            $("#fechaAgenda").prop('required', false);
            $("#horaAgenda").prop('required', false);
        }
    }

</script>


@stop
