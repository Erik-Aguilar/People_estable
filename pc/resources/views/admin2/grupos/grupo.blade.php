<?php
$user = Session::all();
?>

    @extends('layout.admin.admin')


@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'AdminController@NewEmpleado',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=>'formulario'
                            ]) }}


                            <div class="form-group">
                                {{ Form::label('Campaña','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-10">
                                    {{ Form::select('campaign', [
                                    'TM Prepago' => 'TM Prepago',
                                    'TM Pospago' => 'TM Pospago',
                                    'Inbursa' => 'Inbursa',
                                    'PeopleConnect' => 'PeopleConnect',
                                    'PyMES' => 'PyMES',
                                    'Facebook'=>'Facebook',
                                    'Bancomer'=>'Bancomer',
                                    'Banamex' => 'Banamex'],
                                null, ['class'=>"form-control", 'placeholder'=>"",'id'=>'campaign','onChange'=>'validacion(),ACalidad()']  ) }}
                                </div>
                            </div>


                <div class="form-group">
                    {{ Form::label('Grupo *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('grupo', [
                      'TM Prepago' => 'TM Prepago',
                      'TM Pospago'=>'TM Pospago',
                      'Inbursa' => 'Inbursa',
                      'PeopleConnect' => 'PeopleConnect',
                      'PyMES' => 'PyMES',
                      'Facebook'=>'Facebook'],
                  null, ['class'=>"form-control", 'placeholder'=>"",'id'=>'campaign','onChange'=>'validacion(),ACalidad()']  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Supervisor','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('supervisor', $super,
                    null, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'sup']  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Validador','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('validador',$teamLeader,
                        null, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Analista de Calidad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('analistaCalidad',$analistaCalidad,
                        null, ['class'=>"form-control", 'placeholder'=>"",'id'=>'analista']  ) }}
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

<script type="text/javascript">

</script>

@stop
