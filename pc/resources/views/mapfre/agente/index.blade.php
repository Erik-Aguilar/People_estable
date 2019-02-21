@extends('layout.mapfre.agente')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#inicioVenta" style="float:right; padding:0px; marging:0px;">Inicio de Venta</button>
                <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#finVenta" style="float:right; padding:0px; marging:0px;">Cierre de Venta</button>
                <h3 class="panel-title">Agente</h3>
            </div>

            <div id="inicioVenta" class="modal fade" role="dialog">
              <div class="col-sm-10 col-md-offset-1">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Inicio de Venta</h4>
                  </div>
                  <div class="modal-body">
                    <p>Buenos (días, tardes o noches), se encuentra el / la (Sr. Sra. Srita.) _________________?</p><br>
                      <p>Mucho gusto, mi nombre es ___________ y hablo de la empresa MAPFRE. El motivo de mi
                      llamada es para informarle que usted tiene la posibilidad de adquirir el PROGRAMA ASISTENCIA
                      FAMILIAR 10 que su Tarjeta de Débito Banamex le ofrece:</p><br>
                      <p>Sugerencias de Beneficios:</p><br>
                      <p>Médico a domicilio (Mencionar cualquiera de los beneficios, no es necesario que estén todos)</p><br>
                      <p>Envío de ambulancia</p><br>
                      <p>Consulta y limpieza dental</p><br>
                      <p>Reparación de tuberías, cristales, instalación eléctrica, cerrajería, etc.</p><br>
                      <p>El costo de este servicio es de $99.00 pesos al mes y podrá utilizarlo sin costo por lo que resta del
                      mes (utilizar este argumento hasta el día 21).</p><br>
                      <p>Para que a partir del día de mañana pueda conocer todos los beneficios del Programa, puede
                      llamar directamente al teléfono que le voy a proporcionar, ¿Tiene dónde anotar? – Esperar
                      confirmación del cliente – En el D.F. y Área Metropolitana al 5169-3918 y desde el Interior de la
                      República al 01-800-000-3673.</p><br>
                      <p>Adicionalmente, estará recibiendo más información del Programa, así como una Cuponera de
                      Descuentos con cobertura en más de 8,000 establecimientos a nivel nacional. ¿Le gustaría recibir
                      la información por correo electrónico, o físicamente en su domicilio? – Esperar respuesta del cliente–</p><br>
                      <p>Si lo desea físico en su domicilio: “¿podría proporcionarme su domicilio actual, por favor?”.</p>
                      <p>Si lo desea por correo electrónico: “¿podría proporcionarme su correo electrónico, por favor?”</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                  </div>
                </div>

              </div>
            </div>

            <div id="finVenta" class="modal fade" role="dialog">
              <div class="col-sm-10 col-md-offset-1">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cierre de Venta</h4>
                  </div>
                  <div class="modal-body">
                    <p>Gracias Sr./Sra./Srita. _____________, Desea ADQUIRIR el servicio de Asistencia Familiar 10 que
                       Mapfre le ofrece? – Esperar respuesta del Cliente (debe ser un SI expreso)</p><br>
                      <p>Si la respuesta es “No” – se podrá utilizar nuevamente argumento de convencimiento (solamente
                        dos veces antes de cerrar la llamada)</p><br>
                        <p>Si la respuesta es “Sí” – Gracias, a modo de confirmación necesito que me proporcione su fecha
                        de nacimiento o su RFC, por favor. – Esperar información del cliente</p><br>
                        <p>Gracias, le proporciono su número de membresía: MAXXXXX y a partir de 24 horas puede utilizar
                        el servicio.</p><br>
                        <p>El cargo por servicio se realizará en los primeros días de cada mes a su Tarjeta de Débito
                        Banamex con terminación XXXX y las leyendas con las que verá reflejado el cargo en su estado de
                        cuenta son:</p><br>
                        <p>– Cobro de Domiciliación Asistencia Familiar 10</p><br>
                        <p>– Domiciliación y un número de referencia.</p><br>
                        <p>En caso de que desee cancelar el servicio, podrá realizarlo en el momento que usted lo requiera,
                        sin ningún costo, acudiendo a cualquier sucursal Banamex o llamado al 01800 -000-3673…</p><br>
                        <p>Lo invito a consultar nuestro aviso de privacidad en www.mapfreasistencia.com</p><br>
                        <p>Le comento que esta llamada ha sido grabada para efectos de calidad. Mi nombre es _________
                        de Mapfre Asistencia, que tenga excelente día.</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                  </div>
                </div>

              </div>
            </div>

            <div class="panel-body">

                {{ Form::open(['action' => 'MapfreController@NuevoRegistro',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data"
                            ]) }}

                <div class="form-group">
                    {{ Form::label('Número de Cliente','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('num_cliente',$dato[0]->numcliente,array('id'=>'numCliente','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Nombre Completo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('nombre_completo',$dato[0]->nombre,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Teléfono(Casa)','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                      {{ Form::text('tel_casa',$dato[0]->tel_casa,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly',"id"=>"homePhone")) }}
                    </div>
                    <div class="col-sm-1">
                    <!-- <a id='telefonoset_home' class="btn btn-success glyphicon glyphicon-earphone" style="float: left; display:none;" onclick="valtc()"></a> -->
                    <a id='telefonoset_home' class="btn btn-success glyphicon glyphicon-earphone"  onclick="valtc()"></a>
                    </div>
                </div>

                <div class="form-group" id="codificacion_telcasa" style="display:none;">
                    {{ Form::label('Codificación','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('codificacion_telcasa', [
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
                      null, ['required'=>'required','id'=>'codificacion_telcasa_form', 'class'=>"form-control", 'placeholder'=>"", "onchange"=>"codificacionTelCasa(this.value)","disabled"=>'disabled']  ) }}
                    </div>
                </div>

                <div class="form-group" style="display:none;">
                    <div class="col-sm-9">
                      {{ Form::text('val_telcasa','',array( 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly',"id"=>"val_telcasa")) }}
                    </div>
                </div>



                <div class="form-group">
                    {{ Form::label('Teléfono(Oficina)','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                      {{ Form::text('tel_oficina',$dato[0]->tel_oficina,array( 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly',"id"=>"workPhone")) }}
                    </div>
                    <div class="col-sm-1">
                    <a id='telefonoset_work' class="btn btn-success glyphicon glyphicon-earphone" style="float: left; display:none;" onclick="valto()"></a>
                    </div>
                </div>

                <div class="form-group" id="codificacion_telofic" style="display:none;">
                    {{ Form::label('Codificación','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('codificacion_telofic', [
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
                      null, ['required'=>'required','id'=>'codificacion_telofic_form', 'class'=>"form-control", 'placeholder'=>"", "onchange"=>"codificacionTelOfic(this.value)","disabled"=>'disabled']  ) }}
                    </div>
                </div>
                <div class="form-group" style="display:none;">
                    <div class="col-sm-9">
                      {{ Form::text('val_oficina','',array( 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly',"id"=>"val_oficina")) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Celular(Personal)','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                      {{ Form::text('cel_personal',$dato[0]->cel_personal,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly',"id"=>"cellPhone")) }}
                    </div>
                    <div class="col-sm-1">
                    <a id='telefonoset_ownCellPhone' class="btn btn-success glyphicon glyphicon-earphone" style="float: left; display:none;" onclick="valcp()"></a>
                    </div>
                </div>


                <div class="form-group" id="codificacion_celper" style="display:none;">
                    {{ Form::label('Codificación','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('codificacion_celper', [
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
                      '27' => 'Buzén celular',
                      '28' => 'No Conectado (Predictivo)',
                      '29' => 'Teléfonos Agotados Sin Contacto'],
                      null, ['required'=>'required','id'=>'codificacion_celper_form', 'class'=>"form-control", 'placeholder'=>"", "onchange"=>"codificacionCelPer(this.value)","disabled"=>'disabled']  ) }}
                    </div>
                </div>

                <div class="form-group" style="display:none;">
                    <div class="col-sm-9">
                      {{ Form::text('val_celpersonal','',array( 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly',"id"=>"val_celpersonal")) }}
                    </div>
                </div>


                <div class="form-group">
                    {{ Form::label('Celular (Trabajo)','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-8">
                      {{ Form::text('cel_trabajo',$dato[0]->cel_trabajo,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly',"id"=>'workCellPhone')) }}
                    </div>
                    <div class="col-sm-1">
                    <a id='telefonoset_workCellPhone' class="btn btn-success glyphicon glyphicon-earphone" style="float: left; display:none;" onclick="valct()"></a>
                    </div>
                </div>

                <div class="form-group" id="codificacion_celtrab" style="display:none;">
                    {{ Form::label('Codificación','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('codificacion_celtrab', [
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
                      '29' => 'Telefonos Agotados Sin Contacto'],
                      null, ['required'=>'required','id'=>'codificacion_celtrab_form', 'class'=>"form-control", 'placeholder'=>"", "onchange"=>"codificacionCelTrab(this.value)","disabled"=>'disabled']  ) }}
                    </div>
                </div>

                <div class="form-group" style="display:none;">
                    <div class="col-sm-9">
                      {{ Form::text('val_celtrabajo','',array( 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly',"id"=>"val_celtrabajo")) }}
                    </div>
                </div>



                <div class="form-group" id='divNuevoNum'>
                    {{ Form::label('Nuevo Número *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('nuevo_numero', [
                      'Si' => 'Si',
                      'No' => 'No'],
                      null, ['id'=>'nuevoNum_form','class'=>"form-control", 'placeholder'=>"", "onchange"=>"newPhone(this.value)",'required'=>'required']  ) }}
                    </div>
                </div>


                <!--######################################## New Phone #########################################################################################-->

                <div style="display:none;" id="newPhone">
                  <div class="form-group">
                      {{ Form::label('Nuevo Teléfono','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-8">
                        {{ Form::text('nuevo_telefono',null,array('required'=>'required','class'=>"form-control", 'placeholder'=>"","id"=>"newNumber")) }}
                      </div>
                      <div class="col-sm-1">
                      <a id='telefonoset_new' class="btn btn-success glyphicon glyphicon-earphone" style="float: left;" onclick="valnt()"></a>
                      </div>
                  </div>

                <div class="form-group" id="codificacion_nuevonumdiv" style="display:none;">
                    {{ Form::label('Codificación','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('codificacion_nuevonum', [
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
                      null, ['required'=>'required','id'=>'codificacion_nuevonumdiv_form','class'=>"form-control", 'placeholder'=>"", "onchange"=>"codificacion_nuevonum(this.value)","disabled"=>'disabled']  ) }}
                    </div>
                </div>

                <div class="form-group" style="display:none;">
                    <div class="col-sm-9">
                      {{ Form::text('val_nuevonum','',array( 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly',"id"=>"val_nuevonum")) }}
                    </div>
                </div>

                <div class="form-group">
                  {{ Form::label('Tipo de Número Marcado','',array('class'=>"col-sm-2 control-label")) }}
                  <div class="col-sm-9">
                    {{ Form::select('numero_marcado', [
                    '1' => 'Tel Casa',
                    '2' => 'Tel Oficina',
                    '3' => 'Cel Personal',
                    '4' => 'Cel Trabajo'],
                    null, ['required'=>'required','id'=>'tipoNewNumber', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                  </div>
                </div>
              </div>

                <!--###################################### Fin New Phone #########################################################################################-->







                <div class="form-group">
                    {{ Form::label('Fecha de Nacimiento','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('fecha_nacimiento',$dato[0]->fnacim,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Sexo','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('sexo',$dato[0]->sexo,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Estado','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('estado',$dato[0]->edo,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Población','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('poblacion',$dato[0]->poblacion,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Cuenta de Débito','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('cuenta_debito',$dato[0]->cuenta_debito,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Nombre de Cuenta','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('nombre_cuenta',$dato[0]->nombre_cuenta,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Rango de Edad','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('rango_edad',$dato[0]->rango_de_edad,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Mejor Email','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('m_email',$dato[0]->mejor_email,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Póliza','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('poliza',$dato[0]->poliza,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('RFC','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('rfc',$dato[0]->rfc,array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly')) }}
                    </div>
                </div>

                <div class="form-group" id="nuevoReferidodiv">
                    {{ Form::label('Nuevo Referido *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('nuevo_referido', [
                      'Si' => 'Si',
                      'No' => 'No'],
                      null, ['required'=>'required','id'=>'nuevoReferido_form','class'=>"form-control", 'placeholder'=>"", "onchange"=>"newReferred(this.value)"]  ) }}
                    </div>
                </div>

                <!--############################### Nuevo Referido #####################################-->
                <div style='display: none;' id="newReferred">
                  <div class="form-group">
                      {{ Form::label('Nombre Completo *','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-9">
                        {{ Form::text('referido_nombre_completo',null,array('class'=>"form-control", 'placeholder'=>"" ,'required'=>'required','id'=>'ref_name')) }}
                      </div>
                  </div>

                  <div class="form-group">
                      {{ Form::label('Cuenta de Débito *','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-9">
                        {{ Form::text('referido_cuenta_debito',null,array('class'=>"form-control", 'placeholder'=>"" ,'required'=>'required','id'=>'ref_cuentad')) }}
                      </div>
                  </div>

                  <div class="form-group">
                      {{ Form::label('Nombre de Cuenta *','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-9">
                        {{ Form::text('referido_nombre_cuenta',null,array('class'=>"form-control", 'placeholder'=>"",'required'=>'required','id'=>'ref_cuentan')) }}
                      </div>
                  </div>

                  <div class="form-group">
                      {{ Form::label('Rango de Edad *','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-9">
                        {{ Form::select('referido_rango_edad', [
                        'De 18 a 25' => 'De 18 a 25',
                        'De 26 a 35' => 'De 26 a 35',
                        'De 36 a 45' => 'De 36 a 45',
                        'De 46 a 55' => 'De 46 a 55',
                        'De 56 a 65' => 'De 56 a 65',
                        'Mayor a 65' => 'Mayor a 65'],
                        null, ['id'=>'ref_rango','class'=>"form-control", 'placeholder'=>"",'required'=>'required']) }}
                      </div>
                  </div>
                </div>
                <!--############################### Fin Nuevo Referido #####################################-->


                <div class="form-group" id="medio_entrega_div">
                    {{ Form::label('Medio de Entrega *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::select('medioEntrega', [
                      'Correo Electronico' => 'Correo Electronico',
                      'Informacion Impresa' => 'Domicilio'],
                      null, ['required'=>'required','id'=>'medio_entrega_form','class'=>"form-control", 'placeholder'=>"", "onchange"=>"newAddress(this.value)"]  ) }}
                    </div>
                </div>

                <!-- ##################################### Domicilio ###################################################  -->

                <div style="display:none;" id="newAddress">
                  <div class="form-group">
                      {{ Form::label('Estado *','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-9">
                        {{ Form::text('state',$dato[0]->edo,array('class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>

                  <div class="form-group">
                      {{ Form::label('Delegación/Municipio *','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-9">
                        {{ Form::text('town','',array('class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>

                  <div class="form-group">
                      {{ Form::label('Colonia *','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-9">
                           {{ Form::text('col','',array('class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>

                  <div class="form-group">
                      {{ Form::label('Código Postal *','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-9">
                        {{ Form::text('cp','',array('class'=>"form-control", 'placeholder'=>"")) }}
                      </div>
                  </div>

                  <div class="form-group">
                    {{ Form::label('Calle *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('calle','',array('required'=>'required','id'=>'calle','class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                  </div>

                  <div class="form-group">
                    {{ Form::label('Número *','',array('class'=>"col-sm-2 control-label")) }}
                    <div class="col-sm-9">
                      {{ Form::text('numero_calle','',array('required'=>'required','id'=>'numero','class'=>"form-control", 'placeholder'=>"")) }}
                    </div>
                  </div>

                </div>

                <!-- ##################################### Fin Domicilio ###################################################  -->

                <!-- ##################################### Nuevo Correo Electronic###################################################  -->
                <div style="display:none" id="newEmail">
                  <div class="form-group">
                      {{ Form::label('Correo Electrónico *','',array('class'=>"col-sm-2 control-label")) }}
                      <div class="col-sm-9">
                          {{ Form::email('email','',array('required'=>'required','id'=>'email','class'=>"form-control",'disable')) }}
                      </div>
                  </div>
                </div>
                <!-- ##################################### Fin Nuevo Correo Electronic###################################################  -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
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
//32591485
$( document ).ready(function()
{
  if($("#homePhone").val()!='')
  {
    $("#codificacion_telcasa").show();
    $('#codificacion_telcasa_form').prop("disabled",false);
    $("#val_telcasa").val("1");


  }
  else if ($("#workPhone").val()!='') {
    $("#codificacion_telofic").show();
    $('#codificacion_telofic_form').prop("disabled",false);
    $("#val_oficina").val("1");


  }
  else if ($("#cellPhone").val()!='') {
    $("#codificacion_celper").show();
    $('#codificacion_celper_form').prop("disabled",false);
    $("#val_celpersonal").val("1");


  }
  else if ($("#workCellPhone").val()!='') {
    $("#codificacion_celtrab").show();
    $('#codificacion_celtrab_form').prop("disabled",false);
    $("#val_celtrabajo").val("1");


  }
});

function codificacionTelCasa(telcasa)
{
  if(telcasa!='0')
  {
    $('#telefonoset_work').hide();
    $('#telefonoset_ownCellPhone').show();
    $('#telefonoset_workCellPhone').hide();

    if ($("#workPhone").val()!='') {
      $('#telefonoset_work').show();
    }
    else if ($("#cellPhone").val()!='') {
      $('#telefonoset_ownCellPhone').show();
    }
    else if ($("#workCellPhone").val()!='') {
      $('#telefonoset_workCellPhone').show();
    }

    $('#codificacion_telofic').hide();
    $('#codificacion_celper').hide();
    $('#codificacion_celtrab').hide();

    $('#codificacion_telofic_form').hide();
    $('#codificacion_celper_form').hide();
    $('#codificacion_celtrab_form').hide();

    $('#codificacion_telofic_form').prop("disabled",true);
    $('#codificacion_celper_form').prop("disabled",true);
    $('#codificacion_celtrab_form').prop("disabled",true);

    $('#divNuevoNum').hide();
    $('#nuevoNum_form').prop("disabled",true);

    $("#newPhone").hide();
    $('#nuevo_numeroid').prop("disabled",true);
    $('#newNumber').prop("disabled",true);
    $('#tipoNewNumber').prop("disabled",true);

    $('#nuevoReferidodiv').hide();
    $('#nuevoReferido_form').prop("disabled",true);

    $("#newReferred").hide();
    $('#ref_name').prop("disabled",true);
    $('#ref_cuentad').prop("disabled",true);
    $('#ref_cuentan').prop("disabled",true);
    $('#ref_rango').prop("disabled",true);


    $("#medio_entrega_div").hide();
    $('#medio_entrega_form').prop("disabled",true);

    $('#state').prop("disabled",true);
    $('#town').prop("disabled",true);
    $('#col').prop("disabled",true);
    $('#cp').prop("disabled",true);
    $('#calle').prop("disabled",true);
    $('#numero').prop("disabled",true);
    $('#email').prop("disabled",true);

  }
  else
  {
    $('#telefonoset_work').hide();
    $('#telefonoset_ownCellPhone').hide();
    $('#telefonoset_workCellPhone').hide();

    $('#divNuevoNum').show();
    $('#nuevoNum_form').prop("disabled",false);


    $('#codificacion_telofic').hide();
    $('#codificacion_celper').hide();
    $('#codificacion_celtrab').hide();

    $('#codificacion_telofic_form').hide();
    $('#codificacion_celper_form').hide();
    $('#codificacion_celtrab_form').hide();

    $('#codificacion_telofic_form').prop("disabled",true);
    $('#codificacion_celper_form').prop("disabled",true);
    $('#codificacion_celtrab_form').prop("disabled",true);



    // $("#newPhone").show();
    // $('#nuevo_numeroid').prop("disabled",false);
    // $('#newNumber').prop("disabled",false);
    // $('#tipoNewNumber').prop("disabled",false);

    $('#nuevoReferidodiv').show();
    $('#nuevoReferido_form').prop("disabled",false);


    $("#medio_entrega_div").show();
    $('#medio_entrega_form').prop("disabled",false);

    // $("#newReferred").show();
    // $('#ref_name').prop("disabled",false);
    // $('#ref_cuentad').prop("disabled",false);
    // $('#ref_cuentan').prop("disabled",false);
    // $('#ref_rango').prop("disabled",false);

    // if ($("#workPhone").val()!='') {
    //   $('#telefonoset_work').show();
    // }
    // else if ($("#cellPhone").val()!='') {
    //   $('#telefonoset_ownCellPhone').show();
    // }
    // else if ($("#workCellPhone").val()!='') {
    //   $('#telefonoset_workCellPhone').show();
    // }
     newAddress($("#medio_entrega_form").val());
  }
}
function codificacionTelOfic(telofic)
{
  if(telofic!='0')
  {
    // $('#telefonoset_ownCellPhone').hide();
    // $('#telefonoset_workCellPhone').hide();

    if ($("#cellPhone").val()!='') {
      $('#telefonoset_ownCellPhone').show();
    }
    else if ($("#workCellPhone").val()!='') {
      $('#telefonoset_workCellPhone').show();
    }

    $('#codificacion_celper').hide();
    $('#codificacion_celtrab').hide();

    // $('#codificacion_telofic_form').hide();
    $('#codificacion_celper_form').hide();
    $('#codificacion_celtrab_form').hide();

    $('#codificacion_celper_form').prop("disabled",true);
    $('#codificacion_celtrab_form').prop("disabled",true);

    $('#divNuevoNum').hide();
    $('#nuevoNum_form').prop("disabled",true);

    $("#newPhone").hide();
    $('#nuevo_numeroid').prop("disabled",true);
    $('#newNumber').prop("disabled",true);
    $('#tipoNewNumber').prop("disabled",true);

    /*---------------*/
    $('#nuevoReferidodiv').hide();
    $('#nuevoReferido_form').prop("disabled",true);

    $("#newReferred").hide();
    $('#ref_name').prop("disabled",true);
    $('#ref_cuentad').prop("disabled",true);
    $('#ref_cuentan').prop("disabled",true);
    $('#ref_rango').prop("disabled",true);

    $("#medio_entrega_div").hide();
    $('#medio_entrega_form').prop("disabled",true);

    $('#state').prop("disabled",true);
    $('#town').prop("disabled",true);
    $('#col').prop("disabled",true);
    $('#cp').prop("disabled",true);
    $('#calle').prop("disabled",true);
    $('#numero').prop("disabled",true);
    $('#email').prop("disabled",true);


  }
  else
  {
    // $('#telefonoset_work').hide();
    $('#telefonoset_ownCellPhone').hide();
    $('#telefonoset_workCellPhone').hide();

    $('#divNuevoNum').show();
    $('#nuevoNum_form').prop("disabled",false);


    // $('#codificacion_telofic').hide();
    $('#codificacion_celper').hide();
    $('#codificacion_celtrab').hide();

    // $('#codificacion_telofic_form').hide();
    $('#codificacion_celper_form').hide();
    $('#codificacion_celtrab_form').hide();

    // $('#codificacion_telofic_form').prop("disabled",true);
    $('#codificacion_celper_form').prop("disabled",true);
    $('#codificacion_celtrab_form').prop("disabled",true);



    // $("#newPhone").show();
    // $('#nuevo_numeroid').prop("disabled",false);
    // $('#newNumber').prop("disabled",false);
    // $('#tipoNewNumber').prop("disabled",false);

    $('#nuevoReferidodiv').show();
    $('#nuevoReferido_form').prop("disabled",false);

    $("#medio_entrega_div").show();
    $('#medio_entrega_form').prop("disabled",false);

    // if ($("#cellPhone").val()!='') {
    //   $('#telefonoset_ownCellPhone').show();
    // }
    // else if ($("#workCellPhone").val()!='') {
    //   $('#telefonoset_workCellPhone').show();
    // }
   newAddress($("#medio_entrega_form").val());
  }
}
function codificacionCelPer(telofic)
{
  if(telofic!='0')
  {


    if ($("#workCellPhone").val()!='') {
      $('#telefonoset_workCellPhone').show();
    }

    $('#codificacion_celtrab').hide();

    // $('#codificacion_telofic_form').hide();
    // $('#codificacion_celper_form').hide();
    $('#codificacion_celtrab_form').hide();

    $('#codificacion_celtrab_form').prop("disabled",true);

    $('#divNuevoNum').hide();
    $('#nuevoNum_form').prop("disabled",true);

    $("#newPhone").hide();
    $('#nuevo_numeroid').prop("disabled",true);
    $('#newNumber').prop("disabled",true);
    $('#tipoNewNumber').prop("disabled",true);


    $('#nuevoReferidodiv').hide();
    $('#nuevoReferido_form').prop("disabled",true);

    $("#newReferred").hide();
    $('#ref_name').prop("disabled",true);
    $('#ref_cuentad').prop("disabled",true);
    $('#ref_cuentan').prop("disabled",true);
    $('#ref_rango').prop("disabled",true);

    $("#medio_entrega_div").hide();
    $('#medio_entrega_form').prop("disabled",true);

    $('#state').prop("disabled",true);
    $('#town').prop("disabled",true);
    $('#col').prop("disabled",true);
    $('#cp').prop("disabled",true);
    $('#calle').prop("disabled",true);
    $('#numero').prop("disabled",true);
    $('#email').prop("disabled",true);

  }
  else
  {

    // $('#codificacion_telofic_form').hide();
    // $('#codificacion_celper_form').hide();
    $('#codificacion_celtrab_form').hide();

    // $('#codificacion_telofic').hide();
    // $('#codificacion_celper').hide();
    $('#codificacion_celtrab').hide();

    // $('#codificacion_telofic_form').prop("disabled",true);
    // $('#codificacion_celper_form').prop("disabled",true);
    $('#codificacion_celtrab_form').prop("disabled",true);



    // $('#telefonoset_work').hide();
    // $('#telefonoset_ownCellPhone').show();
    $('#telefonoset_workCellPhone').hide();
    $('#divNuevoNum').show();
    $('#nuevoNum_form').prop("disabled",false);

    // $("#newPhone").show();
    // $('#nuevo_numeroid').prop("disabled",false);
    // $('#newNumber').prop("disabled",false);
    // $('#tipoNewNumber').prop("disabled",false);

    $('#nuevoReferidodiv').show();
    $('#nuevoReferido_form').prop("disabled",false);

    $("#medio_entrega_div").show();
    $('#medio_entrega_form').prop("disabled",false);

    // if ($("#workCellPhone").val()!='') {
    //   $('#telefonoset_workCellPhone').show();
    // }
   newAddress($("#medio_entrega_form").val());
  }
}

function codificacionCelTrab(telofic)
{
  if(telofic!='0')
  {
    $('#divNuevoNum').hide();
    $('#nuevoNum_form').prop("disabled",true);

    $("#newPhone").hide();
    $('#nuevo_numeroid').prop("disabled",true);
    $('#newNumber').prop("disabled",true);
    $('#tipoNewNumber').prop("disabled",true);


    $('#nuevoReferidodiv').hide();
    $('#nuevoReferido_form').prop("disabled",true);

    $("#newReferred").hide();
    $('#ref_name').prop("disabled",true);
    $('#ref_cuentad').prop("disabled",true);
    $('#ref_cuentan').prop("disabled",true);
    $('#ref_rango').prop("disabled",true);


    $("#medio_entrega_div").hide();
    $('#medio_entrega_form').prop("disabled",true);

    $('#state').prop("disabled",true);
    $('#town').prop("disabled",true);
    $('#col').prop("disabled",true);
    $('#cp').prop("disabled",true);
    $('#calle').prop("disabled",true);
    $('#numero').prop("disabled",true);
    $('#email').prop("disabled",true);

  }
  else
  {
    $('#divNuevoNum').show();
    $('#nuevoNum_form').prop("disabled",false);

    $('#nuevoReferidodiv').show();
    $('#nuevoReferido_form').prop("disabled",false);

    $("#medio_entrega_div").show();
    $('#medio_entrega_form').prop("disabled",false);

    // $("#newPhone").show();
    // $('#nuevo_numeroid').prop("disabled",false);
    // $('#newNumber').prop("disabled",false);
    // $('#tipoNewNumber').prop("disabled",false);
    newAddress($("#medio_entrega_form").val());
  }
}

function codificacion_nuevonum(telofic)
{
  if(telofic!='0')
  {
    // $('#divNuevoNum').hide();
    // $('#nuevoNum_form').prop("disabled",true);

    // $("#newPhone").hide();
    // $('#nuevo_numeroid').prop("disabled",true);
    // $('#newNumber').prop("disabled",true);
    // $('#tipoNewNumber').prop("disabled",true);


    $('#nuevoReferidodiv').hide();
    $('#nuevoReferido_form').prop("disabled",true);

    $("#newReferred").hide();
    $('#ref_name').prop("disabled",true);
    $('#ref_cuentad').prop("disabled",true);
    $('#ref_cuentan').prop("disabled",true);
    $('#ref_rango').prop("disabled",true);


    $("#medio_entrega_div").hide();
    $('#medio_entrega_form').prop("disabled",true);

    $('#state').prop("disabled",true);
    $('#town').prop("disabled",true);
    $('#col').prop("disabled",true);
    $('#cp').prop("disabled",true);
    $('#calle').prop("disabled",true);
    $('#numero').prop("disabled",true);
    $('#email').prop("disabled",true);

  }
  else
  {
    // $('#divNuevoNum').show();
    // $('#nuevoNum_form').prop("disabled",false);

    $('#nuevoReferidodiv').show();
    $('#nuevoReferido_form').prop("disabled",false);

    $("#medio_entrega_div").show();
    $('#medio_entrega_form').prop("disabled",false);

    // $("#newPhone").show();
    // $('#nuevo_numeroid').prop("disabled",false);
    // $('#newNumber').prop("disabled",false);
    // $('#tipoNewNumber').prop("disabled",false);
    newAddress($("#medio_entrega_form").val());
  }
}

function valtc()
{
  $("#val_telcasa").val("1");
  $("#codificacion_telcasa").show();
  $("#codificacion_telcasa_form").show();
  $('#codificacion_telcasa_form').prop("disabled",false);
}
function valto()
{
  $("#val_oficina").val("1");
  $("#codificacion_telofic").show();
  $("#codificacion_telofic_form").show();
  $('#codificacion_telofic_form').prop("disabled",false);
}
function valcp()
{
  $("#val_celpersonal").val("1");
  $("#codificacion_celper").show();
  $("#codificacion_celper_form").show();
  $('#codificacion_celper_form').prop("disabled",false);
}
function valct()
{
  $("#val_celtrabajo").val("1");
  $("#codificacion_celtrab").show();
  $("#codificacion_celtrab_form").show();
  $('#codificacion_celtrab_form').prop("disabled",false);
}
function valnt()
{
  $("#val_nuevonum").val("1");
  $("#codificacion_nuevonumdiv").show();
  $('#codificacion_nuevonumdiv_form').prop("disabled",false);
}
//76553815
function newPhone(phone)
{
  if(phone=='Si')
  {
    $("#newPhone").show();
    $('#nuevo_numeroid').prop("disabled",false);
    $('#newNumber').prop("disabled",false);
    $('#tipoNewNumber').prop("disabled",false);
  }
  else
  {
    $("#newPhone").hide();
    $('#nuevo_numeroid').prop("disabled",true);
    $('#newNumber').prop("disabled",true);
    $('#tipoNewNumber').prop("disabled",true);
  }
}
function newReferred(referred)
{
  if(referred=='Si')
  {
    $("#newReferred").show();
    $('#ref_name').prop("disabled",false);
    $('#ref_cuentad').prop("disabled",false);
    $('#ref_cuentan').prop("disabled",false);
    $('#ref_rango').prop("disabled",false);
  }
  else
  {
    $("#newReferred").hide();
    $('#ref_name').prop("disabled",true);
    $('#ref_cuentad').prop("disabled",true);
    $('#ref_cuentan').prop("disabled",true);
    $('#ref_rango').prop("disabled",true);
  }
}
function newAddress(address)
{
  switch (address) {
    case 'Correo Electronico':
      $("#newAddress").hide();

      $("#newEmail").show();
      $('#state').prop("disabled",true);
      $('#town').prop("disabled",true);
      $('#col').prop("disabled",true);
      $('#cp').prop("disabled",true);
      $('#calle').prop("disabled",true);
      $('#numero').prop("disabled",true);

      $('#email').prop("disabled",false);
    break;
    case 'Informacion Impresa':
      $("#newAddress").show();

      $("#newEmail").hide();
      $('#state').prop("disabled",false);
      $('#town').prop("disabled",false);
      $('#col').prop("disabled",false);
      $('#cp').prop("disabled",false);
      $('#calle').prop("disabled",false);
      $('#numero').prop("disabled",false);

      $('#email').prop("disabled",true);
    break;
    default:
    $("#newAddress").hide();
    $("#newEmail").hide();

    $('#state').prop("disabled",false);
    $('#town').prop("disabled",false);
    $('#col').prop("disabled",false);
    $('#cp').prop("disabled",false);
    $('#calle').prop("disabled",false);
    $('#numero').prop("disabled",false);
    $('#email').prop("disabled",false);

    break;

  }


}

$("#telefonoset_home").click(function(event) {
  console.log('ok');
});

$("#telefonoset_work").click(function(event) {
  console.log('ok');
});

$("#telefonoset_ownCellPhone").click(function(event) {
  console.log('ok');
});

$("#telefonoset_workCellPhone").click(function(event) {
  console.log('ok');
});

$("#telefonoset_new").click(function(event) {
  console.log('ok');
});

</script>
@stop
y
