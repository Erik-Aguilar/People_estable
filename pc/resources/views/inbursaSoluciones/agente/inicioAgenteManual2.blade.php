@extends('layout.inbursaSoluciones.agente.agente')
@section('content')

<?php
$value = Session::all();
// dd($value);


$hora=date('H:i:s');
?>



<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                  <button type="button" class="btn btn-info" onclick="datosastriskSoluciones()" data-toggle="modal" data-target="#myModal">Obtener datos</button>
                  {{$value['nombre_completo']}}</h3>
            </div>
            <div class="panel-body">
              {{ Form::open(['action' => 'InbursaSolucionesController@FromularioInbSoluciones',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario",
                              'onsubmit'=>'return validar()'
                                ]) }}

                                
<div id='contenido' style='display: none;'>

                                <div class="form-group">
                                    {{ Form::label('numero','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('numero','',array('class'=>"form-control",'id'=>'numero')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Telefono marcado *','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('telefono','',array('class'=>"form-control",'id'=>'telefono', 'required' => 'required','maxlength'=>'10','minlength'=>'10')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('apellido paterno','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('ap_paterno','',array('class'=>"form-control",'id'=>'ap_paterno')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('apellido materno','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('ap_materno','',array('class'=>"form-control",'id'=>'ap_materno')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('nombre','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('nombre','',array('class'=>"form-control",'id'=>'nombre')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('fecha nacimiento','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::date('fecnacaseg','',array('class'=>"form-control",'id'=>'fecnacaseg')) }}
                                    </div>
                                </div>


                                <div class="form-group">
                                    {{ Form::label('Sexo','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::select('sexo', [
                                        'M' => 'Masculino',
                                        'F' => 'Femenino'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'sexo']  ) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Edo. civil','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::select('edocivil', [
                                        'NOAPLICA' => 'No aplica'
                                        ],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'edocivil']  ) }}
                                    </div>
                                </div>


                                <div class="form-group">
                                    {{ Form::label('Nombre de la persona que autoriza el seguro','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('autoriza','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'autoriza')) }}
                                    </div>
                                </div>


                                <div class="form-group">
                                  {{ Form::label('Parentesco','',array('class'=>"col-sm-3 control-label")) }}
                                  <div class="col-sm-8">
                                      {{ Form::select('parentesco', [
                                      'ARRENDATARIO' => 'ARRENDATARIO',
                                      'ESPOSA'=>'ESPOSA',
                                      'ESPOSO'=>'ESPOSO',
                                      'HERMANA'=>'HERMANA',
                                      'HERMANO'=>'HERMANO',
                                      'HIJA'=>'HIJA',
                                      'HIJO'=>'HIJO',
                                      'MADRE'=>'MADRE',
                                      'PADRE'=>'PADRE',
                                      'TITULAR' => 'TITULAR'
                                      ],
                                  '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'parentesco']  ) }}
                                  </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Correo Electrónico','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('correo','',array('class'=>"form-control",'id'=>'correo')) }}
                                    </div>
                               </div>


                               <div class="form-group">
                                   {{ Form::label('Fecha en que se hizo el movimiento','',array('class'=>"col-sm-3 control-label")) }}
                                   <div class="col-sm-8">
                                       {{ Form::date('fecha_capt',date('Y-m-d'),array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'fecha_capt')) }}
                                   </div>
                               </div>

                               <div class="form-group">
                                   {{ Form::label('Dirección','',array('class'=>"col-sm-3 control-label")) }}
                                   <div class="col-sm-8">
                                       {{ Form::text('direccion','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'direccion')) }}
                                   </div>
                               </div>

 
                               <div class="form-group">
                                   {{ Form::label('Vialidad','',array('class'=>"col-sm-3 control-label")) }}
                                   <div class="col-sm-8">
                                       {{ Form::select('vialidad', [
                                        'AND'=>'ANDADOR',
                                        'AUT'=>'AUTOPISTA',
                                        'AV'=>'AVENIDA',
                                        'BJD'=>'BAJADA',
                                        'BLV'=>'BOULEVARD',
                                        'CALZ'=>'CALZADA',
                                        'CALLE'=>'CALLE',
                                        'CJON'=>'CALLEJON',
                                        'CAM'=>'CAMINO',
                                        'CARR'=>'CARRETERA',
                                        'CDA'=>'CERRADA',
                                        'CTO'=>'CIRCUITO',
                                        'CVLN'=>'CIRCUNVALACION',
                                        'CRO'=>'CRUCERO',
                                        'CUCH'=>'CUCHILLA',
                                        'DIAG'=>'DIAGONAL',
                                        'EJE'=>'EJE',
                                        'GTA'=>'GLORIETA',
                                        'JDN'=>'JARDIN',
                                        'LIB'=>'LIBRAMIENTO',
                                        'PRJ'=>'PARAJE',
                                        'PARQ'=>'PARQUE',
                                        'PSJ'=>'PASAJE',
                                        'PSO'=>'PASEO',
                                        'PERIF'=>'PERIFERICO',
                                        'PZA'=>'PLAZA',
                                        'PRIV'=>'PRIVADA',
                                        'PROL'=>'PROLONGACION',
                                        'RML'=>'RAMAL',
                                        'RET'=>'RETORNO',
                                        'RCDA'=>'RINCONADA',
                                        'VDA'=>'VEREDA',
                                        'VIA'=>'VIA',
                                        'VDTO'=>'VIADUCTO',
                                        ],
                                   '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'vialidad']  ) }}
                                   </div>
                                 </div>

                                 <div class="form-group">
                                   {{ Form::label('Vivienda','',array('class'=>"col-sm-3 control-label")) }}
                                   <div class="col-sm-8">
                                       {{ Form::select('vivienda', [
                                       'NEG' => 'NEGOCIO'],
                                   '', [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'vivienda']  ) }}
                                   </div>
                                 </div>

                                 <div class="form-group">
                                     {{ Form::label('Número interior','',array('class'=>"col-sm-3 control-label")) }}
                                     <div class="col-sm-8">
                                         {{ Form::text('numint','',array('class'=>"form-control", 'placeholder'=>"Escribe 0 si no tiene numero interior",'id'=>'numint')) }}
                                     </div>
                                 </div>

                                 <div class="form-group">
                                     {{ Form::label('Piso','',array('class'=>"col-sm-3 control-label")) }}
                                     <div class="col-sm-8">
                                         {{ Form::text('piso','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'piso')) }}
                                     </div>
                                  </div>

                                  <div class="form-group">
                                      {{ Form::label('Tipo de asentamiento','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::select('asentamien', [
                                          'AMPL' => 'Ampliacion',
                                          'APTO' => 'Aeropuerto',
                                          'BO'=> 'Barrio',
                                          'CAMP'=>'Campamento',
                                          'CD'=>'Ciudad',
                                          'CGOLF'=>'Club de Golf',
                                          'CHAB'=>'Conjunto Habitacional',
                                          'CI'=>'Conjunto Industrial',
                                          'CNGR'=>'Congregacion',
                                          'COL'=>'Colonia',
                                          'COND'=>'Centro',
                                          'CURB'=>'Centro Urbano',
                                          'EJ'=>'Ejido',
                                          'EST'=>'Estacion',
                                          'EXHDA'=>'Ex Hacienda',
                                          'FINCA'=>'Finca',
                                          'FRAC'=>'Fraccion',
                                          'FRACC'=>'Fraccionamiento',
                                          'GRNJA'=>'Granja',
                                          'GU'=>'Gran Usuario',
                                          'HDA'=>'Hacienda',
                                          'PBO'=>'Pueblo',
                                          'PCOM'=>'Poblado Comunal',
                                          'PIND'=>'Parque Industrial',
                                          'PTO'=>'Puerto',
                                          'RCHO'=>'Rancho o Rancheria',
                                          'RES'=>'Residencial',
                                          'UHAB'=>'Unidad Habitacional',
                                          'UNID'=>'Unidad',
                                          'VILLA'=>'Villla',
                                          'ZFED'=>'Zona Federal',
                                          'ZIND'=>'Zona Industrial',
                                          'ZRUR'=>'Zona Rural',
                                          'ZURB'=>'Zona Urbana'],
                                      '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'asentamien']  ) }}
                                      </div>
                                    </div>


                                    <div class="form-group">
                                        {{ Form::label('Estado *','',array('class'=>"col-sm-3 control-label")) }}
                                        <div class="col-sm-8">
                                             {{Form::select('state',$states->prepend(''),'',['id'=>'state','class'=>'form-control','placeholder'=>'Selecciona un estado'])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('Delegación/Municipio *','',array('class'=>"col-sm-3 control-label")) }}
                                        <div class="col-sm-8">
                                             {{ Form::text('town','',array('class'=>"form-control",'id'=>'town')) }}
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        {{ Form::label('Colonia *','',array('class'=>"col-sm-3 control-label")) }}
                                        <div class="col-sm-8">
                                             {{ Form::text('col','',array('class'=>"form-control",'id'=>'col')) }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('Código Postal *','',array('class'=>"col-sm-3 control-label")) }}
                                        <div class="col-sm-8">
                                             {{ Form::text('cp','',array('class'=>"form-control",'id'=>'cp')) }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                       {{ Form::label('Calle_1','',array('class'=>"col-sm-3 control-label")) }}
                                       <div class="col-sm-8">
                                           {{ Form::text('Calle_1','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'calle1','maxlength'=>'50','minlength'=>'0')) }}
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       {{ Form::label('Calle_2','',array('class'=>"col-sm-3 control-label")) }}
                                       <div class="col-sm-8">
                                           {{ Form::text('Calle_2','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'calle2','maxlength'=>'50','minlength'=>'0')) }}
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       {{ Form::label('Ref 1','',array('class'=>"col-sm-3 control-label")) }}
                                       <div class="col-sm-8">
                                           {{ Form::text('ref_1','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'ref1','maxlength'=>'50','minlength'=>'0')) }}
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       {{ Form::label('Ref 2','',array('class'=>"col-sm-3 control-label")) }}
                                       <div class="col-sm-8">
                                           {{ Form::text('ref_2','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'ref2','maxlength'=>'50','minlength'=>'0')) }}
                                       </div>
                                    </div>

                                    <div class="form-group" >
                                      {{ Form::label('RVT','',array('class'=>"col-sm-3 control-label")) }}
                                      <div class="col-sm-8">
                                          {{ Form::text('rvtname',$value['nombre_completo'],array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'aceptaventa')) }}
                                      </div>
                                    </div>

                                    <!-- <div class="form-group" style='display:none;'>
                                            <div class="col-sm-8">
                                                {{ Form::text('rvt',$value['user'],array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'aceptaventa2')) }}
                                            </div>
                                    </div> -->

                                   <div class="form-group">
                                           {{ Form::label('turno','',array('class'=>"col-sm-3 control-label")) }}
                                           <div class="col-sm-8">
                                             {{ Form::select('turno', [
                                             'M' => 'MATUTINO',
                                             'V'=> 'VESPERTINO'],
                                         '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'turno']  ) }}
                                           </div>
                                    </div>

                                    <div class="form-group">
                                            {{ Form::label('Hora de inicio de la llamada de venta','',array('class'=>"col-sm-3 control-label")) }}
                                            <div class="col-sm-8">
                                                {{ Form::time('hora_ini',$hora,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                                            </div>
                                    </div>

                                    <!--
                                    <div class="form-group">
                                        {{ Form::label('Hora de fin de la llamada de venta','',array('class'=>"col-sm-3 control-label")) }}
                                        <div class="col-sm-8">
                                            {{ Form::time('hora_fin',null,array('class'=>"form-control", 'placeholder'=>"")) }}
                                        </div>
                                    </div>

                                  -->

                                    <div class="form-group">
                                          {{ Form::label('# de pisos de la construcción','',array('class'=>"col-sm-3 control-label")) }}
                                          <div class="col-sm-8">
                                              {{ Form::text('num_pisos','',array('class'=>"form-control", 'placeholder'=>"No puede ser mayor al valor en el Capo Piso",'id'=>'num_pisos')) }}
                                          </div>
                                    </div>

                                    <div class="form-group">
                                       {{ Form::label('Cubierta','',array('class'=>"col-sm-3 control-label")) }}
                                       <div class="col-sm-8">
                                           {{ Form::select('cubierta', [
                                             '1' => 'CUBIERTA PESADA',
                                             '2'=> 'CUBIERTA LIGERA SIN DISEÑO',
                                             '3' => 'CUBIERTA LIGERA CON DISEÑO GENERICO',
                                             '4' => 'CUBIERTA LIGERA CON DISEÑO ESPECIFICO'],
                                         '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'cubierta']  ) }}
 
                                       </div>
                                    </div>

                                    <!--
                                    <div class="form-group">
                                       {{ Form::label('Tipo fuente','',array('class'=>"col-sm-3 control-label")) }}
                                       <div class="col-sm-8">
                                           {{ Form::text('tipo_fuente','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'tipo_fiente',)) }}
                                       </div>
                                    </div>
                                  -->

                                    <!--
                                    <div class="form-group">
                                       {{ Form::label('Linea marcacion','',array('class'=>"col-sm-3 control-label")) }}
                                       <div class="col-sm-8">
                                           {{ Form::text('linea_mar','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'linea_mar')) }}
                                       </div>
                                    </div>
                                    -->

                                    <div class="form-group">
                                           {{ Form::label('Numero celular','',array('class'=>"col-sm-3 control-label")) }}
                                           <div class="col-sm-8">
                                             {{ Form::text('num_cel','',array('class'=>"form-control",'maxlength'=>'10', 'placeholder'=>"",'id'=>'num_cel')) }}
                                             <br>
                                             
                                             <label>Compañia</label>
                                             {{ Form::select('ref_1_tel', [
                                             '1' => 'TELCEL',
                                             '2' => 'IUSACELL',
                                             '3' => 'TELEFONICA MOVISTAR',
                                             '4' => 'UNEFON',
                                             '5' => 'OTRO',
                                             '6' => 'AT&amp;T',
                                             '7' => 'NEXTEL',
                                             '8' => 'VIRGIN'],
                                         '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'comp_cel','onchange'=>'compval()']  ) }}
                                         <br>
                                         <label>Otra compañia</label>
                                         {{ Form::text('otra_comp_cel','',array('class'=>"form-control",'placeholder'=>"Nombre de la otra compañia telefonica",'id'=>'otra_comp_cel')) }}
                                          </div>
                                        </div>

                                        
                                        <!--
                                        <div class="form-group">
                                          {{ Form::label('Validador','',array('class'=>"col-sm-3 control-label")) }}
                                          <div class="col-sm-8">
                                           {{ Form::text('validador','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'validador')) }}
                                          </div>
                                        </div>
                                      -->


                                        <div class="form-group">
                                            {{ Form::label('Validador','',array('class'=>"col-sm-3 control-label")) }}
                                            <div class="col-sm-8">
                                                {{ Form::select('validador', $validadores,
                                                    null, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'validador']  ) }}
                                            </div>
                                        </div>




                                        <div class="form-group">
                                          {{ Form::label('Nombre empresa','',array('class'=>"col-sm-3 control-label")) }}
                                          <div class="col-sm-8">
                                           {{ Form::text('nombre_empresa','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'nombre_empresa')) }}
                                          </div>
                                        </div>


                                        <div class="form-group">
                                           {{ Form::label('Giro Comercial','',array('class'=>"col-sm-3 control-label")) }}
                                           <div class="col-sm-8">
                                             {{ Form::select('giro', [
                                                  'ABARROTES, BODEGA Y/O EXPENDIO'=>'ABARROTES, BODEGA Y/O EXPENDIO',
                                                  'ABONOS Y/O FERTILIZANTES, BODEGA Y/O EXPENDIO'=>'ABONOS Y/O FERTILIZANTES, BODEGA Y/O EXPENDIO',
                                                  'ACEITE DE PESCADO, FABRICA DE'=>'ACEITE DE PESCADO, FABRICA DE',
                                                  'ACEITE VEGETAL, FABRICA DE'=>'ACEITE VEGETAL, FABRICA DE',
                                                  'ACEITE, HIDROGENADOR'=>'ACEITE, HIDROGENADOR',
                                                  'ACEITE, REFINADOR'=>'ACEITE, REFINADOR',
                                                  'ACEITES ESENCIALES Y/O AROMATIZANTES, FABRICA DE'=>'ACEITES ESENCIALES Y/O AROMATIZANTES, FABRICA DE',
                                                  'ACEITES, GRASAS Y LUBRICANTES, BODEGA Y/O EXPENDIO'=>'ACEITES, GRASAS Y LUBRICANTES, BODEGA Y/O EXPENDIO',
                                                  'ACEITES, GRASAS Y LUBRICANTES, FABRICA'=>'ACEITES, GRASAS Y LUBRICANTES, FABRICA',
                                                  'ACERO Y/O FIERRO, BODEGA Y/O EXPENDIO'=>'ACERO Y/O FIERRO, BODEGA Y/O EXPENDIO',
                                                  'ACUARIOS, ACCESORIOS, BODEGA Y/O EXPENDIO'=>'ACUARIOS, ACCESORIOS, BODEGA Y/O EXPENDIO',
                                                  'ACUMULADORES, BODEGA Y/O EXPENDIO'=>'ACUMULADORES, BODEGA Y/O EXPENDIO',
                                                  'ACUMULADORES, FABRICA DE'=>'ACUMULADORES, FABRICA DE',
                                                  'ADUANA AGENCIA, BODEGAS'=>'ADUANA AGENCIA, BODEGAS',
                                                  'AEROBICS'=>'AEROBICS',
                                                  'AEROPUERTO'=>'AEROPUERTO',
                                                  'AFILADURIA'=>'AFILADURIA',
                                                  'AGENCIA ADUANAL ,OFICINAS'=>'AGENCIA ADUANAL ,OFICINAS',
                                                  'AGENCIA DE AUTOMOVILES'=>'AGENCIA DE AUTOMOVILES',
                                                  'AGENCIA DE INHUMACIONES'=>'AGENCIA DE INHUMACIONES',
                                                  'AGENCIA DE PUBLICIDAD'=>'AGENCIA DE PUBLICIDAD',
                                                  'AGENCIA DE VIAJES'=>'AGENCIA DE VIAJES',
                                                  'AGUA EMBOTELLADA, BODEGA'=>'AGUA EMBOTELLADA, BODEGA',
                                                  'AGUA EMBOTELLADA, EXPENDIO'=>'AGUA EMBOTELLADA, EXPENDIO',
                                                  'AGUA MINERAL O GASEOSA, BODEGA'=>'AGUA MINERAL O GASEOSA, BODEGA',
                                                  'AGUA MINERAL O GASEOSA, EXPENDIO'=>'AGUA MINERAL O GASEOSA, EXPENDIO',
                                                  'AGUA MINERAL O GASEOSA, PLANTA DE ENVASADO'=>'AGUA MINERAL O GASEOSA, PLANTA DE ENVASADO',
                                                  'AGUA, ESTACION DE BOMBEO'=>'AGUA, ESTACION DE BOMBEO',
                                                  'AGUA, PLANTA DE TRATAMIENTO DE'=>'AGUA, PLANTA DE TRATAMIENTO DE',
                                                  'AGUA, PURIFICACION Y ENVASADO DE'=>'AGUA, PURIFICACION Y ENVASADO DE',
                                                  'AGUA, TANQUE ELEVADO'=>'AGUA, TANQUE ELEVADO',
                                                  'AGUA, TORRE DE ENFRIAMIENTO'=>'AGUA, TORRE DE ENFRIAMIENTO',
                                                  'AGUARDIENTE, BODEGA Y/O EXPENDIO'=>'AGUARDIENTE, BODEGA Y/O EXPENDIO',
                                                  'AGUARDIENTE, FABRICA DE'=>'AGUARDIENTE, FABRICA DE',
                                                  'AGUARRAS, BODEGA Y/O EXPENDIO'=>'AGUARRAS, BODEGA Y/O EXPENDIO',
                                                  'AGUARRAS, FABRICA DE'=>'AGUARRAS, FABRICA DE',
                                                  'ALAMBRE, FABRICACION DE'=>'ALAMBRE, FABRICACION DE',
                                                  'ALBERCAS, EQUIPOS PARA, BODEGA Y/O EXPENDIO'=>'ALBERCAS, EQUIPOS PARA, BODEGA Y/O EXPENDIO',
                                                  'ALCOHOL, BODEGA Y/O EXPENDIO'=>'ALCOHOL, BODEGA Y/O EXPENDIO',
                                                  'ALCOHOL, FABRICA DE'=>'ALCOHOL, FABRICA DE',
                                                  'ALFARERIA Y/O ARTESANIAS, BODEGA Y/O EXPENDIO'=>'ALFARERIA Y/O ARTESANIAS, BODEGA Y/O EXPENDIO',
                                                  'ALFARERIA Y/O ARTESANIAS, FABRICA Y/O TALLER'=>'ALFARERIA Y/O ARTESANIAS, FABRICA Y/O TALLER',
                                                  'ALFOMBRAS, TAPETES Y/O TAPICES, BODEGA Y/O EXPENDIO'=>'ALFOMBRAS, TAPETES Y/O TAPICES, BODEGA Y/O EXPENDIO',
                                                  'ALFOMBRAS, TAPETES Y/O TAPICES, FABRICA DE'=>'ALFOMBRAS, TAPETES Y/O TAPICES, FABRICA DE',
                                                  'ALIMENTO PARA ANIMALES, BODEGA Y/O EXP. S.PASTOS'=>'ALIMENTO PARA ANIMALES, BODEGA Y/O EXP. S.PASTOS',
                                                  'ALIMENTO PARA ANIMALES, FABRICA DE, CON PASTOS SEC.'=>'ALIMENTO PARA ANIMALES, FABRICA DE, CON PASTOS SEC.',
                                                  'ALIMENTO PARA ANIMALES,FABRICA DE, SIN PASTOS SEC.'=>'ALIMENTO PARA ANIMALES,FABRICA DE, SIN PASTOS SEC.',
                                                  'ALMACEN GENERAL DE DEPOSITO, CONCESION FEDERAL'=>'ALMACEN GENERAL DE DEPOSITO, CONCESION FEDERAL',
                                                  'ANIMALES, ESTABLO Y/O GANADO EN PIE'=>'ANIMALES, ESTABLO Y/O GANADO EN PIE',
                                                  'ANIMALES, GRANJA AVICOLA Y/O INCUBADORA Y/O SELEC.'=>'ANIMALES, GRANJA AVICOLA Y/O INCUBADORA Y/O SELEC.',
                                                  'ANTIGUEDADES, BAZAR Y/O CURIOSIDADES EXPENDIO'=>'ANTIGUEDADES, BAZAR Y/O CURIOSIDADES EXPENDIO',
                                                  'ANUNCIOS DE NEON, BODEGA Y/O EXPENDIO'=>'ANUNCIOS DE NEON, BODEGA Y/O EXPENDIO',
                                                  'ANUNCIOS LUMINOSOS, FABRICA Y/O TALLER DE'=>'ANUNCIOS LUMINOSOS, FABRICA Y/O TALLER DE',
                                                  'APARATOS CIENTIFICOS, BODEGA Y/O EXPENDIO'=>'APARATOS CIENTIFICOS, BODEGA Y/O EXPENDIO',
                                                  'APARATOS CIENTIFICOS, FABRICA DE'=>'APARATOS CIENTIFICOS, FABRICA DE',
                                                  'APARATOS ELECTRICOS, BODEGA Y/O EXPENDIO'=>'APARATOS ELECTRICOS, BODEGA Y/O EXPENDIO',
                                                  'APARATOS ELECTRICOS, FABRICA Y/O TALLER DE'=>'APARATOS ELECTRICOS, FABRICA Y/O TALLER DE',
                                                  'APARATOS ELECTRONICOS, BODEGA Y/O EXPENDIO'=>'APARATOS ELECTRONICOS, BODEGA Y/O EXPENDIO',
                                                  'APARATOS ELECTRONICOS, FABRICA Y/O TALLER DE'=>'APARATOS ELECTRONICOS, FABRICA Y/O TALLER DE',
                                                  'ARMAS DE FUEGO Y CARTUCHOS, EXPENDIO'=>'ARMAS DE FUEGO Y CARTUCHOS, EXPENDIO',
                                                  'ARROZ, BENEFICIO DE'=>'ARROZ, BENEFICIO DE',
                                                  'ASBESTO, BODEGA Y/O EXPENDIO DE ARTICULOS DE'=>'ASBESTO, BODEGA Y/O EXPENDIO DE ARTICULOS DE',
                                                  'ASBESTO, FABRICA DE ARTICULOS'=>'ASBESTO, FABRICA DE ARTICULOS',
                                                  'ASERRADERO'=>'ASERRADERO',
                                                  'ASTILLERO, PARA ARMAR CASCOS DE ACERO'=>'ASTILLERO, PARA ARMAR CASCOS DE ACERO',
                                                  'ASTILLERO, PARA ARMAR CASCOS DE MADERA'=>'ASTILLERO, PARA ARMAR CASCOS DE MADERA',
                                                  'AUTOMOVILES Y/O CAMIONES, FABRICACION Y/O ARMADO'=>'AUTOMOVILES Y/O CAMIONES, FABRICACION Y/O ARMADO',
                                                  'AUTOPARTES, FABRICACION DE'=>'AUTOPARTES, FABRICACION DE',
                                                  'AZUCAR, BODEGA Y/O EXPENDIO'=>'AZUCAR, BODEGA Y/O EXPENDIO',
                                                  'AZUCAR, FABRICA DE, SIN OBTENCION DE AGUARDIENTE'=>'AZUCAR, FABRICA DE, SIN OBTENCION DE AGUARDIENTE',
                                                  'AZUCAR, INGENIO'=>'AZUCAR, INGENIO',
                                                  'AZUFRE, BODEGA Y/O EXPENDIO'=>'AZUFRE, BODEGA Y/O EXPENDIO',
                                                  'AZUFRE, PLANTA EXTRACTORA DE'=>'AZUFRE, PLANTA EXTRACTORA DE',
                                                  'AZULEJOS Y/O MOSAICOS, BODEGA Y/O EXPENDIO'=>'AZULEJOS Y/O MOSAICOS, BODEGA Y/O EXPENDIO',
                                                  'AZULEJOS Y/O MOSAICOS, FABRICA Y/O TALLER DE'=>'AZULEJOS Y/O MOSAICOS, FABRICA Y/O TALLER DE',
                                                  'BANCO Y/O CASA DE CAMBIO'=>'BANCO Y/O CASA DE CAMBIO',
                                                  'BAÑO PUBLICO'=>'BAÑO PUBLICO',
                                                  'BARNICES Y/O PINTURAS, FABRICA'=>'BARNICES Y/O PINTURAS, FABRICA',
                                                  'BASURA, PLATA DE APROVECHAMIENTO DE'=>'BASURA, PLATA DE APROVECHAMIENTO DE',
                                                  'BAULES Y PETACAS, BODEGA Y/O EXPENDIO'=>'BAULES Y PETACAS, BODEGA Y/O EXPENDIO',
                                                  'BIBLIOTECA PUBLICA'=>'BIBLIOTECA PUBLICA',
                                                  'BICICLETAS Y ACCESORIOS, BODEGA Y/O EXPENDIO'=>'BICICLETAS Y ACCESORIOS, BODEGA Y/O EXPENDIO',
                                                  'BICICLETAS, FABRICACION, TALLER Y/O ARMADO'=>'BICICLETAS, FABRICACION, TALLER Y/O ARMADO',
                                                  'BILLAR Y/O BOLICHE SALON DE'=>'BILLAR Y/O BOLICHE SALON DE',
                                                  'BONETERIA Y/O MERCERIA, BODEGA Y/O EXPENDIO'=>'BONETERIA Y/O MERCERIA, BODEGA Y/O EXPENDIO',
                                                  'BORRA, ESTOPA Y/O GUATA, FABRICA DE'=>'BORRA, ESTOPA Y/O GUATA, FABRICA DE',
                                                  'BROCHAS Y PINCELES, FABRICA DE'=>'BROCHAS Y PINCELES, FABRICA DE',
                                                  'CAFE, BENEFICIADORA DE'=>'CAFE, BENEFICIADORA DE',
                                                  'CAFE, BODEGA Y/O EXPENDIO'=>'CAFE, BODEGA Y/O EXPENDIO',
                                                  'CAFE, MOLINO Y TOSTADOR DE'=>'CAFE, MOLINO Y TOSTADOR DE',
                                                  'CAFETERIA, CON JUEGOS ELECTRONICOS'=>'CAFETERIA, CON JUEGOS ELECTRONICOS',
                                                  'CAJA POPULAR'=>'CAJA POPULAR',
                                                  'CAL, FABRICA DE'=>'CAL, FABRICA DE',
                                                  'CARNES FRIAS Y/O CREMERIA, BODEGA Y/O EXPENDIO'=>'CARNES FRIAS Y/O CREMERIA, BODEGA Y/O EXPENDIO',
                                                  'CARPINTERIA Y/O EBANISTERIA, TALLER DE'=>'CARPINTERIA Y/O EBANISTERIA, TALLER DE',
                                                  'CARTUCHOS, FABRICA DE, POLVORA 2KG. POR MAQUINA'=>'CARTUCHOS, FABRICA DE, POLVORA 2KG. POR MAQUINA',
                                                  'CARTUCHOS,FCA.DE,POLVORA MAS DE 2KG.POR MAQUINA'=>'CARTUCHOS,FCA.DE,POLVORA MAS DE 2KG.POR MAQUINA',
                                                  'CASA DE BOLSA'=>'CASA DE BOLSA',
                                                  'CASA DE EMPEÑO'=>'CASA DE EMPEÑO',
                                                  'CASA DE HUESPEDES Y/O MOTEL'=>'CASA DE HUESPEDES Y/O MOTEL',
                                                  'CELULARES Y ACCESORIOS, BODEGA Y/O EXP. Y/O TALLER'=>'CELULARES Y ACCESORIOS, BODEGA Y/O EXP. Y/O TALLER',
                                                  'CELULOSA, FABRICA DE'=>'CELULOSA, FABRICA DE',
                                                  'CEMENTO, FABRICA DE'=>'CEMENTO, FABRICA DE',
                                                  'CENTRO COMERCIAL Y/O TIENDA DEPARTAMENTAL'=>'CENTRO COMERCIAL Y/O TIENDA DEPARTAMENTAL',
                                                  'CERAS Y PASTAS PARA LIMPIAR METALES, FABRICA DE'=>'CERAS Y PASTAS PARA LIMPIAR METALES, FABRICA DE',
                                                  'CEREALES, GRANOS Y SEMILLAS, BENEFICIADORA'=>'CEREALES, GRANOS Y SEMILLAS, BENEFICIADORA',
                                                  'CEREALES, GRANOS Y SEMILLAS, BODEGA Y/O EXPENDIO'=>'CEREALES, GRANOS Y SEMILLAS, BODEGA Y/O EXPENDIO',
                                                  'CEREALES, GRANOS Y SEMILLAS, MOLINO DE'=>'CEREALES, GRANOS Y SEMILLAS, MOLINO DE',
                                                  'CERILLOS, FABRICA DE'=>'CERILLOS, FABRICA DE',
                                                  'CERVEZA Y MALTA, FABRICA DE'=>'CERVEZA Y MALTA, FABRICA DE',
                                                  'CERVEZA, BODEGA Y/O EXPENDIO'=>'CERVEZA, BODEGA Y/O EXPENDIO',
                                                  'CIGARROS Y/O PUROS Y/O CERILLOS, BODEGA Y/O EXP.'=>'CIGARROS Y/O PUROS Y/O CERILLOS, BODEGA Y/O EXP.',
                                                  'CIGARROS, FABRICACION DE'=>'CIGARROS, FABRICACION DE',
                                                  'CINTAS MAGNETOFONICAS, CENTRO DE GRABACION DE'=>'CINTAS MAGNETOFONICAS, CENTRO DE GRABACION DE',
                                                  'COCOA Y/O CHOCOLATE DE MESA, ELABORACION DE'=>'COCOA Y/O CHOCOLATE DE MESA, ELABORACION DE',
                                                  'COLCHONES, BODEGA Y/O EXPENDIO'=>'COLCHONES, BODEGA Y/O EXPENDIO',
                                                  'COLCHONES, FABRICA DE'=>'COLCHONES, FABRICA DE',
                                                  'CONCRETO, ELEMENTOS PREFABRICADOS'=>'CONCRETO, ELEMENTOS PREFABRICADOS',
                                                  'CONSERVAS ALIMENTICIAS, FABRICA'=>'CONSERVAS ALIMENTICIAS, FABRICA',
                                                  'CONSULTORIO MEDICO Y/O DENTAL'=>'CONSULTORIO MEDICO Y/O DENTAL',
                                                  'COPRA, BODEGA'=>'COPRA, BODEGA',
                                                  'COSMETICOS Y SIMILARES, FABRICA DE'=>'COSMETICOS Y SIMILARES, FABRICA DE',
                                                  'CUEROS Y/O PIELES, BODEGA Y/O EXPENDIO'=>'CUEROS Y/O PIELES, BODEGA Y/O EXPENDIO',
                                                  'CUEROS Y/O PIELES, FABRICACION DE ARTICULOS DE'=>'CUEROS Y/O PIELES, FABRICACION DE ARTICULOS DE',
                                                  'CULTIVOS EN PIE'=>'CULTIVOS EN PIE',
                                                  'CURTIDURIA Y/O TENERIA'=>'CURTIDURIA Y/O TENERIA',
                                                  'DENTRIFICOS, FABRICACION DE'=>'DENTRIFICOS, FABRICACION DE',
                                                  'DEPORTES, ARTICULOS DE BODEGA Y/O EXPENDIO'=>'DEPORTES, ARTICULOS DE BODEGA Y/O EXPENDIO',
                                                  'DEPORTIVO'=>'DEPORTIVO',
                                                  'DESHIDRATADORA, PLANTA'=>'DESHIDRATADORA, PLANTA',
                                                  'DETERGENTES Y JABONES, FABRICA DE'=>'DETERGENTES Y JABONES, FABRICA DE',
                                                  'DISCOS MAGNETICOS, FABRICACION DE'=>'DISCOS MAGNETICOS, FABRICACION DE',
                                                  'DISCOS Y/O CASETTES MUSICALES, BODEGA Y/O EXPENDIO'=>'DISCOS Y/O CASETTES MUSICALES, BODEGA Y/O EXPENDIO',
                                                  'DISCOTEQUE Y/O SALON DE BAILE'=>'DISCOTEQUE Y/O SALON DE BAILE',
                                                  'DULCES, CHOCOLATES Y/O CAJETAS, BODEGA Y/O EXPENDIO'=>'DULCES, CHOCOLATES Y/O CAJETAS, BODEGA Y/O EXPENDIO',
                                                  'DULCES,CHOCOLATES Y/O CAJETAS, FABRICA DE'=>'DULCES,CHOCOLATES Y/O CAJETAS, FABRICA DE',
                                                  'EDIFICIO DESOCUPADO Y/O DESHABITADO'=>'EDIFICIO DESOCUPADO Y/O DESHABITADO',
                                                  'ELECTRICIDAD, ARTICULOS PARA, BODEGA Y/O EXPENDIO'=>'ELECTRICIDAD, ARTICULOS PARA, BODEGA Y/O EXPENDIO',
                                                  'ELECTRICIDAD, FABRICA DE ARTICULOS PARA'=>'ELECTRICIDAD, FABRICA DE ARTICULOS PARA',
                                                  'ELECTRICIDAD, PLANTA GENERADORA Y/O DISTRIBUIDORA'=>'ELECTRICIDAD, PLANTA GENERADORA Y/O DISTRIBUIDORA',
                                                  'EMPACADORA DE FRUTAS Y LEGUMBRES'=>'EMPACADORA DE FRUTAS Y LEGUMBRES',
                                                  'EMPACADORA DE PRODUCTOS DEL MAR'=>'EMPACADORA DE PRODUCTOS DEL MAR',
                                                  'EMPAQUES DE YUTE O LINO, BODEGA Y/O EXPENDIO'=>'EMPAQUES DE YUTE O LINO, BODEGA Y/O EXPENDIO',
                                                  'EMPAQUES DE YUTE O LINO, FABRICA DE'=>'EMPAQUES DE YUTE O LINO, FABRICA DE',
                                                  'ENCUADERNACION, TALLER DE'=>'ENCUADERNACION, TALLER DE',
                                                  'EQPO. E INSTRUMENTAL MEDICO, BODEGA Y/O EXPENDIO'=>'EQPO. E INSTRUMENTAL MEDICO, BODEGA Y/O EXPENDIO',
                                                  'ESCOBAS Y SIMILARES, BODEGA Y/O EXPENDIO'=>'ESCOBAS Y SIMILARES, BODEGA Y/O EXPENDIO',
                                                  'ESCOBAS Y SIMILARES, FABRICA DE'=>'ESCOBAS Y SIMILARES, FABRICA DE',
                                                  'ESCUELA, COLEGIO Y/O INSTITUTO DE ENSEÑANZA'=>'ESCUELA, COLEGIO Y/O INSTITUTO DE ENSEÑANZA',
                                                  'ESPECIAS, BODEGA Y/O EXPENDIO'=>'ESPECIAS, BODEGA Y/O EXPENDIO',
                                                  'ESPECIAS, SECADORA'=>'ESPECIAS, SECADORA',
                                                  'ESPECTACULO PUBLICO AL AIRE LIBRE'=>'ESPECTACULO PUBLICO AL AIRE LIBRE',
                                                  'ESPECTACULO PUBLICO CUBIERTO'=>'ESPECTACULO PUBLICO CUBIERTO',
                                                  'ESTACIONAMIENTO PUBLICO'=>'ESTACIONAMIENTO PUBLICO',
                                                  'ESTETICA, PELUQUERIA Y/O SALON DE BELLEZA'=>'ESTETICA, PELUQUERIA Y/O SALON DE BELLEZA',
                                                  'ESTUDIOS CINEMATOGRAFICOS, LOCAL DE FILMACION'=>'ESTUDIOS CINEMATOGRAFICOS, LOCAL DE FILMACION',
                                                  'FARMACEUTICOS, FABRICACION DE PRODUCTOS'=>'FARMACEUTICOS, FABRICACION DE PRODUCTOS',
                                                  'FARMACIA'=>'FARMACIA',
                                                  'FERRETERIA Y/O TLAPALERIA BODEGA Y/O EXPENDIO'=>'FERRETERIA Y/O TLAPALERIA BODEGA Y/O EXPENDIO',
                                                  'FERTILIZANTES Y/O ABONOS, FABRICA DE'=>'FERTILIZANTES Y/O ABONOS, FABRICA DE',
                                                  'FIBRAS VEGETALES, BODEGA Y/O EXPENDIO'=>'FIBRAS VEGETALES, BODEGA Y/O EXPENDIO',
                                                  'FIBRAS VEGETALES, FABRICA, ARTICULOS DE'=>'FIBRAS VEGETALES, FABRICA, ARTICULOS DE',
                                                  'FLORERIA'=>'FLORERIA',
                                                  'FOTOCOPIADO Y/O FOTOGRABADO, TALLER DE'=>'FOTOCOPIADO Y/O FOTOGRABADO, TALLER DE',
                                                  'FOTOGRAFIA, FABRICA DE MATERIALES PARA'=>'FOTOGRAFIA, FABRICA DE MATERIALES PARA',
                                                  'FOTOGRAFIA, TALLER DE REVELADO, ESTUDIO, BOD. Y/O EXP'=>'FOTOGRAFIA, TALLER DE REVELADO, ESTUDIO, BOD. Y/O EXP',
                                                  'FRITURAS, BODEGA Y/O EXPENDIO'=>'FRITURAS, BODEGA Y/O EXPENDIO',
                                                  'FRITURAS, FABRICA DE'=>'FRITURAS, FABRICA DE',
                                                  'FRUTAS Y LEGUMBRES, BODEGA Y/O EXPENDIO'=>'FRUTAS Y LEGUMBRES, BODEGA Y/O EXPENDIO',
                                                  'FUNERARIA, AGENCIA O VELATORIO'=>'FUNERARIA, AGENCIA O VELATORIO',
                                                  'GALERIA DE ARTE'=>'GALERIA DE ARTE',
                                                  'GALLETAS, BODEGA Y/O EXPENDIO'=>'GALLETAS, BODEGA Y/O EXPENDIO',
                                                  'GALLETAS, FABRICA'=>'GALLETAS, FABRICA',
                                                  'GASERIA, COMBUSTIBLE DE VEHICULOS'=>'GASERIA, COMBUSTIBLE DE VEHICULOS',
                                                  'GASES PROPANO O BUTANO'=>'GASES PROPANO O BUTANO',
                                                  'GASOLINERIA Y/O DIESEL, EXPENDIO'=>'GASOLINERIA Y/O DIESEL, EXPENDIO',
                                                  'HARINAS DE ORIGEN ANIMAL, FABRICA DE'=>'HARINAS DE ORIGEN ANIMAL, FABRICA DE',
                                                  'HARINAS VEGETALES, FABRICA DE'=>'HARINAS VEGETALES, FABRICA DE',
                                                  'HELADOS, NIEVES Y PALETAS, BODEGA Y/O EXPENDIO'=>'HELADOS, NIEVES Y PALETAS, BODEGA Y/O EXPENDIO',
                                                  'HELADOS, NIEVES Y PALETAS, FABRICA'=>'HELADOS, NIEVES Y PALETAS, FABRICA',
                                                  'HERRERIA, TALLER Y/O EXPENDIO DE'=>'HERRERIA, TALLER Y/O EXPENDIO DE',
                                                  'HIELO, EXPENDIO Y/O BODEGA'=>'HIELO, EXPENDIO Y/O BODEGA',
                                                  'HIELO, FABRICA DE'=>'HIELO, FABRICA DE',
                                                  'HOJALATERIA, TALLER DE'=>'HOJALATERIA, TALLER DE',
                                                  'HOSPITAL Y/O SANATORIO'=>'HOSPITAL Y/O SANATORIO',
                                                  'HOTEL'=>'HOTEL',
                                                  'HUEVO, BODEGA Y/O EXPENDIO'=>'HUEVO, BODEGA Y/O EXPENDIO',
                                                  'HULE ARTICULOS DE, BODEGA Y/O EXPENDIO'=>'HULE ARTICULOS DE, BODEGA Y/O EXPENDIO',
                                                  'HULE FABRICA DE'=>'HULE FABRICA DE',
                                                  'IGLESIA Y/O TEMPLO Y/O CONVENTO'=>'IGLESIA Y/O TEMPLO Y/O CONVENTO',
                                                  'IMPERMEABILIZANTES, FABRICACION DE'=>'IMPERMEABILIZANTES, FABRICACION DE',
                                                  'IMPRENTA Y/O LITOGRAFIA'=>'IMPRENTA Y/O LITOGRAFIA',
                                                  'INSECTICIDAS, PLANTA MEZCLADORA'=>'INSECTICIDAS, PLANTA MEZCLADORA',
                                                  'INSTRUMENTOS MUSICALES, BODEGA Y/O EXPENDIO'=>'INSTRUMENTOS MUSICALES, BODEGA Y/O EXPENDIO',
                                                  'INSTRUMENTOS MUSICALES, FABRICA'=>'INSTRUMENTOS MUSICALES, FABRICA',
                                                  'INVERNADERO'=>'INVERNADERO',
                                                  'JARCIERIA'=>'JARCIERIA',
                                                  'JOYERIA Y/O RELOJERIA, BODEGA Y/O EXPENDIO'=>'JOYERIA Y/O RELOJERIA, BODEGA Y/O EXPENDIO',
                                                  'JOYERIA Y/O RELOJERIA, FABRICA Y/O TALLER'=>'JOYERIA Y/O RELOJERIA, FABRICA Y/O TALLER',
                                                  'JUGUETERIA, BODEGA Y/O EXPENDIO'=>'JUGUETERIA, BODEGA Y/O EXPENDIO',
                                                  'JUGUETERIA, FABRICACION DE'=>'JUGUETERIA, FABRICACION DE',
                                                  'LABORATORIO'=>'LABORATORIO',
                                                  'LADRILLOS Y TEJAS, FABRICA DE'=>'LADRILLOS Y TEJAS, FABRICA DE',
                                                  'LAVANDERIA'=>'LAVANDERIA',
                                                  'LECHE Y SUS DERIVADOS, BODEGA Y/O EXPENDIO'=>'LECHE Y SUS DERIVADOS, BODEGA Y/O EXPENDIO',
                                                  'LECHE Y SUS DERIVADOS, FABRICA DE'=>'LECHE Y SUS DERIVADOS, FABRICA DE',
                                                  'LEVADURAS, FABRICACION'=>'LEVADURAS, FABRICACION',
                                                  'LIBRERIA'=>'LIBRERIA',
                                                  'LLANTAS Y CAMARAS, BODEGA Y/O EXPENDIO'=>'LLANTAS Y CAMARAS, BODEGA Y/O EXPENDIO',
                                                  'LLANTAS, FABRICACION DE'=>'LLANTAS, FABRICACION DE',
                                                  'MADERA, BODEGA Y/O EXPENDIO'=>'MADERA, BODEGA Y/O EXPENDIO',
                                                  'MADERA, FABRICA DE ARTICULOS DE'=>'MADERA, FABRICA DE ARTICULOS DE',
                                                  'MAQUINARIA AGRICOLA INDUST.REFACC.ACC.EXPENDIO'=>'MAQUINARIA AGRICOLA INDUST.REFACC.ACC.EXPENDIO',
                                                  'MAQUINARIA AGRICOLA TRABAJANDO EN EL CAMPO'=>'MAQUINARIA AGRICOLA TRABAJANDO EN EL CAMPO',
                                                  'MAQUINARIA, BODEGA Y/O EXPENDIO'=>'MAQUINARIA, BODEGA Y/O EXPENDIO',
                                                  'MAQUINARIA, FABRICACION Y/O ARMADO'=>'MAQUINARIA, FABRICACION Y/O ARMADO',
                                                  'MAQUINARIA, TALLER DE REPARACION'=>'MAQUINARIA, TALLER DE REPARACION',
                                                  'MAQUINAS PARA COSER Y ESCRIBIR, BODEGA Y/O EXPENDIO'=>'MAQUINAS PARA COSER Y ESCRIBIR, BODEGA Y/O EXPENDIO',
                                                  'MATERIAL PARA LA CONST. ACABADOS, BOD. Y/O EXP.'=>'MATERIAL PARA LA CONST. ACABADOS, BOD. Y/O EXP.',
                                                  'MATERIAL PARA LA CONST. OBRA NEGRA, BOD. Y/O EXP.'=>'MATERIAL PARA LA CONST. OBRA NEGRA, BOD. Y/O EXP.',
                                                  'MATERIAS PRIMAS PARA REPOSTERIA, BODEGA Y/O EXP.'=>'MATERIAS PRIMAS PARA REPOSTERIA, BODEGA Y/O EXP.',
                                                  'MATERIAS PRIMAS PARA REPOSTERIA, FABRICA'=>'MATERIAS PRIMAS PARA REPOSTERIA, FABRICA',
                                                  'MEDICINAS, BODEGA'=>'MEDICINAS, BODEGA',
                                                  'MERCADO PUBLICO'=>'MERCADO PUBLICO',
                                                  'METALES, BODEGA Y/O EXPENDIO'=>'METALES, BODEGA Y/O EXPENDIO',
                                                  'METALES, FABRICA CON FUNDICION'=>'METALES, FABRICA CON FUNDICION',
                                                  'METALES, FABRICA SIN FUNDICION'=>'METALES, FABRICA SIN FUNDICION',
                                                  'METALES, GALVANOPLASTIA'=>'METALES, GALVANOPLASTIA',
                                                  'MINERALES COMBUSTIBLES, BODEGA Y/O EXPENDIO'=>'MINERALES COMBUSTIBLES, BODEGA Y/O EXPENDIO',
                                                  'MINERALES COMBUSTIBLES, MINA Y/O BENEFICIO DE'=>'MINERALES COMBUSTIBLES, MINA Y/O BENEFICIO DE',
                                                  'MINERALES NO COMBUSTIBLES, BODEGA Y/O EXPENDIO'=>'MINERALES NO COMBUSTIBLES, BODEGA Y/O EXPENDIO',
                                                  'MINERALES NO COMBUSTIBLES, MINA Y/O BENEFICIO DE'=>'MINERALES NO COMBUSTIBLES, MINA Y/O BENEFICIO DE',
                                                  'MOLINO PARA MAIZ .NIXTAMAL.'=>'MOLINO PARA MAIZ .NIXTAMAL.',
                                                  'MOTOCICLETAS Y ACCESORIOS, BODEGA Y/O EXPENDIO'=>'MOTOCICLETAS Y ACCESORIOS, BODEGA Y/O EXPENDIO',
                                                  'MOTOCICLETAS, FABRICACION Y/O ARMADO Y/O TALLER'=>'MOTOCICLETAS, FABRICACION Y/O ARMADO Y/O TALLER',
                                                  'MOTORES, BODEGA Y/O EXPENDIO'=>'MOTORES, BODEGA Y/O EXPENDIO',
                                                  'MOTORES, FABRICA DE'=>'MOTORES, FABRICA DE',
                                                  'MUEBLERIA, BODEGA Y/O EXP. CON APARATOS ELECTRICOS'=>'MUEBLERIA, BODEGA Y/O EXP. CON APARATOS ELECTRICOS',
                                                  'MUEBLERIA, BODEGA Y/O EXP. SIN APARATOS ELECTRICOS'=>'MUEBLERIA, BODEGA Y/O EXP. SIN APARATOS ELECTRICOS',
                                                  'MUEBLES DE MADERA, FABRICACION DE'=>'MUEBLES DE MADERA, FABRICACION DE',
                                                  'MUEBLES, FABRICACION DE .EXCEPTO MADERA.'=>'MUEBLES, FABRICACION DE .EXCEPTO MADERA.',
                                                  'MUSEO'=>'MUSEO',
                                                  'OFICINAS GUBERNAMENTALES'=>'OFICINAS GUBERNAMENTALES',
                                                  'OFICINAS PARTICULARES'=>'OFICINAS PARTICULARES',
                                                  'OLEAGINOSAS, BODEGA Y/O EXPENDIO'=>'OLEAGINOSAS, BODEGA Y/O EXPENDIO',
                                                  'OLEAGINOSAS, MOLINO DE PASTA O DESCASCARADOR'=>'OLEAGINOSAS, MOLINO DE PASTA O DESCASCARADOR',
                                                  'OLEAGINOSAS, TOSTADOR DE'=>'OLEAGINOSAS, TOSTADOR DE',
                                                  'OPTICA, ARTICULOS DE, EXPENDIO'=>'OPTICA, ARTICULOS DE, EXPENDIO',
                                                  'OPTICA, ARTICULOS DE, FABRICA'=>'OPTICA, ARTICULOS DE, FABRICA',
                                                  'PAN, EXPENDIO'=>'PAN, EXPENDIO',
                                                  'PAN, FABRICACION DE'=>'PAN, FABRICACION DE',
                                                  'PAÑALES DESECHABLES, BODEGA Y/O EXPENDIO'=>'PAÑALES DESECHABLES, BODEGA Y/O EXPENDIO',
                                                  'PAÑALES DESECHABLES, FABRICA DE'=>'PAÑALES DESECHABLES, FABRICA DE',
                                                  'PAPEL Y/O CARTON DE DESPERDICIO, BODEGA'=>'PAPEL Y/O CARTON DE DESPERDICIO, BODEGA',
                                                  'PAPEL Y/O CARTON IMPERMEABILIZADO, BODEGA'=>'PAPEL Y/O CARTON IMPERMEABILIZADO, BODEGA',
                                                  'PAPEL Y/O CARTON, BODEGA'=>'PAPEL Y/O CARTON, BODEGA',
                                                  'PAPEL Y/O CARTON, FCA. DE, CON IMPERMEABILIZACION'=>'PAPEL Y/O CARTON, FCA. DE, CON IMPERMEABILIZACION',
                                                  'PAPEL Y/O CARTON, FCA. DE, SIN IMPERMEABILIZACION'=>'PAPEL Y/O CARTON, FCA. DE, SIN IMPERMEABILIZACION',
                                                  'PAPEL Y/O CARTON, SELECCIONADORA DE'=>'PAPEL Y/O CARTON, SELECCIONADORA DE',
                                                  'PAPELERIA'=>'PAPELERIA',
                                                  'PASTAS ALIMENTICIAS, BODEGA Y/O EXPENDIO'=>'PASTAS ALIMENTICIAS, BODEGA Y/O EXPENDIO',
                                                  'PASTAS ALIMENTICIAS, FABRICA DE'=>'PASTAS ALIMENTICIAS, FABRICA DE',
                                                  'PASTOS SECOS, BODEGA Y/O EXPENDIO'=>'PASTOS SECOS, BODEGA Y/O EXPENDIO',
                                                  'PEGAMENTOS, BODEGA Y/O EXPENDIO'=>'PEGAMENTOS, BODEGA Y/O EXPENDIO',
                                                  'PEGAMENTOS, FABRICA DE'=>'PEGAMENTOS, FABRICA DE',
                                                  'PERFUMES, BODEGA Y/O EXPENDIO'=>'PERFUMES, BODEGA Y/O EXPENDIO',
                                                  'PERFUMES, FABRICACION DE'=>'PERFUMES, FABRICACION DE',
                                                  'PERIODICOS Y REVISTAS, BODEGA Y/O EXPENDIO'=>'PERIODICOS Y REVISTAS, BODEGA Y/O EXPENDIO',
                                                  'PERIODICOS Y REVISTAS, EDITORA DE'=>'PERIODICOS Y REVISTAS, EDITORA DE',
                                                  'PESCADOS Y/O MARISCOS, BODEGA Y/O EXPENDIO'=>'PESCADOS Y/O MARISCOS, BODEGA Y/O EXPENDIO',
                                                  'PILONCILLO, ELABORACION DE'=>'PILONCILLO, ELABORACION DE',
                                                  'PINTURAS DE ACEITE, FABRICA DE'=>'PINTURAS DE ACEITE, FABRICA DE',
                                                  'PINTURAS VINILICAS, FABRICA DE'=>'PINTURAS VINILICAS, FABRICA DE',
                                                  'PINTURAS, TALLER ARTISTICO'=>'PINTURAS, TALLER ARTISTICO',
                                                  'PINTURAS, TINTAS, LACAS Y/O BARNICES BOD. Y/O EXP.'=>'PINTURAS, TINTAS, LACAS Y/O BARNICES BOD. Y/O EXP.',
                                                  'PISTA DE HIELO PARA PATINAJE'=>'PISTA DE HIELO PARA PATINAJE',
                                                  'PIZZERIA'=>'PIZZERIA',
                                                  'PLANTA DE ASFALTO'=>'PLANTA DE ASFALTO',
                                                  'PLASTICOS, ARTICULOS DE, BODEGA Y/O EXPENDIO'=>'PLASTICOS, ARTICULOS DE, BODEGA Y/O EXPENDIO',
                                                  'PLASTICOS, ARTICULOS DE, FABRICA'=>'PLASTICOS, ARTICULOS DE, FABRICA',
                                                  'POLLERIAS, BODEGA Y/O EXPENDIO'=>'POLLERIAS, BODEGA Y/O EXPENDIO',
                                                  'PULQUERIA'=>'PULQUERIA',
                                                  'PUROS, FABRICACION DE'=>'PUROS, FABRICACION DE',
                                                  'RADIODIFUSORA'=>'RADIODIFUSORA',
                                                  'RADIODIFUSORA, ANTENAS PARA, SEPARADAS'=>'RADIODIFUSORA, ANTENAS PARA, SEPARADAS',
                                                  'RANCHO'=>'RANCHO',
                                                  'RASTRO U OBRADOR'=>'RASTRO U OBRADOR',
                                                  'RECLUSORIO'=>'RECLUSORIO',
                                                  'REFACCIONES Y ACCESORIOS PARA AUTOMOTORES'=>'REFACCIONES Y ACCESORIOS PARA AUTOMOTORES',
                                                  'REFACCIONES Y ACCESORIOS PARA MAQUINARIA'=>'REFACCIONES Y ACCESORIOS PARA MAQUINARIA',
                                                  'REFRIGERADORA, PLANTA'=>'REFRIGERADORA, PLANTA',
                                                  'RESINAS, FABRICACION DE'=>'RESINAS, FABRICACION DE',
                                                  'RESTAURANTE Y/O BAR'=>'RESTAURANTE Y/O BAR',
                                                  'ROPA, BODEGA Y/O EXPENDIO Y/O RENTA'=>'ROPA, BODEGA Y/O EXPENDIO Y/O RENTA',
                                                  'ROPA, TALLER Y/O CONFECCION'=>'ROPA, TALLER Y/O CONFECCION',
                                                  'ROSTICERIA'=>'ROSTICERIA',
                                                  'SAL, BODEGA Y/O EXPENDIO'=>'SAL, BODEGA Y/O EXPENDIO',
                                                  'SAL, PLANTA EXTRACTORA Y/O REFINADORA'=>'SAL, PLANTA EXTRACTORA Y/O REFINADORA',
                                                  'SOMBREROS, BODEGA Y/O EXPENDIO'=>'SOMBREROS, BODEGA Y/O EXPENDIO',
                                                  'SOMBREROS, FABRICA DE, MATERIALES NO VEGETALES'=>'SOMBREROS, FABRICA DE, MATERIALES NO VEGETALES',
                                                  'TABACO, GALERAS DE'=>'TABACO, GALERAS DE',
                                                  'TABACO, SELECCIONADORA Y/O SECADORA'=>'TABACO, SELECCIONADORA Y/O SECADORA',
                                                  'TALLER MECANICO Y/O ELECTRICO'=>'TALLER MECANICO Y/O ELECTRICO',
                                                  'TAMALES, EXPENDIO'=>'TAMALES, EXPENDIO',
                                                  'TAPICERIA, TALLER DE'=>'TAPICERIA, TALLER DE',
                                                  'TAQUERIA Y/O TORTERIA'=>'TAQUERIA Y/O TORTERIA',
                                                  'TE, ENVASADO DE'=>'TE, ENVASADO DE',
                                                  'TELAS, BODEGA Y/O EXPENDIO'=>'TELAS, BODEGA Y/O EXPENDIO',
                                                  'TELEVISION, ANTENAS PARA, SEPARADAS'=>'TELEVISION, ANTENAS PARA, SEPARADAS',
                                                  'TELEVISION, DIFUSORA Y/O REPETIDORA'=>'TELEVISION, DIFUSORA Y/O REPETIDORA',
                                                  'TERMINAL DE TRANSPORTE DE PASAJEROS'=>'TERMINAL DE TRANSPORTE DE PASAJEROS',
                                                  'TEXTIL, FABRICA, CON ROMPEDORAS'=>'TEXTIL, FABRICA, CON ROMPEDORAS',
                                                  'TEXTIL, FABRICA, SIN ROMPEDORAS'=>'TEXTIL, FABRICA, SIN ROMPEDORAS',
                                                  'TINTORERIA Y/O PLANCHADURIA'=>'TINTORERIA Y/O PLANCHADURIA',
                                                  'TORNERIA'=>'TORNERIA',
                                                  'TORNILLERIA'=>'TORNILLERIA',
                                                  'TORTILLERIA'=>'TORTILLERIA',
                                                  'TRITURADORA DE PIEDRA, PLANTA'=>'TRITURADORA DE PIEDRA, PLANTA',
                                                  'VELAS, BODEGA Y/O EXPENDIO'=>'VELAS, BODEGA Y/O EXPENDIO',
                                                  'VELAS, FABRICA DE'=>'VELAS, FABRICA DE',
                                                  'VETERINARIA Y/O ESTETICA PARA ANIMALES'=>'VETERINARIA Y/O ESTETICA PARA ANIMALES',
                                                  'VIDEO JUEGOS, SALON DE'=>'VIDEO JUEGOS, SALON DE',
                                                  'VIDEOCLUB'=>'VIDEOCLUB',
                                                  'VIDRIO Y/O CRISTAL, BODEGA Y/O EXPENDIO'=>'VIDRIO Y/O CRISTAL, BODEGA Y/O EXPENDIO',
                                                  'VIDRIO Y/O CRISTAL, FABRICA DE'=>'VIDRIO Y/O CRISTAL, FABRICA DE',
                                                  'VIDRIO, FIBRA DE, EXPENDIO Y/O TALLER'=>'VIDRIO, FIBRA DE, EXPENDIO Y/O TALLER',
                                                  'VIDRIO, FIBRA DE, FABRICA'=>'VIDRIO, FIBRA DE, FABRICA',
                                                  'VINAGRE, ELABORACION DE'=>'VINAGRE, ELABORACION DE',
                                                  'VINOS Y LICORES, BODEGA Y/O EXPENDIO'=>'VINOS Y LICORES, BODEGA Y/O EXPENDIO',
                                                  'VINOS Y LICORES, FABRICA DE'=>'VINOS Y LICORES, FABRICA DE',
                                                  'VULCANIZADORA'=>'VULCANIZADORA',
                                                  'ZAPATERIA DE PIEL, FABRICA DE'=>'ZAPATERIA DE PIEL, FABRICA DE',
                                                  'ZAPATERIA PLASTICO Y/O TELA, FABRICA DE'=>'ZAPATERIA PLASTICO Y/O TELA, FABRICA DE',
                                                  'ZAPATERIA, BODEGA Y/O EXPENDIO'=>'ZAPATERIA, BODEGA Y/O EXPENDIO'
                                             ],
                                         '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'giro']  ) }}
                                           </div>
                                        </div>


                                        <div class="form-group">
                                          {{ Form::label('RFC','',array('class'=>"col-sm-3 control-label")) }}
                                          <div class="col-sm-8">
                                           {{ Form::text('rfc','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'rfc', 'maxlength'=>'14','minlength'=>'12')) }}
                                          </div>
                                        </div>



                                    <!--  esto o se para que sirve
                                    <div class="form-group">
                                           {{ Form::label('ref 1','',array('class'=>"col-sm-3 control-label")) }}
                                           <div class="col-sm-8">
                                               {{ Form::text('ref_1','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'ref_2')) }}
                                           </div>
                                        </div> -->                                     


                                        <div class="form-group">
                                    {{ Form::label('Estatus','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::select('estatus', [
                                        'Contacto' => 'Contacto',
                                        'Nocontacto' => 'No contacto'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'onchange'=>'LlenarSelect()']  ) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Motivo','',array('class'=>"col-sm-3 control-label")) }}
                                    <div class="col-sm-8">
                                        {{ Form::select('motivo', [],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'motivo','onchange'=>'motivoval()']  ) }}
                                    </div>
                                </div>

</div>
                                       <div class="form-group">
                                           <div class="col-sm-offset-6 col-sm-1">
                                               {{ Form::submit('Enviar',['class'=>"btn btn-default",'id'=>'submit']) }}
                                           </div>
                                       </div>

               {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('/assets/js/jquery-3_2_1.min.js')}}" ></script>
<script type="text/javascript">

function validar() {
    if($('#motivo').val() == 'Mascarilla no venta' || $('#motivo').val() == 'Mascarilla venta'){
    if($('#contra').val() != '16131714'){
      return false;
    }
  }
}


$("#fecnacaseg").blur(function () {
  // alert($( this ).val().substr(0,4));
  var mes = parseInt($( this ).val().substr(5,2));
  var dia = parseInt($( this ).val().substr(8,2));
  var ano = parseInt($( this ).val().substr(0,4));
  // alert('Dia: ' + dia + ' Mes: ' + mes +  ' Año: ' + ano);
  fecha_hoy = new Date();
  ahora_ano = fecha_hoy.getYear();
  ahora_mes = fecha_hoy.getMonth();
  ahora_dia = fecha_hoy.getDate();
  edad = (ahora_ano + 1900) - ano;

  if ( ahora_mes < (mes - 1)){
    edad--;
  }
  if (((mes - 1) == ahora_mes) && (ahora_dia < dia)){
    edad--;
  }
  if (edad > 1900){
    edad -= 1900;
  }
  if(edad < 18 || edad > 64 ){
      alert("Edad no permitida: " + edad + " años!");
      $( this ).val('')
  }


});

$("#telefono").change(function () {
  var url="{{URL('/InbursaSoluciones/buscar/venta/')}}" + "/" + $( this ).val();

  $.get( url, function( data ) {
    if (data>0) {
      alert("El número ya esta en la base de ventas");
      $("#telefono").val('');
    }
  });

});

</script>


<script type="text/javascript">

function datosastriskSoluciones() {
  $.ajax({
    url: "/Inbursa_soluciones/datosEmpresa2",
    type: 'get',
    beforeSend: function () {
      console.log('hay voy');
    },
    success: function (data) {
      console.log('si hay');
      console.log(data);
      console.log(data[0]['correo1']);


      if (data != '') {

        $("#numero").val(data[0]['telefonos']);
        $("#contenido").show();
        $("#ap_paterno").val(data[0]['apellidos01']);
        $("#ap_materno").val(data[0]['apellidos12']);
        $("#nombre").val(data[0]['nombre1']);
        $("#correo").val(data[0]['correo1']);
        $("#direccion").val(data[0]['calle']);
        $("#state").val(data[0]['estado']);
        $("#town").val(data[0]['municipio']);
        $("#col").val(data[0]['colonia']);
        $("#cp").val(data[0]['cp']);
        $("#nombre_empresa").val(data[0]['marca']);
        $("#rfc").val(data[0]['rfc']);

      }

    }

  });

}

function compval() {
  //compañia celular
   //console.log($('#ref_1_num').val());
  // console.log($('#ref_1_tel').val());
  console.log($('#comp_cel').val());

  if ($('#comp_cel').val()=="OTRO") {
    $('#otra_comp_cel').prop('required',true);
    $('#otra_comp_cel').prop('readonly',false);
  }
  else {
    $('#otra_comp_cel').prop('required',false);
    $('#otra_comp_cel').prop('readonly',true);
  }
}



function motivoval() {
 console.log($('#motivo').val());
  if ($('#motivo').val()=="Mascarilla venta" || $('#motivo').val()=="Mascarilla no venta") {
  $('#divPass').attr("style",'');
  $('#contra').prop('required',true);

  $('#contenido').attr("style",'display:none');
  $("#aceptaventa").prop('disabled', true);

  $('#ap_paterno').prop('required',false);
  $('#ap_materno').prop('required',false);
  $('#nombre').prop('required',false);
  $('#fecnacaseg').prop('required',false);
  $('#sexo').prop('required',false);
  $('#autoriza').prop('required',false);
  $('#parentesco').prop('required',false);
  $('#direccion').prop('required',false);
  $('#vialidad').prop('required',false);
  $('#vivienda').prop('required',false);
  $('#asentamien').prop('required',false);
  $('#piso').prop('required',false);
  $('#state').prop('required',false);
  $('#town').prop('required',false);
  $('#col').prop('required',false);
  $('#cp').prop('required',false);
  $('#ref_2').prop('required',false);
  $('#turno').prop('required',false);
  $('#num_pisos').prop('required',false);
  $('#ref_1_num').prop('required',false);
  $('#ref_1_tel').prop('required',false);
}
  else if ($('#motivo').val()=="Venta") {
     console.log('Si Venta');
    $('#divPass').attr("style",'display:none');
    $('#contra').prop('required',false);

    $('#contenido').attr("style",'');
    // $('#contenido').prop('required',true);
    $('#ap_paterno').prop('required',true);
    $('#ap_materno').prop('required',true);
    $('#nombre').prop('required',true);
    $('#fecnacaseg').prop('required',true);
    $('#sexo').prop('required',true);
    $('#autoriza').prop('required',true);
    $('#parentesco').prop('required',true);
    $('#direccion').prop('required',true);
    // $('#num_ext').prop('required',true);
    $('#vialidad').prop('required',true);
    $('#vivienda').prop('required',true);
    // $('#numint').prop('required',true);
    $('#asentamien').prop('required',true);
    $('#piso').prop('required',true);
    $('#state').prop('required',true);
    $('#town').prop('required',true);
    $('#col').prop('required',true);
    $('#cp').prop('required',true);
    // $('#calle_1').prop('required',true);
    // $('#calle_2').prop('required',true);
    $('#ref_2').prop('required',true);
    $('#turno').prop('required',true);
    $('#num_pisos').prop('required',true);
    $('#ref_1_num').prop('required',true);
    $('#ref_1_tel').prop('required',true);

  }

}

</script>
<script type="text/javascript">



function LlenarSelect()
      {
        
        var listdesp  = document.forms.formulario.estatus.selectedIndex;
        //alert(list)
        console.log(listdesp);

        formulario.motivo.length=0;
        
        if(listdesp==1) ListaDes1();
        
        if(listdesp==2) ListaDes2();

      }

      function ListaDes1(){

        opcion0=new Option("No le interesa","No le interesa","defauldSelected");
        opcion1=new Option("Cuelga","Cuelga");
        opcion2=new Option("No cubre requisitos","No cubre requisitos");
        opcion3=new Option("Cliente molesto","Cliente molesto");
        opcion4=new Option("Lo pensara","Lo pensara");
        opcion5=new Option("Pide no volver a llamar","Pide no volver a llamar");
        opcion6=new Option("Venta caida","Venta caida");
        opcion7=new Option("Venta","Venta");
        opcion8=new Option("Mascarilla venta","Mascarilla venta");
        opcion9=new Option("Mascarilla no venta","Mascarilla no venta");


        document.forms.formulario.motivo.options[0]=opcion0;
        document.forms.formulario.motivo.options[1]=opcion1;
        document.forms.formulario.motivo.options[2]=opcion2;
        document.forms.formulario.motivo.options[3]=opcion3;
        document.forms.formulario.motivo.options[4]=opcion4;
        document.forms.formulario.motivo.options[5]=opcion5;
        document.forms.formulario.motivo.options[6]=opcion6;
        document.forms.formulario.motivo.options[7]=opcion7;
        document.forms.formulario.motivo.options[8]=opcion8;
        document.forms.formulario.motivo.options[9]=opcion9;
      }

      function ListaDes2(){
        opcion0=new Option("Buzón","Buzón","defauldSelected");
        opcion1=new Option("Numero inexistente","Numero inexistente");
        opcion2=new Option("No contesta","No contesta");
        opcion3=new Option("Fax","Fax");
        opcion4=new Option("Ya cuenta con el servicio","Ya cuenta con el servicio");
        opcion5=new Option("Remarcación","Remarcación");

        document.forms.formulario.motivo.options[0]=opcion0;
        document.forms.formulario.motivo.options[1]=opcion1;
        document.forms.formulario.motivo.options[2]=opcion2;
        document.forms.formulario.motivo.options[3]=opcion3;
        document.forms.formulario.motivo.options[4]=opcion4;
        document.forms.formulario.motivo.options[5]=opcion5;
      }



</script>
@stop
