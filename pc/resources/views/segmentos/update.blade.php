@extends('layout.admin.admin')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'SegmentosController@EditarSegmento',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=>'formulario'
                            ]) }}


                <div class="form-group">
                    {{ Form::label('Segmentos','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('segmento', $cont,
                        $segmento[0]->segmento, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'sup']  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Posicion Inicial','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::number('p_inicial',$segmento[0]->pos_inicial,array('class'=>"form-control")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Posicion Final','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::number('p_final',$segmento[0]->pos_final,array('class'=>"form-control")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('break','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::time('hora',$segmento[0]->break,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Supervisor','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('supervisor',$supervisores,
                        $segmento[0]->supervisor, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Validador','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('validador',$validadores,
                        $segmento[0]->validador, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Analista de Calidad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('analistaCalidad',$analistaCalidad,
                        $segmento[0]->analista_calidad, ['class'=>"form-control", 'placeholder'=>"",'id'=>'analista']  ) }}
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
