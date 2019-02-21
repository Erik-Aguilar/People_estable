<?php $__env->startSection('content'); ?>
<style media="screen">
  div{
    font-size: 12px;
  }
</style>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

              <?php echo e(Form::open(['action' => 'BoBanamexController@BoRecuperacion',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario"
                          ])); ?>



              <div class="form-group"  align='Center'>
                  <?php echo e(Form::label('Telefono','',array('class'=>"col-sm-1 control-label"))); ?>

                  <div class="col-sm-4">
                        <?php echo e(Form::text('tel',$datos[0]->dn,array('class'=>"form-control",  'placeholder'=>"",'readonly'=>'readonly','id'=>'nombre'))); ?>

                  </div>
				  <?php echo e(Form::label('No. de Venta','',array('class'=>"col-sm-1 control-label"))); ?>

				  <div class="col-sm-4">
                        <?php echo e(Form::text('venta',$datos[0]->v_id,array('class'=>"form-control",  'placeholder'=>"",'readonly'=>'readonly','id'=>'nombre'))); ?>

                  </div>
              </div>

                <div id="exist"> <!-- si encuentra dn -->

                  <div id="cos"> <!--Cliente_objetivo Si  -->

                    <div class="form-group">
                        <?php echo e(Form::label('Datos Personales','',array('class'=>"col-sm-2 control-label"))); ?>

                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Email*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('email_co', $datos[0]->email, array('id'=>'email_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                        <?php echo e(Form::label('Confirmacion Email*','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('confirmEmail_co', $datos[0]->email, array('id'=>'confirmEmail_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onBlur'=>'validaEmail()'))); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Nombre*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('nombre_co', $datos[0]->nombre, array('id'=>'nombre_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                        <?php echo e(Form::label('Apellido Paterno*','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('paterno_co', $datos[0]->paterno, array('id'=>'paterno_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Apellido Materno*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('materno_co', $datos[0]->materno, array('id'=>'materno_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                        <?php echo e(Form::label('Fecha nacimiento*','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                          <?php echo e(Form::date('fecha_cumple', $datos[0]->fecha_nacimiento,array('class'=>"form-control", 'placeholder'=>"********"))); ?>

                        </div>
                    </div>

                    
                    <div class="form-group">
                        <?php echo e(Form::label('RFC*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('rfc_co', $datos[0]->rfc, array('id'=>'rfc_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                        <?php echo e(Form::label('Homoclave del RFC','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('homoclave_co', $datos[0]->homoclave, array('id'=>'homoclave_co', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Telefono celular*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('telCelular_co', $datos[0]->telefono,array('id'=>'telCelular_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                    </div>


                    <!-- ***************************************************** -->
                    <div class="form-group">
                        <?php echo e(Form::label('Domicilio','',array('class'=>"col-sm-2 control-label"))); ?>

                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Calle*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('calle_co', $datos[0]->calle, array('id'=>'calle_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                        <?php echo e(Form::label('No. exterior*','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('noExt_co', $datos[0]->no_ext, array('id'=>'noExt_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('No. interior','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('noInt_co', $datos[0]->no_int, array('id'=>'noInt_co','class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                        <?php echo e(Form::label('CP*','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('cp_co', $datos[0]->cp, array('id'=>'cp_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address()'))); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Colonia*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::select('colonia_co', [ ],
                            $datos[0]->colonia, ['id'=>'colonia_co', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                        </div>
                        <?php echo e(Form::label('Tipo Vivienda*','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                          <?php echo e(Form::select('tipoVivienda_co', [
                          'Vivienda de un familiar'=>'Vivienda de un familiar',
                          'Vivienda hipotecada'=>'Vivienda hipotecada',
                          'Vivienda propia'=>'Vivienda propia',
                          'Vivienda rentada'=>'Vivienda rentada'],
                          $datos[0]->tipo_vivienda, ['id'=>'tipoVivienda_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Tiempo de residencia*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                          <?php echo e(Form::select('tiempoResidencia_co', [
                          '1'=>'1 año',
                          '2'=>'2 años',
                          '3'=>'3 años',
                          '4'=>'4 años',
                          '5'=>'5 años',
                          '6'=>'6 años',
                          '7'=>'7 años',
                          '8'=>'8 años',
                          '9'=>'9 años',
                          '10'=>'10 años',
                          '11'=>'11 años',
                          '12'=>'12 años',
                          '13'=>'13 años',
                          '14'=>'14 años',
                          '15'=>'15 años',
                          '16'=>'16 años',
                          '17'=>'17 años',
                          '18'=>'18 años',
                          '19'=>'19 años',
                          '20'=>'20 años o más'],
                          $datos[0]->residencia, ['id'=>'tiempoResidencia_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""] )); ?>

                        </div>
                        <?php echo e(Form::label('lada domicilio','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('ladaDomi_co', $datos[0]->lada,array('id'=>'ladaDomi_co','class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('telefono*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('telDom_co', $datos[0]->tel_domicilio,array('id'=>'telDom_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address()'))); ?>

                        </div>
                    </div>

                    <!-- *********************** -->
                    <div class="form-group">
                        <?php echo e(Form::label('Información Financiera','',array('class'=>"col-sm-2 control-label"))); ?>

                    </div>

                    <div class="form-group">
                      <?php echo e(Form::label('¿Tiene tarjeta de credito?','',array('class'=>"col-sm-4 col-md-offset-1  control-label"))); ?>

                      <div class="col-sm-4 col-md-offset-1">
                        <?php echo e(Form::select('tieneTarjeta_co', [
                        ''=>'',
                        'Si'=>'Si',
                        'No'=>'No'
                        ],
                        $datos[0]->tiene_tarjeta, ['id'=>'tieneTarjeta', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                      </div>
                    </div>

                    <div class="form-group">
                      <?php echo e(Form::label('¿Tienes alguna tarjeta de credito?(no nómina o débito) ','',array('class'=>"col-sm-4 col-md-offset-1  control-label"))); ?>


                      <?php echo e(Form::label('Numero de tarjeta(ultimos 4 digitos)','',array('class'=>"col-sm-5 control-label"))); ?>

                    </div>

                    <div class="form-group">
                        <div class="col-sm-4 col-md-offset-1">
                          <?php echo e(Form::select('tipoTarjeta_co', [
                          'Bancarias'=>array(
                          'American Express'=>'American Express',
                          'Citibanamex'=>'Citibanamex',
                          'Banca Afirme'=>'Banca Afirme',
                          'Banco de Bajito'=>'Banco de Bajito',
                          'Banco ge Capital'=>'Banco ge Capital',
                          'Banco Mifel'=>'Banco Mifel',
                          'Banco Union'=>'Banco Union',
                          'Banjercito'=>'Banjercito',
                          'Banorte'=>'Banorte',
                          'Banregio'=>'Banregio',
                          'BBVA Bancomer'=>'BBVA Bancomer',
                          'Citi Bank'=>'Citi Bank',
                          'HSBC'=>'HSBC',
                          'Inbursa'=>'Inbursa',
                          'Invex'=>'Invex',
                          'Ixe Banco'=>'Ixe Banco',
                          'Santander - Serfin'=>'Santander - Serfin',
                          'Scotiabank Inverlat'=>'Scotiabank Inverlat'),
                          'Departamentales'=>array(
                          'CyA'=>'CyA',
                          'Comercial Mexicana'=>'Comercial Mexicana',
                          'Credimatico'=>'Credimatico',
                          'Fabricas de Francia'=>'Fabricas de Francia',
                          'HEB'=>'HEB',
                          'Hermanos Vazquez'=>'Hermanos Vazquez',
                          'Liverpool'=>'Liverpool',
                          'Palacio de Hierro'=>'Palacio de Hierro',
                          'Sears'=>'Sears',
                          'Soriana'=>'Soriana',
                          'Suburbia'=>'Suburbia',
                          'Walmart'=>'Walmart',
                          'Woolworth'=>'Woolworth',
                          'Otros'=>'Otros')],
                          $datos[0]->tiene_tarjeta, ['id'=>'tipoTarjeta_co', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                        </div>

                        <div class="col-sm-4 col-md-offset-2">
                            <?php echo e(Form::text('numeroTarjeta_co',$datos[0]->numero_tarjeta, array('id'=>'numeroTarjeta_co', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                    </div>

                    <div class="form-group">
                      <?php echo e(Form::label('¿Tienes algun credito hipotecario?(solo se valoran los creditos activos con mas de 2 años de vigencia no consideres creditos fovissste)','',array('class'=>"col-sm-4 col-md-offset-1 control-label"))); ?>

                      <?php echo e(Form::label('¿Tienes un credito Automotriz?(aperturado ultimos 2 años)','',array('class'=>"col-sm-5 col-md-offset-1 control-label"))); ?>

                    </div>

                    <div class="form-group">

                        <div class="col-sm-4 col-md-offset-1">
                          <?php echo e(Form::select('creditoHipo_co', [
                          'Si'=>'Si',
                          'No'=>'No'],
                          $datos[0]->hipoteca, ['id'=>'creditoHipo_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                        </div>

                        <div class="col-sm-4 col-md-offset-2">
                          <?php echo e(Form::select('creditoAuto_co', [
                          'Si'=>'Si',
                          'No'=>'No'],
                          $datos[0]->automotriz, ['id'=>'creditoAuto_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"" ]  )); ?>

                        </div>
                    </div>

                    <!-- ************************************ -->

                    <div class="form-group">
                        <?php echo e(Form::label('Información laboral','',array('class'=>"col-sm-2 control-label"))); ?>

                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Nombre de Empresa/Empleador*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('nombreEmpresa_co', $datos[0]->nombre_empresa,array('id'=>'nombreEmpresa_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                        <?php echo e(Form::label('Giro de la empresa*','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                          <?php echo e(Form::select('giroEmpresa_co', [
                          'Agricultura'=>'Agricultura',
                          'Ama de casa'=>'Ama de casa',
                          'Comercio mayorista'=>'Comercio mayorista',
                          'Comercio minorista'=>'Comercio minorista',
                          'Construccion'=>'Construccion',
                          'Financiero'=>'Financiero',
                          'Gobierno'=>'Gobierno',
                          'Hospedaje'=>'Hospedaje',
                          'Industria manufacturera'=>'Industria manufacturera',
                          'Jubilado / Pensionado'=>'Jubilado / Pensionado',
                          'Restaurantes'=>'Restaurantes',
                          'Servicios'=>'Servicios',
                          'Servicios educativos'=>'Servicios educativos',
                          'Servicios medicos'=>'Servicios medicos',
                          'Transporte'=>'Transporte'
                          ],
                          $datos[0]->giro_empresa, ['id'=>'giroEmpresa_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Ocupacion*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                          <?php echo e(Form::select('ocupacion_co', [
                          'Alto ejecutivo privado'=>'Alto ejecutivo privado',
                          'Alto ejecutivo publico'=>'Alto ejecutivo publico',
                          'Ama de casa'=>'Ama de casa',
                          'Comerciante'=>'Comerciante',
                          'Empleado sector privado'=>'Empleado sector privado',
                          'Empleado sector publico'=>'Empleado sector publico',
                          'Estudiante'=>'Estudiante',
                          'Jubilado / Pensionado'=>'Jubilado / Pensionado',
                          'Negocio propio'=>'Negocio propio',
                          'Profesionista independiente'=>'Profesionista independiente'
                          ],
                          $datos[0]->ocupacion, ['id'=>'ocupacion_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""] )); ?>

                        </div>
                        <?php echo e(Form::label('Antiguedad*','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                          <?php echo e(Form::select('antiguedad_co', [
                          '1'=>'1 año',
                          '2'=>'2 años',
                          '3'=>'3 años',
                          '4'=>'4 años',
                          '5'=>'5 años',
                          '6'=>'6 años',
                          '7'=>'7 años',
                          '8'=>'8 años',
                          '9'=>'9 años',
                          '10'=>'10 años',
                          '11'=>'11 años',
                          '12'=>'12 años',
                          '13'=>'13 años',
                          '14'=>'14 años',
                          '15'=>'15 años',
                          '16'=>'16 años',
                          '17'=>'17 años',
                          '18'=>'18 años',
                          '19'=>'19 años',
                          '20'=>'20 años o más',
                          ],
                          $datos[0]->antiguedad, ['id'=>'antiguedad_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""])); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('ingresos mensuales*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('ingresos_co', $datos[0]->mensuales, array('id'=>'ingresos_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                        <?php echo e(Form::label('Tipo de tarjeta solicitada*','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                          <?php echo e(Form::select('tipoTarjetaSolicita_co', [
                          'Clasica'=>'Clasica',
                          'ORO'=>'ORO',
                          'PLATINUM'=>'PLATINUM',
                          'BMART'=>'BMART',
                          'PREMIER'=>'PREMIER',
                          'REWARDS'=>'REWARDS'
                          ],
                          $datos[0]->tipo_tarjeta, ['id'=>'tipoTarjetaSolicita_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('calle*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('calleEmpleo_co', $datos[0]->calle_empresa, array('id'=>'calleEmpleo_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                        <?php echo e(Form::label('No. exterior*','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('numExt_co', $datos[0]->no_ext_empresa,array('id'=>'numExt_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('No. interior','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('numInt_co', $datos[0]->no_int_empresa, array('id'=>'numInt_co','class'=>"form-control", 'placeholder'=>""))); ?>

                        </div>
                        <?php echo e(Form::label('CP*','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-4">
                            <?php echo e(Form::text('cpEmpleo_co', $datos[0]->cp_empresa, array('id'=>'cpEmpleo_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address21()'))); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Colonia *', '', array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                          <?php echo e(Form::select('coloniaEmpleo_co', [],
                          $datos[0]->colonia_empresa, ['id'=>'coloniaEmpleo_co', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                        </div>
                    </div>

                    <!-- *********************************** -->
                    <div class="form-group">
                        <?php echo e(Form::label('Datos complementarios','',array('class'=>"col-sm-2 control-label"))); ?>

                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Nacionalidad*','',array('class'=>"col-sm-1 control-label"))); ?>

                        <div class="col-sm-4">
                          <?php echo e(Form::select('nacionalidad_co', [
                          'Soy mexicano (a)'=>'Soy mexicano (a)',
                          'Soy extranjero (a)'=>'Soy extranjero (a)'],
                          $datos[0]->nacionalidad, ['id'=>'nacionalidad_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'nacionalidad()'])); ?>

                        </div>
                        <div id="nac1" >
                          <?php echo e(Form::label('Lugar de nacimiento*','',array('class'=>"col-sm-2 control-label"))); ?>

                          <div class="col-sm-4">
                            <?php echo e(Form::select('lugarNaci_co', [
                            'Ciudad de Mexico'=>'Ciudad de Mexico',
                            'Aguascalientes'=>'Aguascalientes',
                            'Baja California'=>'Baja California',
                            'Baja California Sur'=>'Baja California Sur',
                            'Campeche'=>'Campeche',
                            'Coahuila'=>'Coahuila',
                            'Colima'=>'Colima',
                            'Chiapas'=>'Chiapas',
                            'Chihuahua'=>'Chihuahua',
                            'Durango'=>'Durango',
                            'Guanajuato'=>'Guanajuato',
                            'Guerrero'=>'Guerrero',
                            'Hidalgo'=>'Hidalgo',
                            'Jalisco'=>'Jalisco',
                            'Estado De Mexico'=>'Estado De Mexico',
                            'Michoacan'=>'Michoacan',
                            'Morelos'=>'Morelos',
                            'Nayarit'=>'Nayarit',
                            'Nuevo Leon'=>'Nuevo Leon',
                            'Oaxaca'=>'Oaxaca',
                            'Puebla'=>'Puebla',
                            'Queretaro'=>'Queretaro',
                            'Quintana Roo'=>'Quintana Roo',
                            'San Luis Potosi'=>'San Luis Potosi',
                            'Sinaloa'=>'Sinaloa',
                            'Sonora'=>'Sonora',
                            'Tabasco'=>'Tabasco',
                            'Tamaulipas'=>'Tamaulipas',
                            'Tlaxcala'=>'Tlaxcala',
                            'Veracruz'=>'Veracruz',
                            'Yucatan'=>'Yucatan',
                            'Zacatecas'=>'Zacatecas'
                            ],
                            $datos[0]->lugar_nacimiento, ['id'=>'lugarNaci_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                          </div>
                        </div>

                        <div id="extran1" style="display:none">
                          <?php echo e(Form::label('Pais de nacimiento*','',array('class'=>"col-sm-2 control-label"))); ?>

                          <div class="col-sm-4">
                            <?php echo e(Form::text('lugarNaci_co', $datos[0]->lugar_nacimiento, array('id'=>'paisnaci_co','class'=>"form-control", 'placeholder'=>""))); ?>

                          </div>
                        </div>
                    </div>

                    <div id="nac"><!-- nacional -->
                      <div class="form-group">
                          <?php echo e(Form::label('Genero*','',array('class'=>"col-sm-1 control-label"))); ?>

                          <div class="col-sm-4">
                            <?php echo e(Form::select('genero_co', [
                            'Masculino'=>'Masculino',
                            'Femenino'=>'Femenino'],
                            $datos[0]->genero, ['id'=>'genero_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                          </div>
                          <?php echo e(Form::label('Estado civil*','',array('class'=>"col-sm-2 control-label"))); ?>

                          <div class="col-sm-4">
                            <?php echo e(Form::select('estadoCivil_co', [
                            'Casado (a)'=>'Casado (a)',
                            'Divorciado (a)'=>'Divorciado (a)',
                            'Soltero (a)'=>'Soltero (a)',
                            'Viudo (a)'=>'Viudo (a)'
                            ],
                            $datos[0]->estado_civil, ['id'=>'estadoCivil_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                          </div>
                      </div>

                      <div class="form-group">
                          <?php echo e(Form::label('Escolaridad*','',array('class'=>"col-sm-1 control-label"))); ?>

                          <div class="col-sm-4">
                            <?php echo e(Form::select('escolaridad_co', [
                            'Sin escolaridad primaria'=>'Sin escolaridad primaria',
                            'Primaria'=>'Primaria',
                            'Secundaria'=>'Secundaria',
                            'Preparatoria'=>'Preparatoria',
                            'Tecnica/Comercial'=>'Tecnica/Comercial',
                            'Licenciatura'=>'Licenciatura',
                            'Postgrado'=>'Postgrado',
                            'Maestria/Doctorado'=>'Maestria/Doctorado'
                            ],
                            $datos[0]->estudios, ['id'=>'escolaridad_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                          </div>
                          <?php echo e(Form::label('Dependientes economicos *','',array('class'=>"col-sm-2 control-label"))); ?>

                          <div class="col-sm-4">
                              <?php echo e(Form::number('depEconomicos_co', $datos[0]->dependientes_economicos, array('id'=>'depEconomicos_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                          </div>
                      </div>

                      <div class="form-group">
                          <?php echo e(Form::label('Referencia personal(nombre)*','',array('class'=>"col-sm-1 control-label"))); ?>

                          <div class="col-sm-4">
                              <?php echo e(Form::text('refNombre_co', $datos[0]->nombre_referencia_personal, array('id'=>'refNombre_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                          </div>
                          <?php echo e(Form::label('Referencia apellido(apellidos)*','',array('class'=>"col-sm-2 control-label"))); ?>

                          <div class="col-sm-4">
                              <?php echo e(Form::text('refApellidos_co', $datos[0]->apellido_referencia_personal, array('id'=>'refApellidos_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                          </div>
                      </div>

                      <div class="form-group">
                          <?php echo e(Form::label('Lada*','',array('class'=>"col-sm-1 control-label"))); ?>

                          <div class="col-sm-4">
                            <?php echo e(Form::select('lada_co', [
                            '55'=>'55',
                            '594'=>'594',
                            '595'=>'595',
                            '722'=>'722',
                            '726'=>'726',
                            'Otra'=>'Otra'
                            ],
                            $datos[0]->lada_referencia_personal, ['id'=>'lada_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                          </div>
                          <?php echo e(Form::label('Referencia personal(telefono)*','',array('class'=>"col-sm-2 control-label"))); ?>

                          <div class="col-sm-4">
                              <?php echo e(Form::text('refTel_co', $datos[0]->tel_referencia_personal, array('id'=>'refTel_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                          </div>
                      </div>

                      <div class="form-group">
                          <?php echo e(Form::label('Extensión','',array('class'=>"col-sm-1 control-label"))); ?>

                          <div class="col-sm-4">
                              <?php echo e(Form::text('extensionRef_co', $datos[0]->ext_referencia_personal, array('id'=>'extensionRef_co','class'=>"form-control", 'placeholder'=>""))); ?>

                          </div>
                          <div id='extran2' style="display:none">
                            <?php echo e(Form::label('Num.de id fiscal','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-4">
                                <?php echo e(Form::text('idFiscal_co', $datos[0]->id_fiscal, array('id'=>'idFiscal_co','class'=>"form-control", 'placeholder'=>""))); ?>

                            </div>
                          </div>
                      </div>
                    </div>
                    <div id="extran" style="display:none"><!-- no nacional -->
                      <div class="form-group">
                          <?php echo e(Form::label('Pais que asigna id fiscal','',array('class'=>"col-sm-1 control-label"))); ?>

                          <div class="col-sm-4">
                              <?php echo e(Form::text('paisIdFiscal_co', $datos[0]->pais_id_fiscal, array('id'=>'paisIdFiscal_co','class'=>"form-control", 'placeholder'=>""))); ?>

                          </div>
                      </div>
                    </div>
					
					<div class="form-group">
                            <?php echo e(Form::label('Exitosa / No Exitosa','',array('class'=>"col-md-5 control-label"))); ?>

                            <div class="col-md-10">
                                <?php echo e(Form::select('exito', [
                                    'Exitosa' => 'Exitosa',
                                    'NoExitosa'=>'No Exitosa'],
                                $datos[0]->estatus_bo1, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Exitosa()",'id'=>'ventaExitosa']  )); ?>

                            </div>
                    </div>
                        
					<div class="form-group" style='display: none;' id='ventaAutenticada'>
						<?php echo e(Form::label('Autenticada','',array('class'=>"col-md-5 control-label"))); ?>

						<div class="col-md-10">
							<?php echo e(Form::select('autenticada', [
								'Autenticada' => 'Autenticada',
								'NoAutenticada'=>'No Autenticada'],
							$datos[0]->estatus_bo2, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Autenticadaa()", 'id'=>'ventaAutenticadaf']  )); ?>

						</div>
					</div>
                        
					 <div class="form-group" style='display: none;' id='ventaAprobada'>
						<?php echo e(Form::label('Aprobada','',array('class'=>"col-md-5 control-label"))); ?>

						<div class="col-md-10">
							<?php echo e(Form::select('aprobada', [
								'Aprobada' => 'Aprobada',
								'NoAprobada'=>'No Aprobada'],
							$datos[0]->estatus_bo3, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Aprobada()", 'id'=>'ventaAprobadaf']  )); ?>

						</div>
					</div>
                        
                        
					 <div class="form-group" style='display: none;' id='folio'>
						<?php echo e(Form::label('Folio Banamex','',array('class'=>"col-md-5 control-label"))); ?>

						<div class="col-md-10">
							<?php echo e(Form::text('Folio Banamex',$datos[0]->folio,array('class'=>"form-control", 'required' => 'required', 'id'=>'foliof' ))); ?>

						</div>
					</div>
					
                  </div>
                </div>
              </div>

                <div >
                  <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default" ])); ?>

                </div>

                <?php echo e(Form::close()); ?>


            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>

<script>
  $(document).ready(function(){
    //c_new
    var cont=0;
    var yearf=<?php echo e(date('Y')-18); ?>;
    var yeari=yearf-75;
    for(cont=1;cont<=31;cont++){
      $('#diaNacimiento_co').append('<option value="'+cont+'">'+cont+'</option>');
    }

    for(yeari;yeari<=yearf;yeari++){
      $('#yearNacimiento_co').append('<option value="'+yeari+'">'+yeari+'</option>');
    }


  });

  function address(){
    $.ajax({
      url:   "/svn/trunk/pc/public/banamex/dir/"+$("#cp_co").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        $('#colonia_co').html('');
        for(i=0;i<data.length;i++)
    		{
          $('#colonia_co').append('<option value="'+data[i].asentamiento+'">'+data[i].asentamiento+'</option>');
    		}
      }
    });
  }

  function address2(){
    $.ajax({
      url:   "/svn/trunk/pc/public/banamex/dir/"+$("#cp_new").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        $('#colonia_new').html('');
        $('#colonia_new').append('<option value=""></option>');
        for(i=0;i<data.length;i++)
    		{
          $('#colonia_new').append('<option value="'+data[i].asentamiento+'">'+data[i].asentamiento+'</option>');
    		}
      }
    });
  }
  function address21(){
    $.ajax({
      url:   "/svn/trunk/pc/public/banamex/dir/"+$("#cpEmpleo_co").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        $('#coloniaEmpleo_co').html('');
        $('#coloniaEmpleo_co').append('<option value=""></option>');
        for(i=0;i<data.length;i++)
    		{
          $('#coloniaEmpleo_co').append('<option value="'+data[i].asentamiento+'">'+data[i].asentamiento+'</option>');
    		}
      }
    });
  }
  function address3(){
    $.ajax({
      url:   "banamex/col/"+encodeURIComponent($("#colonia_new").val())+"/"+$("#cp_new").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        console.log(data);
        $('#delegacion_new').html('');
        $('#delegacion_new').append('<option value=""></option>');
        for(i=0;i<data.length;i++)
    		{
          $('#delegacion_new').append('<option value="'+data[i].municipio+'">'+data[i].municipio+'</option>');
    		}
      }
    });
  }
  function address4(){
    $.ajax({
      url:   "banamex/del/"+encodeURIComponent($("#delegacion_new").val())+"/"+encodeURIComponent($("#colonia_new").val())+"/"+$("#cp_new").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        console.log(data);
        $('#ciudad_new').html('');
        $('#ciudad_new').append('<option value=""></option>');
        for(i=0;i<data.length;i++)
    		{
          $('#ciudad_new').append('<option value="'+data[i].ciudad+'">'+data[i].ciudad+'</option>');
    		}
      }
    });
  }
  function address5(){
    $.ajax({
      url:   "banamex/ciu/"+encodeURIComponent($("#ciudad_new").val())+"/"+encodeURIComponent($("#delegacion_new").val())+"/"+encodeURIComponent($("#colonia_new").val())+"/"+$("#cp_new").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        $('#estado_new').html('');
        $('#estado_new').append('<option value=""></option>');
        for(i=0;i<data.length;i++)
    		{
          $('#estado_new').append('<option value="'+data[i].estado+'">'+data[i].estado+'</option>');
    		}
      }
    });
  }

  
  function buscar(){
    $.ajax({
                  url:   "banamex/busca/"+$("#dn").val(),
                  type:  'get',
                  beforeSend: function () {
                          console.log('espere');
                  },
                  success:  function (data)
                  {
                    console.log(data);
                    if(data != '' ){
                      $("#exist").show();
                      $("#notExist").hide();
                      $("#c_objetivo").prop('disabled', false);
                      $("#nombre").val(data[0]['nombre']);
                      $("#direccion").val(data[0]['direccion']);
                      $("#colonia").val(data[0]['colonia']);
                      $("#cp").val(data[0]['cp']);
                      $("#delegacion").val(data[0]['del_muni']);
                      $("#ciudad").val(data[0]['ciudad']);
                      $("#estado").val(data[0]['estado']);
                      $("#tel_casa").val(data[0]['tel_casa']);
                      $("#tel_oficina").val(data[0]['tel_oficina']);
                      $("#sexo").val(data[0]['sexo']);
                      $("#tarjeta").val(data[0]['tarjeta']);
                      $("#banco").val(data[0]['banco']);
                      console.log(data[0]['nombre']);
                    }
                    else {
                      $("#exist").hide();
                      $("#notExist").show();
                    }
                  }
          });
  }

  
  function cliente_new_fun(){
    if($("#c_new").val()=='Si'){
      $("#ccs").show();
      $("#ccn").hide();

      //datos nuevo cliente enable
        // $("#c_new").prop('disabled', false);
        $("#nombre_new").prop('disabled', false);
        $("#paterno_new").prop('disabled', false);
        $("#materno_new").prop('disabled', false);
        $("#tel1_new").prop('disabled', false);
        $("#tel2_new").prop('disabled', false);
        $("#calle_new").prop('disabled', false);
        $("#numExt_new").prop('disabled', false);
        $("#numInt_new").prop('disabled', false);
        $("#cp_new").prop('disabled', false);
        $("#colonia_new").prop('disabled', false);
        $("#delegacion_new").prop('disabled', false);
        $("#ciudad_new").prop('disabled', false);
        $("#estado_new").prop('disabled', false);
        $("#sexo_new").prop('disabled', false);
        $("#tarjeta_new").prop('disabled', false);
        $("#banco_new").prop('disabled', false);
        $("#cContrata_new").prop('disabled', false);
        $("#tipoTarjetaSolicita_co").prop('disabled', false);

    }
    else {
      $("#ccn").show();
      $("#ccs").hide();

      //datos nuevo cliente disabled
        //$("#c_new").prop('disabled', true);
        $("#nombre_new").prop('disabled', true);
        $("#paterno_new").prop('disabled', true);
        $("#materno_new").prop('disabled', true);
        $("#tel1_new").prop('disabled', true);
        $("#tel2_new").prop('disabled', true);
        $("#calle_new").prop('disabled', true);
        $("#numExt_new").prop('disabled', true);
        $("#numInt_new").prop('disabled', true);
        $("#cp_new").prop('disabled', true);
        $("#colonia_new").prop('disabled', true);
        $("#delegacion_new").prop('disabled', true);
        $("#ciudad_new").prop('disabled', true);
        $("#estado_new").prop('disabled', true);
        $("#sexo_new").prop('disabled', true);
        $("#tarjeta_new").prop('disabled', true);
        $("#banco_new").prop('disabled', true);
        $("#cContrata_new").prop('disabled', true);
        $("#tipoTarjetaSolicita_co").prop('disabled', true);
    }
  }
  
  function tipificacion_fun(){
    if(
      $("#tipificacion").val()=='No Contacto - Buzon de voz personal' ||
      $("#tipificacion").val()=='No Contacto - Buzon de voz empresa' ||
      $("#tipificacion").val()=='No Contacto - Telefono no existe' ||
      $("#tipificacion").val()=='Se corta la llamada' ||
      $("#tipificacion").val()=='No le interesa - No tiene tiempo' ||
      $("#tipificacion").val()=='No le interesa - Cuelga llamada' ||
      $("#tipificacion").val()=='No cubre el perfil' ||
      $("#tipificacion").val()=='Llamar despues' ||
      $("#tipificacion").val()=='No le interesa - Mala experiencia con los bancos' ||
      $("#tipificacion").val()=='No le interesa - No quiere adquirir productos' ||
      $("#tipificacion").val()=='No le interesa - Mala experiencia con Banamex' ||
      $("#tipificacion").val()=='No le interesa - Problemas con buro' ||
      $("#tipificacion").val()=='No le interesa - Producto poco atractivo'
    )
    {
      $("#send").show();
      $("#valida").hide();
      $("#numEmpleado").prop('disabled', true);
      $("#numPass").prop('disabled', true);

      $("#email_co").prop('required',false);
      $("#tipoTarjeta_co").prop('required',false);
      $("#confirmEmail_co").prop('required',false);
      $("#nombre_co").prop('required',false);
      $("#paterno_co").prop('required',false);
      $("#materno_co").prop('required',false);
      $("#diaNacimiento_co").prop('required',false);
      $("#mesNacimiento_co").prop('required',false);
      $("#yearNacimiento_co").prop('required',false);
      $("#rfc_co").prop('required',false);
      $("#telCelular_co").prop('required',false);
      $("#calle_co").prop('required',false);
      $("#noExt_co").prop('required',false);
      $("#cp_co").prop('required',false);
      $("#colonia_co").prop('required',false);
      $("#tipoVivienda_co").prop('required',false);
      $("#tiempoResidencia_co").prop('required',false);
      $("#ladaDomi_co").prop('requiered', false);
      $("#telDom_co").prop('required', false);
      $("#creditoHipo_co").prop('required',false);
      $("#creditoAuto_co").prop('required',false);
      $("#nombreEmpresa_co").prop('required',false);
      $("#giroEmpresa_co").prop('required',false);
      $("#ocupacion_co").prop('required',false);
      $("#antiguedad_co").prop('required',false);
      $("#ingresos_co").prop('required',false);
      $("#calleEmpleo_co").prop('required',false);
      $("#numExt_co").prop('required',false);
      $("#numInt_co").prop('required',false);
      $("#cpEmpleo_co").prop('required',false);
      $("#coloniaEmpleo_co").prop('required',false);
      $("#nacionalidad_co").prop('required',false);
      $("#lugarNaci_co").prop('required',false);
      $("#paisnaci_co").prop('required',false);

      $("#genero_co").prop('required',false);
      $("#estadoCivil_co").prop('required',false);
      $("#escolaridad_co").prop('required',false);
      $("#depEconomicos_co").prop('required',false);
      $("#refNombre_co").prop('required',false);
      $("#refApellidos_co").prop('required',false);
      $("#lada_co").prop('required',false);
      $("#refTel_co").prop('required',false);

      $("#nombre_new").prop('required',false);
      $("#paterno_new").prop('required',false);
      $("#materno_new").prop('required',false);
      $("#tel1_new").prop('required',false);
      $("#calle_new").prop('required',false);
      $("#numExt_new").prop('required',false);
      $("#numInt_new").prop('required',false);
      $("#cp_new").prop('required',false);
      $("#colonia_new").prop('required',false);
      $("#delegacion_new").prop('required',false);
      $("#ciudad_new").prop('required',false);
      $("#estado_new").prop('required',false);
      $("#sexo_new").prop('required',false);
      $("#tarjeta_new").prop('required',false);
      $("#banco_new").prop('required',false);
      $("#tipoTarjetaSolicita_co").prop('required',false);
    }
    else if($("#tipificacion").val()=='Venta - Validada' || $("#tipificacion").val()=='Venta - No Validada')
    {
      $("#send").show();
      $("#valida").show();
      $("#numEmpleado").prop('disabled', false);
      $("#numPass").prop('disabled', false);

      $("#email_co").prop('required',true);
      //$("#tipoTarjeta_co").prop('required',true);
      $("#confirmEmail_co").prop('required',true);
      $("#nombre_co").prop('required',true);
      $("#paterno_co").prop('required',true);
      $("#materno_co").prop('required',true);
      $("#diaNacimiento_co").prop('required',true);
      $("#mesNacimiento_co").prop('required',true);
      $("#yearNacimiento_co").prop('required',true);
      $("#rfc_co").prop('required',true);
      $("#telCelular_co").prop('required',true);
      $("#calle_co").prop('required',true);
      $("#noExt_co").prop('required',true);
      $("#cp_co").prop('required',true);
      $("#colonia_co").prop('required',true);
      $("#tipoVivienda_co").prop('required',true);
      $("#tiempoResidencia_co").prop('required',true);
      $("#ladaDomi_co").prop('required', true);
      $("#telDom_co").prop('requiered', true);
      $("#creditoHipo_co").prop('required',true);
      $("#creditoAuto_co").prop('required',true);
      $("#nombreEmpresa_co").prop('required',true);
      $("#giroEmpresa_co").prop('required',true);
      $("#ocupacion_co").prop('required',true);
      $("#antiguedad_co").prop('required',true);
      $("#ingresos_co").prop('required',true);
      $("#calleEmpleo_co").prop('required',true);
      $("#numExt_co").prop('required',true);
      // $("#numInt_co").prop('required',true);
      $("#cpEmpleo_co").prop('required',true);
      $("#coloniaEmpleo_co").prop('required',true);
      $("#nacionalidad_co").prop('required',true);
      $("#lugarNaci_co").prop('required',true);
      $("#paisnaci_co").prop('required',true);
      $("#genero_co").prop('required',true);
      $("#estadoCivil_co").prop('required',true);
      $("#escolaridad_co").prop('required',true);
      $("#depEconomicos_co").prop('required',true);
      $("#refNombre_co").prop('required',true);
      $("#refApellidos_co").prop('required',true);
      $("#lada_co").prop('required',true);
      $("#refTel_co").prop('required',true);

      $("#nombre_new").prop('required',true);
      $("#paterno_new").prop('required',true);
      $("#materno_new").prop('required',true);
      $("#tel1_new").prop('required',true);
      $("#calle_new").prop('required',true);
      $("#numExt_new").prop('required',true);
      // $("#numInt_new").prop('required',true);
      $("#cp_new").prop('required',true);
      $("#colonia_new").prop('required',true);
      $("#delegacion_new").prop('required',true);
      $("#ciudad_new").prop('required',true);
      $("#estado_new").prop('required',true);
      $("#sexo_new").prop('required',true);
      $("#tarjeta_new").prop('required',true);
      $("#banco_new").prop('required',true);
      $("#tipoTarjetaSolicita_co").prop('required',true);

    }else {
      $("#send").hide();
      $("#valida").hide();
      $("#numEmpleado").prop('disabled', true);
      $("#numPass").prop('disabled', true);
    }
  }
  function validaEmail(){
    if($("#email_co").val()!=$("#confirmEmail_co").val()){
      document.getElementById("confirmEmail_co").value='';
    }
  }

  function validaVenta(){
    if($("#tipificacion").val()=='Venta - Validada' || $("#tipificacion").val()=='Venta - No Validada'){
      if($("#valVenta").val()==1){
        $("#valida").show();
        $("#numEmpleado").prop('disabled', false);
        return true;
      }
      else {
        return false
      }
    }else {
      return true;
    }
  }

  function nacionalidad(){
    if($("#nacionalidad_co").val()=="Soy mexicano (a)"){
      $("#nac1").show();
      $("#extran").hide();
      $("#extran1").hide();
      $("#extran2").hide();
    }else if($("#nacionalidad_co").val()=="Soy extranjero (a)"){
       $("#nac1").hide();
      $("#extran").show();
      $("#extran1").show();
      $("#extran2").show();
    }
    else {
      $("#nac").show();
      $("#extran").hide();
      $("#extran1").hide();
      $("#extran2").hide();
    }
  }
</script>

<script type="text/javascript">

    function Exitosa(){
        console.log($('#ventaExitosa').val());
        if($('#ventaExitosa').val()=='Exitosa'){
            $('#ventaAutenticada').show();
            $("#ventaAutenticadaf").prop('disabled',false);
        }
        else{
            $('#ventaAutenticada').hide();
            $('#folio').hide();
            $('#ventaAprobada').hide();
            $("#ventaAutenticadaf").prop('disabled',true);
            $("#ventaAprobadaf").prop('disabled',true);
            $("#foliof").prop('disabled',true);
        }
    }

    function Autenticadaa(){
      console.log($('#ventaAutenticadaf').val());
      if($('#ventaAutenticadaf').val()=='Autenticada'){

        $('#ventaAprobada').show();
        $("#ventaAutenticada").prop('disabeld',false);
        $("#ventaAprobadaf").prop('disabled',false);
      }
      else{
        $('#ventaAprobada').hide();
        $('#folio').hide();
        $("#ventaAprobadaf").prop('disabled',true);
        /*$("#ventaAutenticadaf").prop('disabled',true);*/
      }
    }

    function Aprobada(){
      console.log($('#ventaAprobadaf').val());
      if($('#ventaAprobadaf').val()=='Aprobada'){

        $('#folio').show();
        $("#ventaAprobada").prop('disabled',false);
        $("#foliof").prop('disabled',false);
      }
      else{
        $('#folio').hide();
        /*$("#ventaAutenticadaf").prop('disabled',true);*/
        $("#foliof").prop('disabled',true);
      }
    }

</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Banamex.bo.recuperacion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>