@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Formato de Calidad Audios</h3>
            </div>

            <div class="panel-body">

                {{ Form::open(['action' => 'CalidadMapfreController@GuardaFormatoCalidad',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name' => "formulario"
                            ]) }}

                <div class="row">
                    <div class="col-md-10 col-md-push-2">
                        <h3>
                        </h3>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Campaña','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('campania', [
                      'Mapfre Asistencia' => 'Mapfre Asistencia',
                      'Inbursa Integral' => 'Inbursa Integral',
                      'Vidatel' => 'Vidatel'],
                      '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('DN','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('dn','asd',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Fecha Venta','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                         {{ Form::date('fechaVenta','',array('class'=>"form-control", 'required' => 'required' , 'placeholder'=>"********")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Auditor','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::text('auditor',$id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Nombre Editor','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('editor', $operadores,
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'id'=>'operador']  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Saludo Institucional','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('saludo', [
                      'Si' => 'Si',
                      'No' => 'No'],
                      '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Manejo de Script','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('script', [
                      'Si' => 'Si',
                      'No' => 'No'],
                      '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Manejo de Objeciones','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('objeciones', [
                      'Si' => 'Si',
                      'No' => 'No'],
                      '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Cierre de venta','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('cierre', [
                      'Si' => 'Si',
                      'So' => 'No'],
                      '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Despedida Institucional','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('despedida', [
                      'Si' => 'Si',
                      'No' => 'No'],
                      '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Error Critico','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('error', [
                      'Si' => 'Si',
                      'No' => 'No'],
                      '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Motivos de Error Critico','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                      {{ Form::select('errorMotivo', [
                      'Corte evidente en audio' => 'Corte evidente en audio',
                      'Frases informativas sin editar' => 'Frases informativas sin editar',
                      'Coherencia en la llamada' => 'Coherencia en la llamada',
                      'Espacios de conversacion' => 'Espacios de conversacion'],
                      '', ['class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Observaciones','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-10">
                        {{ Form::text('observaciones','',array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                    </div>
                </div>
                {{ Form::close() }}


        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

@stop
