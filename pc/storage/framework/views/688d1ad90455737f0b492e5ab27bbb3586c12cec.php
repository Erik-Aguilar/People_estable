<?php $__env->startSection('content'); ?>
<?php
$value = Session::all();
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Validacion Inbursa  | <?php echo e($value['nombre_completo']); ?></h3>
            </div>
            <div class="panel-body">

            <?php echo e(Form::open(['action' => 'InbursaSolucionesController@UpdateFromularioInbSoluciones',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name' => "formulario"
                            ])); ?>


                            <div class="form-group">
                                  <?php echo e(Form::label('Folio','',array('class'=>"col-sm-3 control-label"))); ?>

                                  <div class="col-sm-8">
                                      <?php echo e(Form::text('id',$datos[0]->id,array( 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                                  </div>
                              </div>

                              <div class="form-group">
                                  <?php echo e(Form::label('Telefono','',array('class'=>"col-sm-3 control-label"))); ?>

                                  <div class="col-sm-8">
                                      <?php echo e(Form::text('telefono',$datos[0]->telefono,array('class'=>"form-control", 'placeholder'=>"",'id'=>'telefono','maxlength'=>'10','minlength'=>'10'))); ?>

                                  </div>
                              </div>

                              <div class="form-group">
                                  <?php echo e(Form::label('apellido paterno','',array('class'=>"col-sm-3 control-label"))); ?>

                                  <div class="col-sm-8">
                                      <?php echo e(Form::text('ap_paterno',$datos[0]->ap_paterno,array('class'=>"form-control",'id'=>'ap_paterno'))); ?>

                                  </div>
                              </div>

                              <div class="form-group">
                                  <?php echo e(Form::label('apellido materno','',array('class'=>"col-sm-3 control-label"))); ?>

                                  <div class="col-sm-8">
                                      <?php echo e(Form::text('ap_materno',$datos[0]->ap_materno,array('class'=>"form-control",'id'=>'ap_materno'))); ?>

                                  </div>
                              </div>

                              <div class="form-group">
                                  <?php echo e(Form::label('nombre','',array('class'=>"col-sm-3 control-label"))); ?>

                                  <div class="col-sm-8">
                                      <?php echo e(Form::text('nombre',$datos[0]->nombre,array('class'=>"form-control",'id'=>'nombre'))); ?>

                                  </div>
                              </div>

                              <div class="form-group">
                                  <?php echo e(Form::label('fecha nacimiento','',array('class'=>"col-sm-3 control-label"))); ?>

                                  <div class="col-sm-8">
                                      <?php echo e(Form::date('fecnacaseg',$datos[0]->fech_nac,array('class'=>"form-control",'id'=>'fech_nac'))); ?>

                                  </div>
                              </div>

                              <div class="form-group">
                                  <?php echo e(Form::label('Sexo','',array('class'=>"col-sm-3 control-label"))); ?>

                                  <div class="col-sm-8">
                                      <?php echo e(Form::select('sexo', [
                                      'M' => 'Masculino',
                                      'F' => 'Femenino'],$datos[0]->sexo, ['class'=>"form-control", 'placeholder'=>"",'id'=>'sexo']  )); ?>

                                  </div>
                              </div>

                              <div class="form-group">
                                  <?php echo e(Form::label('Nombre de la persona que autoriza el seguro','',array('class'=>"col-sm-3 control-label"))); ?>

                                  <div class="col-sm-8">
                                      <?php echo e(Form::text('autoriza',$datos[0]->autoriza,array('class'=>"form-control", 'placeholder'=>"",'id'=>'autoriza'))); ?>

                                  </div>
                              </div>

                              <div class="form-group">
                                <?php echo e(Form::label('Parentesco','',array('class'=>"col-sm-3 control-label"))); ?>

                                <div class="col-sm-8">
                                    <?php echo e(Form::select('parentesco', [
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
                                    ],$datos[0]->parentesco, ['class'=>"form-control", 'placeholder'=>"",'id'=>'parentesco']  )); ?>

                                </div>
                              </div>

                              <div class="form-group">
                                  <?php echo e(Form::label('Correo Electrónico','',array('class'=>"col-sm-3 control-label"))); ?>

                                  <div class="col-sm-8">
                                      <?php echo e(Form::email('correo',$datos[0]->correo,array('class'=>"form-control",'id'=>'correo'))); ?>

                                  </div>
                              </div>

                              <div class="form-group">
                                  <?php echo e(Form::label('Fecha en que se hizo el movimiento','',array('class'=>"col-sm-3 control-label"))); ?>

                                  <div class="col-sm-8">
                                      <?php echo e(Form::date('fecha_capt',$datos[0]->fecha_capt,array('class'=>"form-control", 'placeholder'=>"",'id'=>'fecha_capt','readonly'=>'readonly'))); ?>

                                  </div>
                              </div>

                              <div class="form-group">
                                  <?php echo e(Form::label('Dirección','',array('class'=>"col-sm-3 control-label"))); ?>

                                  <div class="col-sm-8">
                                      <?php echo e(Form::text('direccion',$datos[0]->direccion,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'direccion'))); ?>

                                  </div>
                              </div>


                              <div class="form-group">
                                  <?php echo e(Form::label('Vialidad','',array('class'=>"col-sm-3 control-label"))); ?>

                                  <div class="col-sm-8">
                                      <?php echo e(Form::select('vialidad', [
                                      'AND '=>'ANDADOR',
                                        'AUT '=>'AUTOPISTA',
                                        'AV '=>'AVENIDA',
                                        'BJD '=>'BAJADA',
                                        'BLV '=>'BOULEVARD',
                                        'CALZ '=>'CALZADA',
                                        'CALLE  (SIN ABREVIATURA)'=>'CALLE',
                                        'CJON '=>'CALLEJON',
                                        'CAM '=>'CAMINO',
                                        'CARR '=>'CARRETERA',
                                        'CDA '=>'CERRADA',
                                        'CTO '=>'CIRCUITO',
                                        'CVLN'=>'CIRCUNVALACION',
                                        'CRO '=>'CRUCERO',
                                        'CUCH '=>'CUCHILLA',
                                        'DIAG '=>'DIAGONAL',
                                        'EJE '=>'EJE',
                                        'GTA '=>'GLORIETA',
                                        'JDN '=>'JARDIN',
                                        'LIB '=>'LIBRAMIENTO',
                                        'PRJ '=>'PARAJE',
                                        'PARQ '=>'PARQUE',
                                        'PSJ '=>'PASAJE',
                                        'PSO '=>'PASEO',
                                        'PERIF '=>'PERIFERICO',
                                        'PZA '=>'PLAZA',
                                        'PRIV '=>'PRIVADA',
                                        'PROL '=>'PROLONGACION',
                                        'RML '=>'RAMAL',
                                        'RET '=>'RETORNO',
                                        'RCDA '=>'RINCONADA',
                                        'VDA '=>'VEREDA',
                                        'VIA '=>'VIA',
                                        'VDTO '=>'VIADUCTO'
                                        ],
                                  $datos[0]->vialidad, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'vialidad']  )); ?>

                                  </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Vivienda','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::select('vivienda', [
                                          'NEG' => 'NEGOCIO'
                                        ],
                                    $datos[0]->vivienda, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'vivienda']  )); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Número interior','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('num_int',$datos[0]->num_int,array('class'=>"form-control", 'placeholder'=>"",'id'=>'num_int'))); ?>

                                    </div>
                                </div>


                                <div class="form-group">
                                    <?php echo e(Form::label('Piso','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::text('piso',$datos[0]->piso,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'piso'))); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Tipo de asentamiento','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::select('asentamiento', [
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
                                          'ZURB'=>'Zona Urbana'
                                        ],
                                    $datos[0]->asentamiento, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'asentamiento']  )); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo e(Form::label('Estado','',array('class'=>"col-sm-3 control-label"))); ?>

                                    <div class="col-sm-8">
                                        <?php echo e(Form::select('estado', [
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
                                    $datos[0]->estado, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'estado']  )); ?>

                                    </div>
                                  </div>

                                  <div class="form-group">
                                      <?php echo e(Form::label('Delegación/Municipio','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                          <?php echo e(Form::text('ciudad',$datos[0]->ciudad,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'ciudad'))); ?>

                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <?php echo e(Form::label('Colonia','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                          <?php echo e(Form::text('colonia',$datos[0]->colonia,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'col'))); ?>

                                      </div>
                                    </div>

                                    <div class="form-group">
                                        <?php echo e(Form::label('Codigo Postal','',array('class'=>"col-sm-3 control-label"))); ?>

                                        <div class="col-sm-8">
                                            <?php echo e(Form::text('cp',$datos[0]->cp,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'cp'))); ?>

                                        </div>
                                  </div>

                                  <div class="form-group">
                                      <div class="col-sm-10" style='text-align: center;'>
                                      <?php echo e(Form::label('Entr� calles','',array('class'=>"control-label"))); ?>

                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <?php echo e(Form::label('Calle 1','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                          <?php echo e(Form::text('calle_1',$datos[0]->calle_1,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'calle_1'))); ?>

                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <?php echo e(Form::label('Calle 2','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                          <?php echo e(Form::text('calle_2',$datos[0]->calle_2,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'calle_2'))); ?>

                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <div class="col-sm-10" style='text-align: center;'>
                                      <?php echo e(Form::label('Referencias Principales del Domicilio Asegurado','',array('class'=>"control-label"))); ?>

                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <?php echo e(Form::label('Referencia 1','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                          <?php echo e(Form::text('ref_1',$datos[0]->ref_1,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'ref_1'))); ?>

                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <?php echo e(Form::label('Referencia 2','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                          <?php echo e(Form::text('ref_2',$datos[0]->ref_2,array( 'class'=>"form-control", 'placeholder'=>"",'id'=>'ref_2'))); ?>

                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <?php echo e(Form::label('RVT','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                          <?php echo e(Form::text('rvt',$datos[0]->rvt,array( 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly'))); ?>

                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <?php echo e(Form::label('Validador','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                          <?php echo e(Form::text('validador',$value['user'],array( 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <?php echo e(Form::label('# de pisos de la construcción','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                          <?php echo e(Form::text('num_pisos',$datos[0]->num_pisos,array( 'class'=>"form-control", 'placeholder'=>"",'title'=>'La planta baja cuenta como Piso 1','id'=>'pisos'))); ?>

                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <?php echo e(Form::label('Número celular','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                          <?php echo e(Form::text('num_cel',$datos[0]->num_cel,array('maxlength'=>'10', 'class'=>"form-control", 'placeholder'=>"",'title'=>'La planta baja cuenta como Piso 1','id'=>'pisos'))); ?>

                                      </div>
                                  </div>


                                  <div class="form-group">
                                      <?php echo e(Form::label('Compañia celular','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                        <?php echo e(Form::select('num_cel', [
                                             'TELCEL' => 'TELCEL',
                                             'IUSACELL' => 'IUSACELL',
                                             'TELEFONICA_MOVISTAR' => 'TELEFONICA MOVISTAR',
                                             'UNEFON' => 'UNEFON',
                                             'OTRO' => 'OTRO',
                                             'ATT' => 'AT&amp;T',
                                             'NEXTEL' => 'NEXTEL',
                                             'VIRGIN' => 'VIRGIN'],
                                              $datos[0]->comp_cel, ['class'=>"form-control", 'placeholder'=>"",'id'=>'num_cel','onchange'=>'compval()']  )); ?>  
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <?php echo e(Form::label('Otra compañia','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">                                      
                                         <?php echo e(Form::text('otra_comp_cel',$datos[0]->otra_comp_cel,array('class'=>"form-control",'placeholder'=>"Nombre de la otra compañia telefonica",'id'=>'otra_comp_cel'))); ?>

                                       </div>
                                  </div>

                                  <!-- <div class="form-group">
                                      <?php echo e(Form::label('Estatus interno','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                          <?php echo e(Form::select('estatus', [
                                          '1' => 'VENTA',
                                          '2' => 'VENTA EN PROCESO',
                                          '3'=>'RECHAZO EN VALIDACION',
                                          '4'=>'RECUPERAR',
                                          '5'=>'RECUPERADA',
                                          '6'=>'RECUPERACION FALLIADA',
                                          '7'=>'CANCELADA'],
                                      '', ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                                      </div>
                                  </div> -->



                                  <div class="form-group">
                                          <?php echo e(Form::label('Nombre empresa','',array('class'=>"col-sm-3 control-label"))); ?>

                                          <div class="col-sm-8">
                                           <?php echo e(Form::text('nombre_empresa',$datos[0]->nomb_com,array('class'=>"form-control", 'placeholder'=>"",'id'=>'nombre_empresa'))); ?>

                                          </div>
                                        </div>


                                        <div class="form-group">
                                           <?php echo e(Form::label('Giro Comercial','',array('class'=>"col-sm-3 control-label"))); ?>

                                           <div class="col-sm-8">
                                             <?php echo e(Form::select('giro', [
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
                                         $datos[0]->giro_com, ['class'=>"form-control", 'placeholder'=>"",'id'=>'giro']  )); ?>

                                           </div>
                                        </div>


                                        <div class="form-group">
                                          <?php echo e(Form::label('RFC','',array('class'=>"col-sm-3 control-label"))); ?>

                                          <div class="col-sm-8">
                                           <?php echo e(Form::text('rfc',$datos[0]->rfc,array('class'=>"form-control", 'placeholder'=>"",'id'=>'rfc', 'maxlength'=>'14','minlength'=>'12'))); ?>

                                          </div>
                                        </div>


                                  <div class="form-group">
                                      <?php echo e(Form::label('Estatus interno','',array('class'=>"col-sm-3 control-label"))); ?>

                                      <div class="col-sm-8">
                                          <?php echo e(Form::select('estatus', [
                                          'Venta' => 'Venta',
                                          'Venta en proceso' => 'Venta en proceso',
                                          'Rechazo en validacion'=>'Rechazo en validacion',
                                          'Recuperar'=>'Recuperar',
                                          'Recuperada'=>'Recuperada',
                                          'Recuperacion fallida'=>'Recuperacion fallida',
                                          'Cancelada'=>'Cancelada'],
                                      $datos[0]->estatus_people_2, ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                                      </div>
                                  </div>


                                  <div class="form-group">
                                      <div class="col-sm-offset-5 col-sm-1">
                                          <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default","onClick"=>'return valida()','id'=>'submit'])); ?>

                                      </div>
                                  </div>


                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>


<script src="<?php echo e(asset('/assets/js/jquery-3_2_1.min.js')); ?>" ></script>
<script type="text/javascript">

function compval() {
  //compañia celular
   //console.log($('#ref_1_num').val());
  // console.log($('#ref_1_tel').val());
  console.log($('#num_cel').val());

  if ($('#num_cel').val()=="OTRO") {
    $('#otra_comp_cel').prop('required',true);
    $('#otra_comp_cel').prop('readonly',false);
  }
  else {
    $('#otra_comp_cel').prop('required',false);
    $('#otra_comp_cel').prop('readonly',true);
  }
}



</script>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.inbursaSoluciones.validador.validador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>