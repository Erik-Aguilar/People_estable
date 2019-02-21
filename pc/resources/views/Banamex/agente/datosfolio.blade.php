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
                <h3 class="panel-title">Banamex</h3>
            </div>
            <div class="panel-body">

              {{ Form::open(['action' => 'BanamexController@ActualizaDatos',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario"
                          ]) }}
                          <!-- style="display:none" -->
                <div class="form-group"  align='Center'>
                  {{ Form::label('DN','',array('class'=>"col-sm-1 control-label")) }}
                  <div class="col-sm-2">
                      {{ Form::text('dn',$datos[0]->dn,array('id'=>'dn','class'=>"form-control", 'placeholder'=>"",'required'=>'required','readonly'=>'readonly')) }}

                  </div>
                  <div style="display:none">
                      {{ Form::text('v_id',$datos[0]->v_id,array('id'=>'v_id','class'=>"form-control",'required'=>'required','readonly'=>'readonly')) }}
                      {{ Form::text('b_id',$datos[0]->b_id,array('id'=>'v_id','class'=>"form-control",'required'=>'required','readonly'=>'readonly')) }}
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

                <div><!-- new_client -->
                  <div class="form-group">
                      {{ Form::label('Nombre*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('nombre_new',$datos[0]->new_nombre,array('id'=>'nombre_new', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('Paterno*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('paterno_new',$datos[0]->new_paterno,array('id'=>'paterno_new', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Materno*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('materno_new',$datos[0]->new_materno,array('id'=>'materno_new', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('Telefono 1*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('tel1_new',$datos[0]->new_tel1,array('id'=>'tel1_new', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Telefono 2','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('tel2_new',$datos[0]->new_tel2,array('id'=>'tel2_new','class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('Calle*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('calle_new',$datos[0]->new_calle,array('id'=>'calle_new','class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('No. exterior*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('numext_new',$datos[0]->new_n_ext,array('id'=>'numExt_new','class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('No. Interior','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('numint_new',$datos[0]->new_n_int,array('id'=>'numInt_new','class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('CP*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('cp_new',$datos[0]->new_cp,array('id'=>'cp_new','class'=>"form-control", 'placeholder'=>"",'onChange'=>'address2()')) }}
                      </div>
                      {{ Form::label('Colonia*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::select('colonia_new', [],
                          $datos[0]->new_colonia, ['id'=>'colonia_new', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address3()']  ) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Delegacion/Municipio*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                        {{ Form::select('delegacion_new', [],
                        $datos[0]->new_delegacion, ['id'=>'delegacion_new', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address4()']  ) }}
                      </div>
                      {{ Form::label('Ciudad*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                        {{ Form::select('ciudad_new', [],
                        $datos[0]->new_ciudad, ['id'=>'ciudad_new', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address5()']  ) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Estado*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                        {{ Form::select('estado_new', [],
                        $datos[0]->new_estado, ['id'=>'estado_new', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      </div>
                      {{ Form::label('Sexo*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::select('sexo_new', [
                          'Masculino'=>'Masculino',
                          'Femenino'=>'Femenino'],
                          $datos[0]->new_sexo, ['id'=>'sexo_new', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      </div>
                  </div>



                </div>
                <div id="clientObj"><!-- cliente objetivo  -->
                  <div class="form-group">
                      {{ Form::label('Datos Personales','',array('class'=>"col-sm-2 control-label")) }}
                  </div>

                  <div class="form-group">
                      {{ Form::label('Email*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('email_co',$datos[0]->d_email,array('id'=>'email_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('Confirmacion Email*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('confirmEmail_co',$datos[0]->d_email,array('id'=>'confirmEmail_co', 'class'=>"form-control", 'placeholder'=>"",'onBlur'=>'validaEmail()')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Nombre*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('nombre_co',$datos[0]->d_nombre,array('id'=>'nombre_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('Apellido Paterno*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('paterno_co',$datos[0]->d_paterno,array('id'=>'paterno_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Apellido Materno*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('materno_co',$datos[0]->d_materno,array('id'=>'materno_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('Dia nacimiento*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                        {{ Form::select('diaNacimiento_co', [],
                        date("d",strtotime($datos[0]->d_fecha_nacimiento)), ['id'=>'diaNacimiento_co', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'validaFecha()']  ) }}
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
                        date("m",strtotime($datos[0]->d_fecha_nacimiento)), ['id'=>'mesNacimiento_co', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'validaFecha()']  ) }}
                      </div>
                      {{ Form::label('Año nacimiento*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                        {{ Form::select('yearNacimiento_co', [],
                        date("Y",strtotime($datos[0]->d_fecha_nacimiento)), ['id'=>'yearNacimiento_co', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'validaFecha()']  ) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('RFC*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('rfc_co',$datos[0]->d_rfc,array('id'=>'rfc_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('Homoclave del RFC','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('homoclave_co',$datos[0]->d_homoclave,array('id'=>'homoclave_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Telefono celular*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('telCelular_co',$datos[0]->d_telefono,array('id'=>'telCelular_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>

                  <!-- ***************************************************** -->
                  <div class="form-group">
                      {{ Form::label('Domicilio','',array('class'=>"col-sm-2 control-label")) }}
                  </div>
                  <div class="form-group">
                      {{ Form::label('Calle*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('calle_co',$datos[0]->d_calle,array('id'=>'calle_co','class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('No. exterior*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('noExt_co',$datos[0]->d_no_ext,array('id'=>'noExt_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('No. interior','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('noInt_co',$datos[0]->d_no_int,array('id'=>'noInt_co','class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('CP*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('cp_co',$datos[0]->d_cp,array('id'=>'cp_co', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address()')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Colonia*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::select('colonia_co', [],
                          $datos[0]->d_colonia, ['id'=>'colonia_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      </div>
                      {{ Form::label('Tipo Vivienda*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                        {{ Form::select('tipoVivienda_co', [
                        'Vivienda de un familiar'=>'Vivienda de un familiar',
                        'Vivienda hipotecada'=>'Vivienda hipotecada',
                        'Vivienda propia'=>'Vivienda propia',
                        'Vivienda rentada'=>'Vivienda rentada'],
                        $datos[0]->d_tipo_vivienda, ['id'=>'tipoVivienda_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
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
                        $datos[0]->d_residencia, ['id'=>'tiempoResidencia_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      </div>
                      {{ Form::label('lada domicilio','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('ladaDomi_co',$datos[0]->d_lada,array('id'=>'ladaDomi_co','class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>

                  <div class="form-group">
                      {{ Form::label('telefono*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('telDom_co',$datos[0]->d_tel_domicilio,array('id'=>'telDom_co', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address()')) }}
                      </div>
                  </div>

                  <!-- *********************** -->
                  <div class="form-group">
                      {{ Form::label('Información Financiera','',array('class'=>"col-sm-2 control-label")) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('¿Tiene tarjeta de credito?','',array('class'=>"col-sm-4 col-md-offset-1  control-label")) }}
                    <div class="col-sm-4 col-md-offset-1">
                      {{ Form::select('tieneTarjeta_co', [
                      'Si'=>'Si',
                      'No'=>'No'
                      ],
                      $datos[0]->d_tiene_tarjeta, ['id'=>'tieneTarjeta', 'class'=>"form-control", 'placeholder'=>""]  ) }}
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
                        $datos[0]->d_institucion, ['id'=>'tipoTarjeta_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      </div>

                      <div class="col-sm-4 col-md-offset-2">
                          {{ Form::text('numeroTarjeta_co',$datos[0]->d_numero_tarjeta,array('id'=>'numeroTarjeta_co', 'class'=>"form-control", 'placeholder'=>"")) }}
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
                        $datos[0]->d_hipoteca, ['id'=>'creditoHipo_co','class'=>"form-control", 'placeholder'=>""]  ) }}
                      </div>

                      <div class="col-sm-4 col-md-offset-2">
                        {{ Form::select('creditoAuto_co', [
                        'Si'=>'Si',
                        'No'=>'No'],
                        $datos[0]->d_automotriz, ['id'=>'creditoAuto_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      </div>
                  </div>
                  <!-- ************************************ -->
                  <div class="form-group">
                      {{ Form::label('Información laboral','',array('class'=>"col-sm-2 control-label")) }}
                  </div>
                  <div class="form-group">
                      {{ Form::label('Nombre de Empresa/Empleador*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('nombreEmpresa_co',$datos[0]->d_nombre_empresa,array('id'=>'nombreEmpresa_co', 'class'=>"form-control", 'placeholder'=>"")) }}
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
                        $datos[0]->d_giro_empresa, ['id'=>'giroEmpresa_co','class'=>"form-control", 'placeholder'=>""]  ) }}
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
                        $datos[0]->d_ocupacion, ['id'=>'ocupacion_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
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
                        $datos[0]->d_antiguedad, ['id'=>'antiguedad_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('ingresos mensuales*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('ingresos_co',$datos[0]->d_mensuales,array('id'=>'ingresos_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('Tipo de tarjeta*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                        {{ Form::select('tipoTarjetaSolicita_co', [
                        'Clasica'=>'Clasica',
                        'ORO'=>'ORO',
                        'PLATINUM'=>'PLATINUM',
                        'BMART'=>'BMART',
                        'PREMIER'=>'PREMIER',
                        'REWARDS'=>'REWARDS'
                        ],
                        $datos[0]->d_tipo_tarjeta, ['id'=>'tipoTarjetaSolicita_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      </div>
                  </div>

                  <div class="form-group">
                      {{ Form::label('calle*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('calleEmpleo_co',$datos[0]->d_calle_empresa,array('id'=>'calleEmpleo_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('No. exterior*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('numExt_co',$datos[0]->d_no_ext_empresa,array('id'=>'numExt_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('No. interior','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('numInt_co',$datos[0]->d_no_int_empresa,array('id'=>'numInt_co','class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('CP*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('cpEmpleo_co',$datos[0]->d_cp_empresa,array('id'=>'cpEmpleo_co', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'address21()')) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Colonia *','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                        {{ Form::select('coloniaEmpleo_co', [],
                        $datos[0]->d_colonia_empresa, ['id'=>'coloniaEmpleo_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
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
                        $datos[0]->d_nacionalidad, ['id'=>'nacionalidad_co', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'nacionalidad()']  ) }}
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
                          $datos[0]->d_lugar_nacimiento, ['id'=>'lugarNaci_co','required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                        </div>
                      </div>
                      <div id="extran1" style="display:none">
                        {{ Form::label('Pais de nacimiento*','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                          {{ Form::text('lugarNaci_co',$datos[0]->d_lugar_nacimiento,array('id'=>'paisnaci_co','class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Genero*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                        {{ Form::select('genero_co', [
                        'Masculino'=>'Masculino',
                        'Femenino'=>'Femenino'],
                        $datos[0]->d_genero, ['id'=>'genero_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      </div>
                      {{ Form::label('Estado civil*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                        {{ Form::select('estadoCivil_co', [
                        'Casado (a)'=>'Casado (a)',
                        'Divorciado (a)'=>'Divorciado (a)',
                        'Soltero (a)'=>'Soltero (a)',
                        'Viudo (a)'=>'Viudo (a)'
                        ],
                        $datos[0]->d_estado_civil, ['id'=>'estadoCivil_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
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
                        $datos[0]->d_estudios, ['id'=>'escolaridad_co', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                      </div>
                      {{ Form::label('Dependientes economicos *','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::number('depEconomicos_co',$datos[0]->d_dependientes_economicos,array('id'=>'depEconomicos_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Referencia personal(nombre)*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('refNombre_co',$datos[0]->d_nombre_referencia_personal,array('id'=>'refNombre_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('Referencia apellido(apellidos)*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('refApellidos_co',$datos[0]->d_apellido_referencia_personal,array('id'=>'refApellidos_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>
                  <div class="form-group">
                      {{ Form::label('Lada*','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                        {{ Form::text('lada_co',$datos[0]->d_lada_referencia_personal,array('id'=>'lada_co','class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      {{ Form::label('Referencia personal(telefono)*','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('refTel_co',$datos[0]->d_tel_referencia_personal,array('id'=>'refTel_co', 'class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>

                  <div class="form-group">
                      {{ Form::label('Extensión','',array('class'=>"col-sm-1 control-label")) }}
                      <div class="col-sm-4">
                          {{ Form::text('extensionRef_co',$datos[0]->d_ext_referencia_personal,array('id'=>'extensionRef_co','class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                      <div id='extran2' style="display:none">
                        {{ Form::label('Num.de id fiscal','',array('class'=>"col-sm-2 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('idFiscal_co',$datos[0]->d_id_fiscal,array('id'=>'idFiscal_co','class'=>"form-control", 'placeholder'=>"")) }}
                        </div>
                      </div>
                  </div>
                  <div id="extran" style="display:none"><!-- no nacional -->
                    <div class="form-group">
                        {{ Form::label('Pais que asigna id fiscal','',array('class'=>"col-sm-1 control-label")) }}
                        <div class="col-sm-4">
                            {{ Form::text('paisIdFiscal_co',$datos[0]->d_pais_id_fiscal,array('id'=>'paisIdFiscal_co','class'=>"form-control", 'placeholder'=>"")) }}
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
var new_col="{{$datos[0]->new_colonia}}";
var r_new_col=reem(new_col);
var new_del="{{$datos[0]->new_delegacion}}";
var r_new_del=reem(new_del);
var new_ciu="{{$datos[0]->new_ciudad}}";
var r_new_ciu=reem(new_ciu);
var new_est="{{$datos[0]->new_estado}}";
var r_new_est=reem(new_est);

var co_col_emp="{{$datos[0]->d_colonia_empresa}}";
var r_co_col_emp=reem(co_col_emp);
var co_col="{{$datos[0]->d_colonia}}";
var r_co_col=reem(co_col);

console.log(r_new_col);
console.log(r_new_del);
console.log(r_new_ciu);
console.log(r_new_est);

var cont=0;
var yearf={{date('Y')-18}};
var yeari=yearf-75;
for(cont=1;cont<=31;cont++){
  $('#diaNacimiento_co').append('<option value="'+cont+'">'+cont+'</option>');
}
for(yeari;yeari<=yearf;yeari++){
  $('#yearNacimiento_co').append('<option value="'+yeari+'">'+yeari+'</option>');
}

$('#diaNacimiento_co > option[value="'+{{date("d",strtotime($datos[0]->d_fecha_nacimiento))}}+'"]').attr('selected', 'selected');
$('#yearNacimiento_co > option[value="'+{{date("Y",strtotime($datos[0]->d_fecha_nacimiento))}}+'"]').attr('selected', 'selected');

$(document).ready(function(){
  var val="{{utf8_encode($datos[0]->new_colonia)}}";
  var val2="{{$datos[0]->new_colonia}}";
  console.log(val);
  console.log(val2);
  $.when(ajax()).done(function(){
    $('#colonia_new > option[value="'+r_new_col+'"]').attr('selected', 'selected');
    $.when(ajax2()).done(function(){
      $('#delegacion_new > option[value="'+r_new_del+'"]').attr('selected', 'selected');
      $.when(ajax3()).done(function(){
        $('#ciudad_new > option[value="'+r_new_ciu+'"]').attr('selected', 'selected');
        $.when(ajax4()).done(function(){
          $('#estado_new > option[value="'+r_new_est+'"]').attr('selected', 'selected');
        });
      });

    });
  });
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


});

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
function ajax(){
  return $.ajax({
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
function ajax2(){
    return $.ajax({
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
function ajax3(){
  return $.ajax({
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
function ajax4(){
  return $.ajax({
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
    $("#genero_co").prop('required',true);
    $("#estadoCivil_co").prop('required',true);
    $("#escolaridad_co").prop('required',true);
    $("#depEconomicos_co").prop('required',true);
    $("#refNombre_co").prop('required',true);
    $("#refApellidos_co").prop('required',true);
    $("#lada_co").prop('required',true);
    $("#refTel_co").prop('required',true);

    $("#nombre_new").prop('required',false);
    $("#paterno_new").prop('required',false);
    $("#materno_new").prop('required',false);
    $("#tel1_new").prop('required',false);
    $("#calle_new").prop('required',false);
    $("#numExt_new").prop('required',false);
    // $("#numInt_new").prop('required',true);
    $("#cp_new").prop('required',false);
    $("#colonia_new").prop('required',false);
    $("#delegacion_new").prop('required',false);
    $("#ciudad_new").prop('required',false);
    $("#estado_new").prop('required',false);
    $("#sexo_new").prop('required',false);
    $("#tarjeta_new").prop('required',false);
    $("#banco_new").prop('required',false);
    $("#tipoTarjetaSolicita_co").prop('required',false);

  }else {
    $("#send").hide();
    $("#valida").hide();
    $("#numEmpleado").prop('disabled', true);
    $("#numPass").prop('disabled', true);
  }
}
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
function validaVenta(){
  if($("#tipificacion").val()=='Venta - Validada' || $("#tipificacion").val()=='Venta - No Validada'){
    if($("#valVenta").val()==1){
      if($("#nacionalidad_co").val()=='Soy mexicano (a)'){
        $('#paisnaci_co').prop('disabled', true);
        $("#lugarNaci_co").prop('disabled', false);
        return true;
      }else {
        $('#lugarNaci_co').prop('disabled', true);
        $("#paisnaci_co").prop('disabled', false);
        return true;
      }
      // $("#valida").show();
      // $("#numEmpleado").prop('disabled', false);
      // return true;
    }
    else {
      return false
    }
  }else {
    if($("#nacionalidad_co").val()=='Soy mexicano (a)'){
      $('#paisnaci_co').prop('disabled', true);
      return true;
    }else {
      $('#lugarNaci_co').prop('disabled', true);
      return true;
    }
  }
}
</script>
@stop
