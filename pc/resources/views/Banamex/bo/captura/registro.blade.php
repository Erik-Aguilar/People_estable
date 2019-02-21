@extends($menu)
@section('content')
<style media="screen">
  div{
    font-size: 12px;
  }
</style>

<div class="row">
    <div class="col-md-12 ">
        <div class="panel panel-primary">
            @if(session('puesto')=='Analista de Calidad'&&session('campaign')=='Banamex')
            <div class="panel-heading">
                <h3 class="panel-title">Descarga de Audios {{$datos[0]->v_id}}</h3>
            </div>
            @endif
            
            @if(session('puesto')=='Analista de BO Banamex')
            <div class="panel-heading">
                <h3 class="panel-title">Back-Office Captura Banamex</h3>
            </div>
            @endif
            
            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="myModal" role="dialog">
              <div class="modal-dialog" role="document" style="width:1250px; height:550px;">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Captura</h4>
                  </div>
                  <div class="modal-body">
                    <img src="{{asset('')}}" height="550" width="1200" id='imaf'>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <div class="panel-body">

              {{ Form::open(['action' => 'BoBanamexController@BackOfficeRegistroGuarda',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario",

                          ]) }}
                        @if(session('puesto')=='Analista de BO Banamex')
                        <div class="form-group col-sm-12">
                          <div class="col-sm-8">
                            <div class="form-group">
                                {{ Form::label('Datos Personales','',array('class'=>"col-sm-3 control-label")) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('Email*','',array('class'=>"col-sm-1 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('email_co',$datos[0]->email,array('id'=>'email_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                                {{ Form::label('Confirmacion Email*','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('confirmEmail_co',$datos[0]->email,array('id'=>'confirmEmail_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onBlur'=>'validaEmail()')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('Nombre*','',array('class'=>"col-sm-1 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('nombre_co',$datos[0]->nombre,array('id'=>'nombre_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                                {{ Form::label('Apellido Paterno*','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('paterno_co',$datos[0]->paterno,array('id'=>'paterno_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('Apellido Materno*','',array('class'=>"col-sm-1 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('materno_co',$datos[0]->materno,array('id'=>'materno_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                                {{ Form::label('Dia nacimiento*','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-4">
                                  {{ Form::select('diaNacimiento_co', [],
                                  date("d",strtotime($datos[0]->fecha_nacimiento)), ['id'=>'diaNacimiento_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'validaFecha()']  ) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('Mes nacimiento*','',array('class'=>"col-sm-1   control-label")) }}
                                <div class="col-sm-4">
                                  {{ Form::select('mesNacimiento_co', [
                                  '1'=>'Enero',
                                  '2'=>'Febrero',
                                  '3'=>'Marzo',
                                  '4'=>'Abril',
                                  '5'=>'Mayo',
                                  '6'=>'Junio',
                                  '7'=>'Julio',
                                  '8'=>'Agosto',
                                  '9'=>'Septiembre',
                                  '10'=>'Octubre',
                                  '11'=>'Noviembre',
                                  '12'=>'Diciembre'
                                  ],
                                  date("m",strtotime($datos[0]->fecha_nacimiento)), ['id'=>'mesNacimiento_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'validaFecha()']  ) }}
                                </div>
                                {{ Form::label('Año nacimiento*','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-4">
                                  {{ Form::select('yearNacimiento_co', [],
                                  date("Y",strtotime($datos[0]->fecha_nacimiento)), ['id'=>'yearNacimiento_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'validaFecha()']  ) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('RFC*','',array('class'=>"col-sm-1 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('rfc_co',$datos[0]->rfc,array('id'=>'rfc_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                                {{ Form::label('Homoclave del RFC','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('homoclave_co',$datos[0]->homoclave,array('id'=>'homoclave_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('Telefono celular*','',array('class'=>"col-sm-1 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('telCelular_co',$datos[0]->telefono,array('id'=>'telCelular_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <img src="{{asset('assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia.'/1_'.$name_image)}}" height="350" width="450" id='imaf1' data-toggle="modal" data-target="#myModal"  >
                          </div>
                        </div>

                          <!-- ***************************************************** -->
                      <div class="form-group col-sm-12">
                        <div class="col-sm-8">


                          <div class="form-group">
                              {{ Form::label('Domicilio','',array('class'=>"col-sm-2 control-label")) }}
                          </div>
                          <div class="form-group">
                              {{ Form::label('Calle*','',array('class'=>"col-sm-1 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('calle_co',$datos[0]->calle,array('id'=>'calle_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                              {{ Form::label('No. exterior*','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('noExt_co',$datos[0]->no_ext,array('id'=>'noExt_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('No. interior','',array('class'=>"col-sm-1 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('noInt_co',$datos[0]->no_int,array('id'=>'noInt_co','class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                              {{ Form::label('CP*','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('cp_co',$datos[0]->cp,array('id'=>'cp_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address()')) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('Colonia*','',array('class'=>"col-sm-1 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('colonia_co',$datos[0]->colonia,array('id'=>'colonia_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                              {{ Form::label('Tipo Vivienda*','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-4">
                                {{ Form::select('tipoVivienda_co', [
                                'Vivienda de un familiar'=>'Vivienda de un familiar',
                                'Vivienda hipotecada'=>'Vivienda hipotecada',
                                'Vivienda propia'=>'Vivienda propia',
                                'Vivienda rentada'=>'Vivienda rentada'],
                                $datos[0]->tipo_vivienda, ['id'=>'tipoVivienda_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('Tiempo de residencia*','',array('class'=>"col-sm-1 control-label")) }}
                              <div class="col-sm-4">
                                {{ Form::select('tiempoResidencia_co', [
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
                                $datos[0]->residencia, ['id'=>'tiempoResidencia_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                              {{ Form::label('lada domicilio','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('ladaDomi_co',$datos[0]->lada,array('id'=>'ladaDomi_co','class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('telefono*','',array('class'=>"col-sm-1 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('telDom_co',$datos[0]->tel_domicilio,array('id'=>'telDom_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address()')) }}
                              </div>
                          </div>

                        </div>
                        <div class="col-sm-3">
                          <img src="{{asset('assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia.'/2_'.$name_image)}}" height="350" width="450" id='imaf2' data-toggle="modal" data-target="#myModal">
                        </div>
                      </div>
                          <!-- *********************** -->
                      <div class="form-group col-sm-12">
                        <div class="col-sm-8">
                          <div class="form-group">
                              {{ Form::label('Información Financiera','',array('class'=>"col-sm-2 control-label")) }}
                          </div>
                          <div class="form-group">
                            {{ Form::label('¿Tienes alguna tarjeta de credito?(no nómina o débito) ','',array('class'=>"col-sm-4 col-md-offset-1  control-label")) }}
                            {{ Form::label('Numero de tarjeta(ultimos 4 digitos)','',array('class'=>"col-sm-4 col-md-offset-1 control-label")) }}
                          </div>
                          <div class="form-group">
                              <div class="col-sm-4 col-md-offset-1">
                                {{ Form::select('tipoTarjeta_co', [
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
                                $datos[0]->institucion, ['id'=>'tipoTarjeta_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>

                              <div class="col-sm-4 col-md-offset-2">
                                  {{ Form::text('numeroTarjeta_co',$datos[0]->numero_tarjeta,array('id'=>'numeroTarjeta_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                          </div>
                          <div class="form-group">

                            {{ Form::label('¿Tienes algun credito hipotecario?(solo se valoran los creditos activos con mas de 2 años de vigencia no consideres creditos fovissste)','',array('class'=>"col-sm-4 col-md-offset-1 control-label")) }}
                            {{ Form::label('¿Tienes un credito Automotriz?(aperturado ultimos 2 años)','',array('class'=>"col-sm-4 col-md-offset-2 control-label")) }}
                          </div>
                          <div class="form-group">

                              <div class="col-sm-4 col-md-offset-1">
                                {{ Form::select('creditoHipo_co', [
                                'Si'=>'Si',
                                'No'=>'No'],
                                $datos[0]->hipoteca, ['id'=>'creditoHipo_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>

                              <div class="col-sm-4 col-md-offset-2">
                                {{ Form::select('creditoAuto_co', [
                                'Si'=>'Si',
                                'No'=>'No'],
                                $datos[0]->automotriz, ['id'=>'creditoAuto_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <img src="{{asset('assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia.'/3_'.$name_image)}}" height="350" width="450" id='imaf3' data-toggle="modal" data-target="#myModal">
                        </div>
                        </div>
                          <!-- ************************************ -->
                      <div class="form-group col-sm-12">
                        <div class="col-sm-8">
                          <div class="form-group">
                              {{ Form::label('Información laboral','',array('class'=>"col-sm-2 control-label")) }}
                          </div>
                          <div class="form-group">
                              {{ Form::label('Nombre de Empresa/Empleador*','',array('class'=>"col-sm-1 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('nombreEmpresa_co',$datos[0]->nombre_empresa,array('id'=>'nombreEmpresa_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                              {{ Form::label('Giro de la empresa*','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-4">
                                {{ Form::select('giroEmpresa_co', [
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
                                $datos[0]->giro_empresa, ['id'=>'giroEmpresa_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('Ocupacion*','',array('class'=>"col-sm-1 control-label")) }}
                              <div class="col-sm-4">
                                {{ Form::select('ocupacion_co', [
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
                                $datos[0]->ocupacion, ['id'=>'ocupacion_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                              {{ Form::label('Antiguedad*','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-4">
                                {{ Form::select('antiguedad_co', [
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
                                $datos[0]->antiguedad, ['id'=>'antiguedad_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('ingresos mensuales*','',array('class'=>"col-sm-1 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('ingresos_co',$datos[0]->mensuales,array('id'=>'ingresos_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                              {{ Form::label('Tipo de tarjeta solicitada*','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-4">
                                {{ Form::select('tipoTarjetaSolicita_co', [
                                'Clasica'=>'Clasica',
                                'ORO'=>'ORO',
                                'PLATINUM'=>'PLATINUM',
                                'BMART'=>'BMART',
                                'PREMIER'=>'PREMIER',
                                'REWARDS'=>'REWARDS'
                                ],
                                $datos[0]->tipo_tarjeta, ['id'=>'tipoTarjetaSolicita_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('calle*','',array('class'=>"col-sm-1 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('calleEmpleo_co',$datos[0]->calle_empresa,array('id'=>'calleEmpleo_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                              {{ Form::label('No. exterior*','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('numExt_co',$datos[0]->no_ext_empresa,array('id'=>'numExt_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('No. interior','',array('class'=>"col-sm-1 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('numInt_co',$datos[0]->no_int_empresa,array('id'=>'numInt_co','class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                              {{ Form::label('CP*','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-4">
                                  {{ Form::text('cpEmpleo_co',$datos[0]->cp_empresa,array('id'=>'cpEmpleo_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address21()')) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('Colonia *','',array('class'=>"col-sm-1 control-label")) }}
                              <div class="col-sm-4">
                                {{ Form::text('coloniaEmpleo_co',$datos[0]->colonia_empresa,array('id'=>'coloniaEmpleo_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}

                              </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <img src="{{asset('assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia.'/4_'.$name_image)}}" height="350" width="450" id='imaf4' data-toggle="modal" data-target="#myModal">
                        </div>
                        </div>
                          <!-- *********************************** -->
                      <div class="form-group col-sm-12">
                        <div class="col-sm-8">
                          <div class="form-group">
                              {{ Form::label('Datos complementarios','',array('class'=>"col-sm-2 control-label")) }}
                          </div>
                          <div class="form-group">
                              {{ Form::label('Nacionalidad*','',array('class'=>"col-sm-1 control-label")) }}
                              <div class="col-sm-4">
                                {{ Form::select('nacionalidad_co', [
                                'Soy mexicano (a)'=>'Soy mexicano (a)',
                                'Soy extranjero (a)'=>'Soy extranjero (a)'],
                                $datos[0]->nacionalidad, ['id'=>'nacionalidad_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'nacionalidad()']  ) }}
                              </div>
                              <div id="nac1" >
                                {{ Form::label('Lugar de nacimiento*','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-4">
                                  {{ Form::select('lugarNaci_co', [
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
                                  $datos[0]->lugar_nacimiento, ['id'=>'lugarNaci_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                                </div>
                              </div>
                              <div id="extran1" style="display:none">
                                {{ Form::label('Pais de nacimiento*','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-4">
                                  {{ Form::text('lugarNaci_co',$datos[0]->lugar_nacimiento,array('id'=>'paisnaci_co','class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                              </div>
                          </div>

                          <div id="nac"><!-- nacional -->
                            <div class="form-group">
                                {{ Form::label('Genero*','',array('class'=>"col-sm-1 control-label")) }}
                                <div class="col-sm-4">
                                  {{ Form::select('genero_co', [
                                  'Masculino'=>'Masculino',
                                  'Femenino'=>'Femenino'],
                                  $datos[0]->genero, ['id'=>'genero_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                                </div>
                                {{ Form::label('Estado civil*','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-4">
                                  {{ Form::select('estadoCivil_co', [
                                  'Casado (a)'=>'Casado (a)',
                                  'Divorciado (a)'=>'Divorciado (a)',
                                  'Soltero (a)'=>'Soltero (a)',
                                  'Viudo (a)'=>'Viudo (a)'
                                  ],
                                  $datos[0]->estado_civil, ['id'=>'estadoCivil_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('Escolaridad*','',array('class'=>"col-sm-1 control-label")) }}
                                <div class="col-sm-4">
                                  {{ Form::select('escolaridad_co', [
                                  'Sin escolaridad primaria'=>'Sin escolaridad primaria',
                                  'Primaria'=>'Primaria',
                                  'Secundaria'=>'Secundaria',
                                  'Preparatoria'=>'Preparatoria',
                                  'Tecnica/Comercial'=>'Tecnica/Comercial',
                                  'Licenciatura'=>'Licenciatura',
                                  'Postgrado'=>'Postgrado',
                                  'Maestria/Doctorado'=>'Maestria/Doctorado'
                                  ],
                                  $datos[0]->estudios, ['id'=>'escolaridad_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                                </div>
                                {{ Form::label('Dependientes economicos *','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::number('depEconomicos_co',$datos[0]->dependientes_economicos,array('id'=>'depEconomicos_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('Referencia personal(nombre)*','',array('class'=>"col-sm-1 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('refNombre_co',$datos[0]->nombre_referencia_personal,array('id'=>'refNombre_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                                {{ Form::label('Referencia apellido(apellidos)*','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('refApellidos_co',$datos[0]->apellido_referencia_personal,array('id'=>'refApellidos_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('Lada*','',array('class'=>"col-sm-1 control-label")) }}
                                <div class="col-sm-4">
                                  {{ Form::text('lada_co',$datos[0]->lada_referencia_personal,array('id'=>'lada_co','class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                                {{ Form::label('Referencia personal(telefono)*','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('refTel_co',$datos[0]->tel_referencia_personal,array('id'=>'refTel_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('Extensión','',array('class'=>"col-sm-1 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('extensionRef_co',$datos[0]->ext_referencia_personal,array('id'=>'extensionRef_co','class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                                <div id='extran2' style="display:none">
                                  {{ Form::label('Num.de id fiscal','',array('class'=>"col-sm-2 control-label")) }}
                                  <div class="col-sm-4">
                                      {{ Form::text('idFiscal_co',$datos[0]->id_fiscal,array('id'=>'idFiscal_co','class'=>"form-control", 'placeholder'=>"")) }}
                                  </div>
                                </div>
                            </div>
                          </div>
                          <div id="extran" style="display:none"><!-- no nacional -->
                            <div class="form-group">
                                {{ Form::label('Pais que asigna id fiscal','',array('class'=>"col-sm-1 control-label")) }}
                                <div class="col-sm-4">
                                    {{ Form::text('paisIdFiscal_co',$datos[0]->pais_id_fiscal,array('id'=>'paisIdFiscal_co','class'=>"form-control", 'placeholder'=>"")) }}
                                </div>
                            </div>
                          </div>
                      </div>
                      <div class="col-sm-3">
                        <img src="{{asset('assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia.'/5_'.$name_image)}}" height="350" width="450" id='imaf5' data-toggle="modal" data-target="#myModal">
                      </div>
                      </div>
                      <div style="display:none">
                        {{ Form::text('venta',$datos[0]->v_id,array('class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                        <!--by amy
                          °w° agregadas dos tablas en las cuales estan los audios y la carga de los audios-->
                        @endif
                        @if(session('puesto')=='Analista de Calidad')
                        
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th> Escuchar</th>
                                    <th> Descargar</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                    @foreach($audios as $key => $values)
                    <!--obtiene la hora de la llamada-->
                        <?php $out = substr($values, 0, 2 ) ?>
                        @if ($out === "ou")
                            <?php $hora = substr($values, 30, 2) ?>
                            <?php $minuto = substr($values, 32, 2) ?>
                            <?php $segundo = substr($values, 34, 2) ?>
                        @elseif($out === "q-")
                            <?php $hora = substr($values, 29, 2) ?>
                            <?php $minuto = substr($values, 31, 2) ?>
                            <?php $segundo = substr($values, 33, 2) ?>
                        @else
                            <?php $hora = substr($values, 24, 2) ?>
                            <?php $minuto = substr($values, 26, 2) ?>
                            <?php $segundo = substr($values, 28, 2) ?>
                        @endif


                        <tr >
                            <td>
                                <source src="http://192.168.10.6:256/Grabaciones/Banamex/{{$anio}}/{{$mes}}/{{$dia}}/{{$values}}" type="audio/wav"/>
                                <div>                                    
                                    <a type="button" class="btn btn-default" target="_blank" href="http://192.168.10.6:256/Grabaciones/Banamex/{{$anio}}/{{$mes}}/{{$dia}}/{{$values}}" ;>
                                        <span class="glyphicon glyphicon-play"></span>
                                    </a>
                                </div>
                            </td>
                            <td>
                               <a href="http://192.168.10.6:256/Grabaciones/Banamex/{{$anio}}/{{$mes}}/{{$dia}}/{{$values}}" type="button" class="btn btn-default" download="audio.wav">
                                   <span class="glyphicon glyphicon-download-alt"></span>
                               </a>
                            </td>
                        </tr>
                        
                        @endforeach
                    </tbody>
                            
                        </table>
                          
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Número de audio</th>
                                    <th>Seleccionar archivo</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div>                                    
                                            Audio 1*
                                        </div>
                                    </td>
                                    <td align="center">
                                         {!! Form::file('audio') !!}
                                        <div class="form-group" style="display: none">
                                            <div class="col-sm-10">
                                                {{ Form::text('fecha',$anio,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text('mes',$mes,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text( 'dia',$dia,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text('telefono',$telefono,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>                                    
                                            Audio 2
                                        </div>
                                    </td>
                                    <td align="center">
                                         {!! Form::file('audio2') !!}
                                        <div class="form-group" style="display: none">
                                            <div class="col-sm-10">
                                                {{ Form::text('fecha',$anio,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text('mes',$mes,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text( 'dia',$dia,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text('telefono',$telefono,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>                                    
                                            Audio 3
                                        </div>
                                    </td>
                                    <td align="center">
                                         {!! Form::file('audio3') !!}
                                        <div class="form-group" style="display: none">
                                            <div class="col-sm-10">
                                                {{ Form::text('fecha',$anio,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text('mes',$mes,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text( 'dia',$dia,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text('telefono',$telefono,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>                                    
                                            Audio 4
                                        </div>
                                    </td>
                                    <td align="center">
                                         {!! Form::file('audio4') !!}
                                        <div class="form-group" style="display: none">
                                            <div class="col-sm-10">
                                                {{ Form::text('fecha',$anio,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text('mes',$mes,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text( 'dia',$dia,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text('telefono',$telefono,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>                                    
                                            Audio 5
                                        </div>
                                    </td>
                                    <td align="center">
                                         {!! Form::file('audio5') !!}
                                        <div class="form-group" style="display: none">
                                            <div class="col-sm-10">
                                                {{ Form::text('fecha',$anio,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text('mes',$mes,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text( 'dia',$dia,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                                {{ Form::text('telefono',$telefono,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>  
                        @endif
                          <!--by amy
                          °w° agregadas dos tablas en las cuales estan los audios y la carga de los audios
                          Aqui termina \(^.^)/-->
                          
                      <div id="send" style="display:none">
                        {{ Form::submit('Enviar',['id'=>'sendB','class'=>"btn btn-default",'onClick'=>'return validaVenta()']) }}
                      </div>
                        </div>
                        </div>
                      </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
@stop
@section('content2')

<script>
  var co_col_emp="{{$datos[0]->colonia_empresa}}";
  var r_co_col_emp=reem(co_col_emp);
  var co_col="{{$datos[0]->colonia}}";
  var r_co_col=reem(co_col);

  function reem(texto1) {
    // console.log(texto1);
    var text=texto1;
    var res;
      text = text.replace("&aacute;", "á");
      text = text.replace("&eacute;", "é");
      text = text.replace("&iacute;", "í");
      text = text.replace("&oacute;", "ó");
      text = text.replace("&uacute;", "ú");

      text = text.replace("&Aacute;", "Á");
      text = text.replace("&Eacute;", "É");
      text = text.replace("&Iacute;", "Í");
      text = text.replace("&Oacute;", "Ó");
      text = text.replace("&Uacute;", "Ú");
    return text;
    }

  $(document).ready(function(){
    //c_new

console.log('{{$datos[0]->lugar_nacimiento}}');
console.log('{{$datos[0]->nacionalidad}}');


    $("#imaf1").click(function(){
      console.log("{{asset('assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia.'/1_'.$name_image)}}");
      $("#imaf").attr('src',"{{asset('assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia.'/1_'.$name_image)}}");
     });
    $("#imaf2").click(function(){
      $("#imaf").attr('src',"{{asset('assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia.'/2_'.$name_image)}}");
     });
    $("#imaf3").click(function(){
      $("#imaf").attr('src',"{{asset('assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia.'/3_'.$name_image)}}");
     });
    $("#imaf4").click(function(){
      $("#imaf").attr('src',"{{asset('assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia.'/4_'.$name_image)}}");
     });
    $("#imaf5").click(function(){
      $("#imaf").attr('src',"{{asset('assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia.'/5_'.$name_image)}}");
     });


    var validaEnviar='si';
    var cont=0;
    var yearf={{date('Y')-18}};
    var yeari=yearf-75;
    for(cont=1;cont<=31;cont++){
      $('#diaNacimiento_co').append('<option value="'+cont+'">'+cont+'</option>');
    }

    for(yeari;yeari<=yearf;yeari++){
      $('#yearNacimiento_co').append('<option value="'+yeari+'">'+yeari+'</option>');
    }
    $('#diaNacimiento_co > option[value="'+{{date("d",strtotime($datos[0]->fecha_nacimiento))}}+'"]').attr('selected', 'selected');
    $('#yearNacimiento_co > option[value="'+{{date("Y",strtotime($datos[0]->fecha_nacimiento))}}+'"]').attr('selected', 'selected');
    console.log({{date("Y",strtotime($datos[0]->fecha_nacimiento))}});

    $.when(ajax5()).done(function(){
      $('#colonia_co > option[value="'+r_co_col+'"]').attr('selected', 'selected');
    });
    $.when(ajax6()).done(function(){
      $('#coloniaEmpleo_co > option[value="'+r_co_col_emp+'"]').attr('selected', 'selected');
    });

    if($("#nacionalidad_co").val()=="Soy mexicano (a)"){
      $("#nac1").show();
      $("#extran").hide();
      $("#extran1").hide();
      $("#extran2").hide();
      $("#paisnaci_co").prop('disabled',true)
    }else if($("#nacionalidad_co").val()=="Soy extranjero (a)"){
       $("#nac1").hide();
      $("#extran").show();
      $("#extran1").show();
      $("#extran2").show();
      $("#lugarNaci_co").prop('disabled',true)
    }
    else {
      $("#nac").show();
      $("#extran").hide();
      $("#extran1").hide();
      $("#extran2").hide();
    }


    $("#sendB").prop('disabled', false);
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


  });
  function address(){
    $.ajax({
      url:   "/banamex/dir/"+$("#cp_co").val(),
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
      url:   "/banamex/dir/"+$("#cp_new").val(),
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
      url:   "/banamex/dir/"+$("#cpEmpleo_co").val(),
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
      url:   "/banamex/col/"+encodeURIComponent($("#colonia_new").val())+"/"+$("#cp_new").val(),
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
      url:   "/banamex/del/"+encodeURIComponent($("#delegacion_new").val())+"/"+encodeURIComponent($("#colonia_new").val())+"/"+$("#cp_new").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        console.log(data[0].ciudad);
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
      url:   "/banamex/ciu/"+encodeURIComponent($("#ciudad_new").val())+"/"+encodeURIComponent($("#delegacion_new").val())+"/"+encodeURIComponent($("#colonia_new").val())+"/"+$("#cp_new").val(),
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
  function validaFecha(){
    if($("#diaNacimiento_co").val()!='' && $("#mesNacimiento_co").val()!='' && $("#yearNacimiento_co").val()!=''){
      $.ajax({
        url:   "/banamex/validaFecha/"+$("#diaNacimiento_co").val()+"/"+$("#mesNacimiento_co").val()+'/'+$("#yearNacimiento_co").val(),
        type:  'get',
        beforeSend: function () {
          console.log('espere');
        },
        success:  function (data)
        {
          console.log(data);
          if(data == '0' ){
            $('#diaNacimiento_co').css('color','red');
            $('#mesNacimiento_co').css('color','red');
            $('#yearNacimiento_co').css('color','red');
          }else{
            $('#diaNacimiento_co').css('color','black');
            $('#mesNacimiento_co').css('color','black');
            $('#yearNacimiento_co').css('color','black');
          }
        }
      });
    }
  }

  function validaEmail(){
    if($("#email_co").val()!=$("#confirmEmail_co").val()){
      document.getElementById("confirmEmail_co").value='';
    }
  }

  function nacionalidad(){
    if($("#nacionalidad_co").val()=="Soy mexicano (a)"){
      $("#nac1").show();
      $("#extran").hide();
      $("#extran1").hide();
      $("#extran2").hide();
      $("#paisnaci_co").prop('disabled', true);
      $("#lugarNaci_co").prop('disabled', false);
    }else if($("#nacionalidad_co").val()=="Soy extranjero (a)"){
       $("#nac1").hide();

      $("#extran").show();
      $("#extran1").show();
      $("#extran2").show();
      $("#paisnaci_co").prop('disabled', false);
      $("#lugarNaci_co").prop('disabled', true);
    }
    else {
      $("#nac").show();
      $("#extran").hide();
      $("#extran1").hide();
      $("#extran2").hide();
      $("#paisnaci_co").prop('disabled', true);
      $("#lugarNaci_co").prop('disabled', false);
    }
  }
  function ajax5(){
    return $.ajax({
      url:   "/banamex/dir/"+$("#cp_co").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        $('#colonia_co').html('');
        $('#colonia_co').append('<option value=""></option>');
        for(i=0;i<data.length;i++)
        {
          $('#colonia_co').append('<option value="'+data[i].asentamiento+'">'+data[i].asentamiento+'</option>');
        }
      }
    });
  }

  function ajax6(){
    return $.ajax({
      url:   "/banamex/dir/"+$("#cpEmpleo_co").val(),
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

</script>
@stop
