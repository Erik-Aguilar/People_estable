@extends('layout.InbursaVidatel.validador.validador')
@section('content')
<?php
$value = Session::all();
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Validacion Inbursa  | {{$value['nombre_completo']}}</h3>
            </div>
            <div class="panel-body">
            {{ Form::open(['action' => 'InbursaVidatelController@UpdateFromularioInbVidatel',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name' => "formulario"
                            ]) }}

                            <div class="form-group">
                                  {{ Form::label('Folio','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::text('id',$datos[0]->id,array( 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                  </div>
                              </div>

                              <div class="form-group">
                                  {{ Form::label('Telefono','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::text('telefono',$datos[0]->telefono,array('class'=>"form-control", 'placeholder'=>"",'id'=>'telefono','maxlength'=>'10','minlength'=>'10')) }}
                                  </div>
                              </div>

                              <div class="form-group">
                                  {{ Form::label('apellido paterno','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::text('ap_paterno',$datos[0]->ap_paterno,array('class'=>"form-control",'id'=>'ap_paterno')) }}
                                  </div>
                              </div>

                              <div class="form-group">
                                  {{ Form::label('apellido materno','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::text('ap_materno',$datos[0]->ap_materno,array('class'=>"form-control",'id'=>'ap_materno')) }}
                                  </div>
                              </div>

                              <div class="form-group">
                                  {{ Form::label('nombre','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::text('nombre',$datos[0]->nombre,array('class'=>"form-control",'id'=>'nombre')) }}
                                  </div>
                              </div>

                              <div class="form-group">
                                  {{ Form::label('fecha nacimiento','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::date('fecnacaseg',$datos[0]->fecnacaseg,array('class'=>"form-control",'id'=>'fecnacaseg')) }}
                                  </div>
                              </div>

                              <div class="form-group">
                                  {{ Form::label('Sexo','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::select('sexo', [
                                      'M' => 'Masculino',
                                      'F' => 'Femenino'],$datos[0]->sexo, ['class'=>"form-control", 'placeholder'=>"",'id'=>'sexo']  ) }}
                                  </div>
                              </div>

                              <div class="form-group">
                                  {{ Form::label('Nombre de la persona que autoriza el seguro','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::text('autoriza',$datos[0]->autoriza,array('class'=>"form-control", 'placeholder'=>"",'id'=>'autoriza')) }}
                                  </div>
                              </div>

                              <div class="form-group">
                                {{ Form::label('Parentesco','',array('class'=>"col-sm-3 control-label")) }}
                                <div class="col-sm-8">
                                    {{ Form::select('parentesco', [
                                    'TITULAR' => 'TITULAR',
                                    'ABUELA' => 'ABUELA',
                                    'ABUELO'=> 'ABUELO',
                                    'ESPOSA'=>'ESPOSA',
                                    'ESPOSO'=>'ESPOSO',
                                    'HERMANA'=>'HERMANA',
                                    'HERMANO'=>'HERMANO',
                                    'HIJA'=>'HIJA',
                                    'HIJO'=>'HIJO',
                                    'MADRE'=>'MADRE',
                                    'PADRE'=>'PADRE',
                                    'PRIMA'=>'PRIMA',
                                    'PRIMO'=>'PRIMO',
                                    'SOBRINA'=>'SOBRINA',
                                    'SOBRINO'=>'SOBRINO',
                                    'SUEGRA'=>'SUEGRA',
                                    'SUEGRO'=>'SUEGRO',
                                    'TIA'=>'TIA',
                                    'TIO'=>'TIO',
                                    'NUERA'=>'NUERA',
                                    'YERNO'=>'YERNO',
                                    'OTRO'=>'OTRO',
                                    'NINGUNO'=>'NINGUNO'],$datos[0]->parentesco, ['class'=>"form-control", 'placeholder'=>"",'id'=>'parentesco']  ) }}
                                </div>
                              </div>

                              <div class="form-group">
                                  {{ Form::label('Correo Electrónico','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::email('correo',$datos[0]->correo,array('class'=>"form-control",'id'=>'correo')) }}
                                  </div>
                              </div>

                              <div class="form-group">
                                  {{ Form::label('Fecha en que se hizo el movimiento','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::date('fecha_capt',$datos[0]->fecha_capt,array('class'=>"form-control", 'placeholder'=>"",'id'=>'fecha_capt','readonly'=>'readonly')) }}
                                  </div>
                              </div>

                              <div class="form-group">
                                  {{ Form::label('Dirección','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::text('direccion',$datos[0]->direccion,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'direccion')) }}
                                  </div>
                              </div>

                              <div class="form-group">
                                  {{ Form::label('Número exterior','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::text('num_ext',$datos[0]->num_ext,array('class'=>"form-control", 'placeholder'=>"",'id'=>'num_ext')) }}
                                  </div>
                              </div>

                              <div class="form-group">
                                  {{ Form::label('Vialidad','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::select('vialidad', [
                                      'AND' => 'AND',
                                      'AUT' => 'AUT',
                                      'AV'=> 'AV',
                                      'BJD'=>'BJD',
                                      'BLV'=>'BLV',
                                      'CALZ'=>'CALZ',
                                      'CALLE'=>'CALLE',
                                      'CJON'=>'CJON',
                                      'CAM'=>'CAM',
                                      'CARR'=>'CARR',
                                      'CDA'=>'CDA',
                                      'CTO'=>'CTO',
                                      'CVLN'=>'CVLN',
                                      'CRO'=>'CRO',
                                      'CUCH'=>'CUCH',
                                      'DIAG'=>'DIAG',
                                      'EJE'=>'EJE',
                                      'GTA'=>'GTA',
                                      'JDN'=>'JDN',
                                      'LIB'=>'LIB',
                                      'PRJ'=>'PRJ',
                                      'PARQ'=>'PARQ',
                                      'PSJ'=>'PSJ',
                                      'PSO'=>'PSO',
                                      'PERIF'=>'PERIF',
                                      'PZA'=>'PZA',
                                      'PRIV'=>'PRIV',
                                      'PROL'=>'PROL',
                                      'RML'=>'RML',
                                      'RET'=>'RET',
                                      'RCDA'=>'RCDA',
                                      'VDA'=>'VDA',
                                      'VIA'=>'VIA',
                                      'VDTO'=>'VDTO'],
                                  $datos[0]->vialidad, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'vialidad']  ) }}
                                  </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Vivienda','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::select('vivienda', [
                                        'CASA' => 'CASA',
                                        'COND' => 'COND',
                                        'DEPTO'=> 'DEPTO',
                                        'DPX'=>'DPX',
                                        'ED'=>'ED',
                                        'ENT'=>'ENT',
                                        'SUITE'=>'SUITE',
                                        'TORRE'=>'TORRE'],
                                    $datos[0]->vivienda, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'vivienda']  ) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Número interior','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('numint',$datos[0]->numint,array('class'=>"form-control", 'placeholder'=>"",'id'=>'nunInt')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Piso','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('piso',$datos[0]->piso,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'piso')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Tipo de asentamiento','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::select('asentamiento', [
                                        'AMPL' => 'AMPL',
                                        'APTO' => 'APTO',
                                        'BO'=> 'BO',
                                        'CAMP'=>'CAMP',
                                        'CD'=>'CD',
                                        'CGOLF'=>'CGOLF',
                                        'CHAB'=>'CHAB',
                                        'CI'=>'CI',
                                        'CNGR'=>'CNGR',
                                        'COL'=>'COL',
                                        'COND'=>'CTRO',
                                        'CURB'=>'CURB',
                                        'EJ'=>'EJ',
                                        'EST'=>'EST',
                                        'EXHDA'=>'EXHDA',
                                        'FINCA'=>'FINCA',
                                        'FRAC'=>'FRAC',
                                        'FRACC'=>'FRACC',
                                        'GRNJA'=>'GRNJA',
                                        'GU'=>'GU',
                                        'HDA'=>'HDA',
                                        'PBO'=>'PBO',
                                        'PCOM'=>'PCOM',
                                        'PIND'=>'PIND',
                                        'PTO'=>'PTO',
                                        'RCHO'=>'RCHO',
                                        'RES'=>'RES',
                                        'UHAB'=>'UHAB',
                                        'UNID'=>'UNID',
                                        'VILLA'=>'VILLA',
                                        'ZFED'=>'ZFED',
                                        'ZIND'=>'ZIND',
                                        'ZRUR'=>'ZRUR',
                                        'ZURB'=>'ZURB'],
                                    $datos[0]->asentamien, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'asentamiento']  ) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Estado','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::select('estado', [
                                        'AGS' => 'AGS',
                                        'BC' => 'BC',
                                        'BCS'=> 'BCS',
                                        'CAMP'=>'CAMP',
                                        'COAH'=>'COAH',
                                        'COL'=>'COL',
                                        'CHIS'=>'CHIS',
                                        'CHIH'=>'CHIH',
                                        'DF'=>'DF',
                                        'DGO'=>'DGO',
                                        'GTO'=>'GTO',
                                        'GRO'=>'GRO',
                                        'HGO'=>'HGO',
                                        'JAL'=>'JAL',
                                        'MEX'=>'MEX',
                                        'MICH'=>'MICH',
                                        'MOR'=>'MOR',
                                        'NAY'=>'NAY',
                                        'NL'=>'NL',
                                        'OAX'=>'OAX',
                                        'PUE'=>'PUE',
                                        'QRO'=>'QRO',
                                        'QROO'=>'QROO',
                                        'SLP'=>'SLP',
                                        'SIN'=>'SIN',
                                        'SON'=>'SON',
                                        'TAB'=>'TAB',
                                        'TAM'=>'TAM',
                                        'TLAX'=>'TLAX',
                                        'VER'=>'VER',
                                        'YUC'=>'YUC',
                                        'ZAC'=>'ZAC'],
                                    $datos[0]->estado, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'estado']  ) }}
                                    </div>
                                  </div>

                                  <div class="form-group">
                                      {{ Form::label('Ciudad','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::text('ciudad',$datos[0]->ciudad,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'ciudad')) }}
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      {{ Form::label('Colonia','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::text('colonia',$datos[0]->colonia,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'col')) }}
                                      </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('Codigo Postal','',array('class'=>"col-sm-3 control-label")) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('cp',$datos[0]->codpos,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'cp')) }}
                                        </div>
                                  </div>

                                  <div class="form-group">
                                      <div class="col-sm-10" style='text-align: center;'>
                                      {{ Form::label('Entr� calles','',array('class'=>"control-label")) }}
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      {{ Form::label('Calle 1','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::text('calle_1',$datos[0]->calle_1,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'calle_1')) }}
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      {{ Form::label('Calle 2','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::text('calle_2',$datos[0]->calle_2,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'calle_2')) }}
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <div class="col-sm-10" style='text-align: center;'>
                                      {{ Form::label('Referencias Principales del Domicilio Asegurado','',array('class'=>"control-label")) }}
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      {{ Form::label('Referencia 1','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::text('ref_1',$datos[0]->ref_1,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'ref_1')) }}
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      {{ Form::label('Referencia 2','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::text('ref_2',$datos[0]->ref_2,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'ref_2')) }}
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      {{ Form::label('RVT','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::text('rvt',$datos[0]->rvt,array( 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      {{ Form::label('Validador','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::text('validador',$value['user'],array( 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      {{ Form::label('# de pisos de la construcción','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::text('num_pisos',$datos[0]->num_pisos,array( 'class'=>"form-control", 'placeholder'=>"",'title'=>'La planta baja cuenta como Piso 1','id'=>'pisos')) }}
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      {{ Form::label('Número celular','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::text('num_cel',$datos[0]->num_cel,array('maxlength'=>'10', 'class'=>"form-control", 'placeholder'=>"",'title'=>'La planta baja cuenta como Piso 1','id'=>'pisos')) }}
                                      </div>
                                  </div>


                                  <div class="form-group">
                                      {{ Form::label('Campaña celular','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::text('comp_cel',$datos[0]->comp_cel,array( 'class'=>"form-control", 'placeholder'=>"",'title'=>'La planta baja cuenta como Piso 1','id'=>'pisos')) }}
                                      </div>
                                  </div>






                                  <!-- <div class="form-group">
                                      {{ Form::label('Estatus interno','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::select('estatus', [
                                          '1' => 'VENTA',
                                          '2' => 'VENTA EN PROCESO',
                                          '3'=>'RECHAZO EN VALIDACION',
                                          '4'=>'RECUPERAR',
                                          '5'=>'RECUPERADA',
                                          '6'=>'RECUPERACION FALLIADA',
                                          '7'=>'CANCELADA'],
                                      '', ['class'=>"form-control", 'placeholder'=>""]  ) }}
                                      </div>
                                  </div> -->
                                  <div class="form-group">
                                      {{ Form::label('Estatus interno','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::select('estatus', [
                                          'Venta' => 'VENTA',
                                          'VENTA EN PROCESO' => 'VENTA EN PROCESO',
                                          'RECHAZO EN VALIDACION'=>'RECHAZO EN VALIDACION',
                                          'RECUPERAR'=>'RECUPERAR',
                                          'RECUPERADA'=>'RECUPERADA',
                                          'RECUPERACION FALLIADA'=>'RECUPERACION FALLIADA',
                                          'CANCELADA'=>'CANCELADA'],
                                      $datos[0]->estatus_people_2, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                                      </div>
                                  </div>


                                  <div class="form-group">
                                      <div class="col-sm-offset-5 col-sm-1">
                                          {{ Form::submit('Enviar',['class'=>"btn btn-default","onClick"=>'return valida()','id'=>'submit']) }}
                                      </div>
                                  </div>


                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
