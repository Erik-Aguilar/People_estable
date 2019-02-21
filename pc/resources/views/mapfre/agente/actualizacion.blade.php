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
                      {{ Form::text('nombre',$base[0]->nombre,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'')) }}
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
                <div class="form-group">
                    {{ Form::label('Estado civil de edad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('estado_civil', [
                      'SOLTERO' => 'SOLTERO',
                      'CASADO' => 'CASADO',
                      'VIUDO' => 'VIUDO',
                      'DIVORCIADO' => 'DIVORCIADO',
                      'UNION LIBRE' => 'UNION LIBRE'],
                      null, ['id'=>'tipoNewNumber', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                    </div>
                </div>


                <div class="form-group" id="codificacion_telcasa" >
                  <!-- style="display:none;" -->
                    {{ Form::label('Codificación','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('estatus', [
                      'Contacto Efectivo - Actualización' => 'Contacto Efectivo - Actualización',
                      'Contacto Efectivo - No Actualización' => 'Contacto Efectivo - No Actualización',
                      'Contacto Remarcaje' => 'Contacto Remarcaje',
                      'Contacto No Efectivo' => 'Contacto No Efectivo',
                      'No Contacto' => 'No Contacto',
                      'No Contacto Remarcaje' => 'No Contacto Remarcaje'
                      ],
                      null, ['required'=>'required','id'=>'estatus', 'class'=>"form-control", 'placeholder'=>"", "onchange"=>""]  ) }}
                    </div>
                </div>
                <div class="form-group" id="codificacion_telcasa" >
                  <!-- style="display:none;" -->
                    {{ Form::label('Codificación dos','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('estatus_dos', [],
                      null, ['required'=>'required','id'=>'estatus_dos', 'class'=>"form-control", 'placeholder'=>"", "onchange"=>""]  ) }}
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
<script type="text/javascript">
  $("#estatus").on("change", sub);

  function sub() {
    var st = $("#estatus").val();

    if(st=='Contacto Efectivo - Actualización'){
        $("#estatus_dos").html("<option value=''></option>"+
        "<option value='Actualización-Completa'>Actualización-Completa</option>"+
        "<option value='Actualización-Parcial'>Actualización-Parcial</option>");
    }
    else if (st=='Contacto Efectivo - No Actualización') {
      $("#estatus_dos").html("<option value=''></option>"+
      "<option value='No autoriza dar informacion'>No autoriza dar informacion</option>"+
      "<option value='No volver a llamar-Cliente molesto'>No volver a llamar-Cliente molesto</option>"+
      "<option value='No tiene servicio de esta compania'>No tiene servicio de esta compania</option>"+
      "<option value='Mala experiencia con esta compania'>Mala experiencia con esta compania</option>"+
      "<option value='Cancelara servicio de esta compania'>Cancelara servicio de esta compania</option>"+
      "<option value='Cliente Mayor-No entiende'>Cliente Mayor-No entiende</option>");
    }else if (st=='Contacto Remarcaje') {
      $("#estatus_dos").html("<option value=''></option><option value='No se encuentra llamar despues'>No se encuentra llamar despues</option>"+
      "<option value='No tiene tiempo llamar despues'>No tiene tiempo llamar despues</option>"+
      "<option value='Llamada Cortada-Colgaron'>Llamada Cortada-Colgaron</option>"+
      "<option value='Ilocalizable-Fuera de horario'>Ilocalizable-Fuera de horario</option>");
    }
    else if (st=='Contacto No Efectivo') {
      $("#estatus_dos").html("<option value=''><option value='Cliente Discapacitado'>Cliente Discapacitado</option>"+
      "<option value='Cliente Fallecido'>Cliente Fallecido</option>"+
      "<option value='Telefono Equivocado-No vive ahí'>Telefono Equivocado-No vive ahí</option>");
    }
    else if (st=='No Contacto') {
      $("#estatus_dos").html("<option value=''><option value='Tono de fax'>Tono de fax</option>"+
      "<option value='Telefono no existe'>Telefono no existe</option>");
    }
    else if (st=='No Contacto Remarcaje') {
      $("#estatus_dos").html("<option value=''><option value='No contestan'>No contestan</option>"+
      "<option value='Telefono ocupado'>Telefono ocupado</option>"+
      "<option value='Tel suspendido-Fuera de Servicio'>Tel suspendido-Fuera de Servicio</option>"+
      "<option value='Maquina contestadora'>Maquina contestadora</option>"+
      "<option value='Buzon celular'>Buzon celular</option>");
    }
    else {
      $("#estatus_dos").html("");
    }

    //$("#subcategoria").html("");
    //$("#subcategoria").html("");
  }

</script>
@stop
