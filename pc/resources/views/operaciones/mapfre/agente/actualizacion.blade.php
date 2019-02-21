@extends('layout.mapfre.agente')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Agente</h3>
            </div>

            <div class="panel-body">

                {{ Form::open(['action' => 'Mapfre2Controller@Salvar',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="hidden">

                </div>
                <div class="form-group">
                    {{ Form::label('Poliza','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('poliza',$base[0]->poliza,array('class'=>"form-control", 'placeholder'=>"", 'readonly'=>'')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Cuenta','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('cuenta',$base[0]->cuenta,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Nombre','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('nombre',$base[0]->nombre,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Calle','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('calle',$base[0]->calle,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Colonia','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('colonia',$base[0]->colonia,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Poblacion','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('poblacion',$base[0]->poblacion,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                      {{ Form::label('CP','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('cp',$base[0]->cp,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Estado','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('estado',$base[0]->estado,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Telefono casa','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('tel_casa',$base[0]->tel_casa,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Telefono oficina','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('tel_oficina',$base[0]->tel_oficina,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Celular personal','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('cel_personal',$base[0]->cel_personal,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Celular trabajo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('cel_trabajo',$base[0]->cel_trabajo,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Fecha de nacimiento','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::date('fecha_nacimiento',$base[0]->fecha_nacimiento,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Rango de edad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('rango_edad', [
                      '0' => '0',
                      'De 18 a 25' => 'De 18 a 25',
                      'De 26 a 35' => 'De 26 a 35',
                      'De 36 a 45'=>'De 36 a 45',
                      'De 46 a 55'=>'De 46 a 55',
                      'De 56 a 60'=>'De 56 a 60',
                      'De 56 a 65'=>'De 56 a 65',
                      'Mayor a 60'=>'Mayor a 60',
                      'Mayor a 65'=>'Mayor a 65'],
                      $base[0]->rango_edad, ['required'=>'required','id'=>'tipoNewNumber', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Email','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('mejor_email',$base[0]->mejor_email,array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>


                <div class="form-group" id="codificacion_telcasa" >
                  <!-- style="display:none;" -->
                    {{ Form::label('Codificación','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('estatus', [
                      '0' => 'Ventas - Aprobadas por Calidad',
                      '1' => 'No volver a llamar-Cliente molesto',
                      '2' => 'Ya le ofrecieron mismo producto',
                      '3' => 'Cliente con problemas económicos',
                      '4' => 'Cuenta con producto similar',
                      '5' => 'No tiene servicio de esta compañia',
                      '6' => 'Mala experiencia con esta compañia',
                      '7' => 'Cancelara servicio de esta compañia',
                      '8' => 'Cliente desconfia del producto',
                      '9' => 'Cliente Mayor-No entiende',
                      '10' => 'No autoriza dar información',
                      '11' => 'Cliente Interesado-Lo pensara',
                      '12' => 'Venta rechazo por Calidad',
                      '14' => 'No se encuentra llamar después',
                      '13' => 'No tiene tiempo llamar después',
                      '15' => 'Llamada Cortada-Colgaron',
                      '16' => 'Ilocalizable-Fuera de horario',
                      '17' => 'Cliente Discapacitado',
                      '18' => 'Cliente Fallecido',
                      '19' => 'Teléfono Equivocado-No vive ahí',
                      '20' => 'Teléfono de empresa sin extensión',
                      '21' => 'Tono de fax',
                      '22' => 'Teléfono no existe',
                      '23' => 'No contestan',
                      '24' => 'Teléfono ocupado',
                      '25' => 'Tel suspendido-Fuera de Servicio',
                      '26' => 'Maquina contestadora',
                      '27' => 'Buzón celular',
                      '28' => 'No Conectado (Predictivo)',
                      '29' => 'Teléfonos Agotados Sin Contacto'],
                      null, ['required'=>'required','id'=>'codificacion_telcasa_form', 'class'=>"form-control", 'placeholder'=>"", "onchange"=>""]  ) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Observaciones','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('observaciones','',array('class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::submit('Enviar') }}
                    </div>
                </div>


                {{ Form::close() }}


              </div>
        </div>
    </div>
</div>

@stop
@section('content2')
@stop
