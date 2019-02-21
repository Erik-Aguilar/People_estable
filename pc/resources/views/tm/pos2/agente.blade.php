@extends('layout.tmpos.basic')

@section('content')


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Encuesta</h3>
            </div>
            <div class="panel-body">

                <!--<form class="form-horizontal">-->
                {{ Form::open(['action' => 'TmVentasController@PosVenta',
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
                    {{ Form::label('DN','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('dn','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('CURP','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('curp','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Referencia 1','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('r1','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Referencia 2','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('r2','',array( 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Extensión','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('ext','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
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
