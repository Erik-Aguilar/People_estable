@extends($menu)
@section('content')
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

              {{ Form::open(['action' => 'BanamexController@GuardaReferido',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario",

                          ]) }}

                  <div class="form-group"  align='Center'>
                      {{ Form::label('DN','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-2">
                          {{ Form::text('dn','',array('id'=>'dn','class'=>"form-control", 'placeholder'=>"5512345678",'required'=>'required')) }}
                      </div>
                      {{ Form::label('Tipificacion','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-2" >
                        {{ Form::select('tipificacion', [
                        'No Contacto - Buzon de voz personal' => 'No Contacto - Buzon de voz personal',
                        'No Contacto - Buzon de voz empresa' => 'No Contacto - Buzon de voz empresa',
                        'No Contacto - Telefono no existe'=>'No Contacto - Telefono no existe',
                        'Se corta la llamada'=>'Se corta la llamada',
                        'No le interesa - No tiene tiempo'=>'No le interesa - No tiene tiempo',
                        'No le interesa - Cuelga llamada'=>'No le interesa - Cuelga llamada',
                        'No cubre el perfil'=>'No cubre el perfil',
                        'Llamar despues'=>'Llamar despues',
                        'No le interesa - Mala experiencia con los bancos'=>'No le interesa - Mala experiencia con los bancos',
                        'No le interesa - No quiere adquirir productos'=>'No le interesa - No quiere adquirir productos',
                        'No le interesa - Mala experiencia con Banamex'=>'No le interesa - Mala experiencia con Banamex',
                        'No le interesa - Problemas con buro'=>'No le interesa - Problemas con buro',
                        'No le interesa - Producto poco atractivo'=>'No le interesa - Producto poco atractivo',
                        'Venta - Validada'=>'Venta - Validada',
                        'Venta - No Validada'=>'Venta - No Validada'
                        ],
                        '', ['id'=>'tipificacion','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'tipificacion_fun()'])}}
                      </div>

                      <div id="valida" style="display: none">
                        <div class="form-group" >
                          <div class="col-sm-2">
                            {{ Form::text('empleadoVal','',array('id'=>'numEmpleado','required'=>'required','class'=>"form-control", 'placeholder'=>"Usuario",'onChange'=>'valAjax()')) }}
                          </div>
                          <div class="col-sm-2">
                            {{ Form::password('password',['required'=>'required','id'=>'numPass','class'=>'form-control','placeholder'=>'Password','onChange'=>'valAjax()']) }}
                          </div>
                          <div class="btn btn-success glyphicon glyphicon-ok" id='success' style="display: none">
                          </div>
                          <div class="btn btn-danger glyphicon glyphicon-remove" id='wrong' style="display: none">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-10" style="display: none">
                            {{ Form::text('valVenta','',array('id'=>'valVenta','required'=>'required','class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                          </div>
                        </div>
                      </div>
                  </div>

                  <div id="ccs" > <!--Crear cliente Si  -->
                    <div class="form-group">
                        {{ Form::label('Nombre*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('nombre_new','',array('id'=>'nombre_new','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                        {{ Form::label('Paterno*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('paterno_new','',array('id'=>'paterno_new','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Materno*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('materno_new','',array('id'=>'materno_new','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                        {{ Form::label('Telefono 1*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('tel1_new','',array('id'=>'tel1_new','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Telefono 2','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('tel2_new','',array('id'=>'tel2_new','class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                        {{ Form::label('Calle*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('calle_new','',array('id'=>'calle_new','class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('No. exterior*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('numext_new','',array('id'=>'numExt_new','class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                        {{ Form::label('No. Interior','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('numint_new','',array('id'=>'numInt_new','class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('CP*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('cp_new','',array('id'=>'cp_new','class'=>"form-control", 'placeholder'=>"",'onChange'=>'address2()')) }}
                        </div>
                        {{ Form::label('Colonia*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::select('colonia_new', [],
                            '', ['id'=>'colonia_new','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address3()']  ) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Delegacion/Municipio*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                          {{ Form::select('delegacion_new', [],
                          '', ['id'=>'delegacion_new','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address4()']  ) }}
                        </div>
                        {{ Form::label('Ciudad*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                          {{ Form::select('ciudad_new', [],
                          '', ['id'=>'ciudad_new','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address5()']  ) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Estado*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                          {{ Form::select('estado_new', [],
                          '', ['id'=>'estado_new','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                        </div>
                        {{ Form::label('Sexo*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::select('sexo_new', [
                            'Masculino'=>'Masculino',
                            'Femenino'=>'Femenino'],
                            '', ['id'=>'sexo_new','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                        </div>
                    </div>
                  </div>
                  <div id="cos" > <!--Cliente_objetivo Si  -->
                    <div class="form-group">
                        {{ Form::label('Datos Personales','',array('class'=>"col-sm-2 control-label")) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('Email*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('email_co','',array('id'=>'email_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                        {{ Form::label('Confirmacion Email*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('confirmEmail_co','',array('id'=>'confirmEmail_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onBlur'=>'validaEmail()')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Nombre*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('nombre_co','',array('id'=>'nombre_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                        {{ Form::label('Apellido Paterno*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('paterno_co','',array('id'=>'paterno_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Apellido Materno*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('materno_co','',array('id'=>'materno_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                        {{ Form::label('Dia nacimiento*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                          {{ Form::select('diaNacimiento_co', [],
                          '', ['id'=>'diaNacimiento_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'validaFecha()']  ) }}
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
                          '', ['id'=>'mesNacimiento_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'validaFecha()']  ) }}
                        </div>
                        {{ Form::label('Año nacimiento*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                          {{ Form::select('yearNacimiento_co', [],
                          '', ['id'=>'yearNacimiento_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'validaFecha()']  ) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('RFC*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('rfc_co','',array('id'=>'rfc_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                        {{ Form::label('Homoclave del RFC','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('homoclave_co','',array('id'=>'homoclave_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Telefono celular*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('telCelular_co','',array('id'=>'telCelular_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>
                    <!-- ***************************************************** -->
                    <div class="form-group">
                        {{ Form::label('Domicilio','',array('class'=>"col-sm-2 control-label")) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('Calle*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('calle_co','',array('id'=>'calle_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                        {{ Form::label('No. exterior*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('noExt_co','',array('id'=>'noExt_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('No. interior','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('noInt_co','',array('id'=>'noInt_co','class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                        {{ Form::label('CP*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('cp_co','',array('id'=>'cp_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address()')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Colonia*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::select('colonia_co', [],
                            '', ['id'=>'colonia_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                        </div>
                        {{ Form::label('Tipo Vivienda*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                          {{ Form::select('tipoVivienda_co', [
                          'Vivienda de un familiar'=>'Vivienda de un familiar',
                          'Vivienda hipotecada'=>'Vivienda hipotecada',
                          'Vivienda propia'=>'Vivienda propia',
                          'Vivienda rentada'=>'Vivienda rentada'],
                          '', ['id'=>'tipoVivienda_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
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
                          '', ['id'=>'tiempoResidencia_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                        </div>
                        {{ Form::label('lada domicilio','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('ladaDomi_co','',array('id'=>'ladaDomi_co','class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('telefono*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('telDom_co','',array('id'=>'telDom_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address()')) }}
                        </div>
                    </div>
                    <!-- *********************** -->
                    <div class="form-group">
                        {{ Form::label('Información Financiera','',array('class'=>"col-sm-2 control-label")) }}
                    </div>
                    <div class="form-group">
                      {{ Form::label('¿Tiene tarjeta de credito?','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-10 ">
                        {{ Form::select('tieneTarjeta_co', [
                        'Si'=>'Si',
                        'No'=>'No'
                        ],
                        '', ['id'=>'tieneTarjeta', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      </div>
                    </div>
                    <div class="form-group">
                      {{ Form::label('¿Tienes alguna tarjeta de credito?(no nómina o débito) ','',array('class'=>"col-sm-4 col-md-offset-1  control-label")) }}
                      {{ Form::label('Numero de tarjeta(ultimos 4 digitos)','',array('class'=>"col-sm-5 control-label")) }}
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
                          '', ['id'=>'tipoTarjeta_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                        </div>

                        <div class="col-sm-4 col-md-offset-2">
                            {{ Form::text('numeroTarjeta_co','',array('id'=>'numeroTarjeta_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>
                    <div class="form-group">
                      {{ Form::label('¿Tienes algun credito hipotecario?(solo se valoran los creditos activos con mas de 2 años de vigencia no consideres creditos fovissste)','',array('class'=>"col-sm-4 col-md-offset-1 control-label")) }}
                      {{ Form::label('¿Tienes un credito Automotriz?(aperturado ultimos 2 años)','',array('class'=>"col-sm-5 col-md-offset-1 control-label")) }}
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-md-offset-1">
                          {{ Form::select('creditoHipo_co', [
                          'Si'=>'Si',
                          'No'=>'No'],
                          '', ['id'=>'creditoHipo_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                        </div>
                        <div class="col-sm-4 col-md-offset-2">
                          {{ Form::select('creditoAuto_co', [
                          'Si'=>'Si',
                          'No'=>'No'],
                          '', ['id'=>'creditoAuto_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                        </div>
                    </div>
                    <!-- ************************************ -->
                    <div class="form-group">
                        {{ Form::label('Información laboral','',array('class'=>"col-sm-2 control-label")) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('Nombre de Empresa/Empleador*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('nombreEmpresa_co','',array('id'=>'nombreEmpresa_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
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
                          '', ['id'=>'giroEmpresa_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
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
                          '', ['id'=>'ocupacion_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
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
                          '', ['id'=>'antiguedad_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('ingresos mensuales*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('ingresos_co','',array('id'=>'ingresos_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
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
                          '', ['id'=>'tipoTarjetaSolicita_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('calle*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('calleEmpleo_co','',array('id'=>'calleEmpleo_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                        {{ Form::label('No. exterior*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('numExt_co','',array('id'=>'numExt_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('No. interior','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('numInt_co','',array('id'=>'numInt_co','class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                        {{ Form::label('CP*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('cpEmpleo_co','',array('id'=>'cpEmpleo_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address21()')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Colonia *','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                          {{ Form::select('coloniaEmpleo_co', [],
                          '', ['id'=>'coloniaEmpleo_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                        </div>
                    </div>
                    <!-- *********************************** -->
                    <div class="form-group">
                        {{ Form::label('Datos complementarios','',array('class'=>"col-sm-2 control-label")) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('Nacionalidad*','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                          {{ Form::select('nacionalidad_co', [
                          'Soy mexicano (a)'=>'Soy mexicano (a)',
                          'Soy extranjero (a)'=>'Soy extranjero (a)'],
                          '', ['id'=>'nacionalidad_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'nacionalidad()']  ) }}
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
                            '', ['id'=>'lugarNaci_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                          </div>
                        </div>
                        <div id="extran1" style="display:none">
                          {{ Form::label('Pais de nacimiento*','',array('class'=>"col-sm-2 control-label")) }}
                          <div class="col-sm-4">
                            {{ Form::text('lugarNaci_co','',array('id'=>'paisnaci_co','class'=>"form-control", 'placeholder'=>"")) }}
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
                            '', ['id'=>'genero_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                          </div>
                          {{ Form::label('Estado civil*','',array('class'=>"col-sm-2 control-label")) }}
                          <div class="col-sm-4">
                            {{ Form::select('estadoCivil_co', [
                            'Casado (a)'=>'Casado (a)',
                            'Divorciado (a)'=>'Divorciado (a)',
                            'Soltero (a)'=>'Soltero (a)',
                            'Viudo (a)'=>'Viudo (a)'
                            ],
                            '', ['id'=>'estadoCivil_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
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
                            '', ['id'=>'escolaridad_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                          </div>
                          {{ Form::label('Dependientes economicos *','',array('class'=>"col-sm-2 control-label")) }}
                          <div class="col-sm-4">
                              {{ Form::number('depEconomicos_co','',array('id'=>'depEconomicos_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                          </div>
                      </div>
                      <div class="form-group">
                          {{ Form::label('Referencia personal(nombre)*','',array('class'=>"col-sm-1 control-label")) }}
                          <div class="col-sm-4">
                              {{ Form::text('refNombre_co','',array('id'=>'refNombre_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                          </div>
                          {{ Form::label('Referencia apellido(apellidos)*','',array('class'=>"col-sm-2 control-label")) }}
                          <div class="col-sm-4">
                              {{ Form::text('refApellidos_co','',array('id'=>'refApellidos_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                          </div>
                      </div>
                      <div class="form-group">
                          {{ Form::label('Lada*','',array('class'=>"col-sm-1 control-label")) }}
                          <div class="col-sm-4">
                            {{ Form::text('lada_co','',array('id'=>'lada_co','class'=>"form-control", 'placeholder'=>"")) }}
                          </div>
                          {{ Form::label('Referencia personal(telefono)*','',array('class'=>"col-sm-2 control-label")) }}
                          <div class="col-sm-4">
                              {{ Form::text('refTel_co','',array('id'=>'refTel_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                          </div>
                      </div>
                      <div class="form-group">
                          {{ Form::label('Extensión','',array('class'=>"col-sm-1 control-label")) }}
                          <div class="col-sm-4">
                              {{ Form::text('extensionRef_co','',array('id'=>'extensionRef_co','class'=>"form-control", 'placeholder'=>"")) }}
                          </div>
                          <div id='extran2' style="display:none">
                            {{ Form::label('Num.de id fiscal','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-4">
                                {{ Form::text('idFiscal_co','',array('id'=>'idFiscal_co','class'=>"form-control", 'placeholder'=>"")) }}
                            </div>
                          </div>
                      </div>
                    </div>
                    <div id="extran" style="display:none"><!-- no nacional -->
                      <div class="form-group">
                          {{ Form::label('Pais que asigna id fiscal','',array('class'=>"col-sm-1 control-label")) }}
                          <div class="col-sm-4">
                              {{ Form::text('paisIdFiscal_co','',array('id'=>'paisIdFiscal_co','class'=>"form-control", 'placeholder'=>"")) }}
                          </div>
                      </div>
                    </div>
                  </div>
                  <div id="send" style="display:none">
                    {{ Form::submit('Enviar',['class'=>"btn btn-default",'onClick'=>'return validaVenta()']) }}
                  </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('content2')
<script>
  $(document).ready(function(){
    //c_new
    //   $("#numEmpleado").prop('disabled', true);
    //   $("#numPass").prop('disabled', true);
    //   $("#c_new").prop('disabled', true);
    //   $("#nombre_new").prop('disabled', true);
    //   $("#paterno_new").prop('disabled', true);
    //   $("#materno_new").prop('disabled', true);
    //   $("#tel1_new").prop('disabled', true);
    //   $("#tel2_new").prop('disabled', true);
    //   $("#calle_new").prop('disabled', true);
    //   $("#numExt_new").prop('disabled', true);
    //   $("#numInt_new").prop('disabled', true);
    //   $("#cp_new").prop('disabled', true);
    //   $("#colonia_new").prop('disabled', true);
    //   $("#delegacion_new").prop('disabled', true);
    //   $("#ciudad_new").prop('disabled', true);
    //   $("#estado_new").prop('disabled', true);
    //   $("#sexo_new").prop('disabled', true);
    //   $("#tarjeta_new").prop('disabled', true);
    //   $("#banco_new").prop('disabled', true);
    //   $("#c_objetivo").prop('disabled', true);
    //   $("#cContrata_new").prop('disabled', true);
    //   $("#tipoTarjetaSolicita_co").prop('disabled', true);
    // //field c_obletivo anableb
    //   $("#email_co").prop('disabled', true);
    //   $("#confirmEmail_co").prop('disabled', true);
    //   $("#nombre_co").prop('disabled', true);
    //   $("#paterno_co").prop('disabled', true);
    //   $("#materno_co").prop('disabled', true);
    //   $("#diaNacimiento_co").prop('disabled', true);
    //   $("#mesNacimiento_co").prop('disabled', true);
    //   $("#yearNacimiento_co").prop('disabled', true);
    //   $("#rfc_co").prop('disabled', true);
    //   $("#homoclave_co").prop('disabled', true);
    //   $("#telCelular_co").prop('disabled', true);
    //   $("#calle_co").prop('disabled', true);
    //   $("#noExt_co").prop('disabled', true);
    //   $("#noInt_co").prop('disabled', true);
    //   $("#cp_co").prop('disabled', true);
    //   $("#colonia_co").prop('disabled', true);
    //   $("#tipoVivienda_co").prop('disabled', true);
    //   $("#tiempoResidencia_co").prop('disabled', true);
    //   $("#ladaDomi_co").prop('disabled', true);
    //   $("#telDom_co").prop('disabled', true);
    //   $("#tipoTarjeta_co").prop('disabled', true);
    //   $("#numeroTarjeta_co").prop('disabled', true);
    //   $("#creditoHipo_co").prop('disabled', true);
    //   $("#creditoAuto_co").prop('disabled', true);
    //   $("#nombreEmpresa_co").prop('disabled', true);
    //   $("#giroEmpresa_co").prop('disabled', true);
    //   $("#ocupacion_co").prop('disabled', true);
    //   $("#antiguedad_co").prop('disabled', true);
    //   $("#ingresos_co").prop('disabled', true);
    //   $("#calleEmpleo_co").prop('disabled', true);
    //   $("#numExt_co").prop('disabled', true);
    //   $("#numInt_co").prop('disabled', true);
    //   $("#cpEmpleo_co").prop('disabled', true);
    //   $("#coloniaEmpleo_co").prop('disabled', true);
    //   $("#nacionalidad_co").prop('disabled', true);
    //   $("#lugarNaci_co").prop('disabled', true);
    //   $("#genero_co").prop('disabled', true);
    //   $("#estadoCivil_co").prop('disabled', true);
    //   $("#escolaridad_co").prop('disabled', true);
    //   $("#depEconomicos_co").prop('disabled', true);
    //   $("#refNombre_co").prop('disabled', true);
    //   $("#refApellidos_co").prop('disabled', true);
    //   $("#lada_co").prop('disabled', true);
    //   $("#refTel_co").prop('disabled', true);
    //   $("#extensionRef_co").prop('disabled', true);

    var cont=0;
    var yearf={{date('Y')-18}};
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
        url:   "banamex/validaFecha/"+$("#diaNacimiento_co").val()+"/"+$("#mesNacimiento_co").val()+'/'+$("#yearNacimiento_co").val(),
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
  function valAjax(){
    $.ajax({
                  url:   "/banamex/validaVenta/"+$("#numEmpleado").val()+"/"+$("#numPass").val(),
                  type:  'get',

                  success:  function (data)
                  {
                    console.log(data);
                    if(data == 1 ){
                      console.log("bien");
                      $("#valVenta").val('1');
                      $("#success").show();
                      $("#wrong").hide();
                    }
                    else {
                      console.log("error");
                       $("#valVenta").val('0');
                       $("#success").hide();
                       $("#wrong").show();
                    }

                  }
          });
          console.log("laalla");
          return false;
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
</script>
@stop
