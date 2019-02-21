@extends("layout.calidad.prepago.prepago")
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                {{ Form::open(['action' => 'RechazosController@Captura',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=>'formulario'
                            ]) }}


                <div class="form-group">
                    {{ Form::label('DN *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('dn',$bo[0]['dn'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"","readOnly"=>'readOnly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Fecha de Validación *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::date('fechaVal',date('Y-m-d',strtotime($bo[0]['fecha_val'])),array('required' => 'required','class'=>"form-control","readOnly"=>'readOnly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Operador *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('operadorName',$bo[0]['operador'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"","readOnly"=>'readOnly')) }}
                        <div style="display:none">
                          {{ Form::text('operador',$bo[0]['operador_id'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'display'=>'none')) }}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Validador *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('validadorName',$bo[0]['validador'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"","readOnly"=>'readOnly')) }}
                        <div style="display:none">
                          {{ Form::text('validador',$bo[0]['validador_id'],array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    {{ Form::label('Analista de BO *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('analistaBo',$backO,
                        null, ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>



                <div class="form-group">
                    {{ Form::label('Imputable A: *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('imputable', [
                        'Validador' => 'Validador',
                        'Operador-Validador' => 'Operador, Validador',
                        'Validador-Back-Office' => 'Validador, Back-Office',
                        'Operador' => 'Operador',
                        'BackOffice'=>'BackOffice',
                        'No Aplica'=>'No Aplica'],
                    null, ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('¿Recuperación Exitosa? *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::select('recuperacion', [
                        'Si' => 'Si',
                        'No' => 'No'],
                    null, ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Nip Proporcionado por Cliente *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                    {{ Form::text('nip',null,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                  </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Comentarios *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::textarea('comentarios','',array('required' => 'required','class'=>"form-control", 'placeholder'=>"")) }}
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

@stop
