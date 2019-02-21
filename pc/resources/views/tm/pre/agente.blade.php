@extends('layout.tmpre.basic')

@section('content')


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Encuesta</h3>
            </div>
            <div class="panel-body">

                <!--<form class="form-horizontal">-->
                {{ Form::open(['action' => 'TmVentasController@PreVenta',
                                'method' => 'post',
                                'class'=>"form-horizontal"
                            ]) }}

                <div class="form-group">
                    <div class="col-sm-10">
                        <input type="text"  id="semaforo" name="semaforo" value="" readonly=""
                               style="width: 20px; height: 20px; border-radius: 50%;" />
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Nombre','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Apellido Paterno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('paterno','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Apellido Materno','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('materno','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Fecha','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha','',array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Hora','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::time('hora',null,
                        null, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('DN','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('dn','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                
                <div class="form-group">
                    {{ Form::label('Fecha Nacimiento','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fecha_nacimiento','',array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Lugar de Nacimiento','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                         {{Form::select('state',$states->prepend(''),null,['id'=>'state','class'=>'form-control Fase2','placeholder'=>'Selecciona un estado'])}}
                    </div>
                </div>
                

                <div class="form-group">
                    {{ Form::label('CURP','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('curp','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('NIP','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('nip','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                

                <div class="form-group">
                    {{ Form::label('Referencia 1','',array('class'=>"col-sm-2 control-label")) }}
                </div>
                <div class="form-group">
                    {{ Form::label('Nombre Completo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre_ref1','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Numero de telefono','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::number('numero_ref1',null,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Referencia 2','',array('class'=>"col-sm-2 control-label")) }}
                </div>
                <div class="form-group">
                    {{ Form::label('Nombre Completo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre_ref2','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Numero de telefono','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::number('numero_ref2',null,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection

<script type="text/javascript">

    if (typeof (EventSource) !== "undefined") {
        var source = new EventSource(" {{ url('eventos/pre/valpre') }}");
        var pass = 'Password: {{ Form::password("password","",array("required" => "required")) }}';
        source.onmessage = function (event) {
            //alert(event.data);
            if (event.data > 0) {
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
