@extends('layout.demos.reporte')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
          <h3 class="panel-title">Estado del Agente  | nombre_completo</h3>
      </div>
      <div class="panel-body">

        <div class="form-group">
          {{ Form::label('Telefono','',array('class'=>"col-sm-2 control-label")) }}
          <div class="col-sm-10">
            {{ Form::text('telefono',NULL,array('class'=>"form-control", 'placeholder'=>"",'onChange'=>'validacion(this.value)','id'=>'telefono','maxlength'=>'10')) }}
          </div>
        </div>

        <div class="form-group">
            {{ Form::label('Estatus','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
                {{ Form::select('estatus', [
                'Contacto' => 'Contacto',
                'Nocontacto' => 'No contacto'],
            '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'LlenarSelect()']  ) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Motivo','',array('class'=>"col-sm-2 control-label")) }}
            <div class="col-sm-10">
                {{ Form::select('motivo', [    ],'', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'id'=>'motivo','onchange'=>'motivoval()']  ) }}
            </div>
        </div>

          <div id='contenido' style='display: ;'>

            <div class="form-group">
                {{ Form::label('Paterno','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('paterno','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'paterno')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_paterno" style='display: none;'> Introduzca apellido paterno "sin espacio en blanco al iniciar ni al terminar"</span>
            </div>

            <div class="form-group">
                {{ Form::label('Materno','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('materno','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'materno')) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('Nombre','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('nombre','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'nombre')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_nombre" style='display: none;'> Introduzca el nombre "sin espacio en blanco al iniciar ni al terminar"</span>
            </div>

            <div class="form-group">
                {{ Form::label('Fecha del titular','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::date('fechaNacimiento','',array('class'=>"form-control", 'placeholder'=>"********",'id'=>'fechaNacimiento')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_fechaNacimiento" style='display: none;'> Fecha de nacimiento es requerida"</span>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_fechaNacimiento2" style='display: none;'> La edad tiene que ser mayor a 18 y menor a 65"</span>
            </div>

            <div class="form-group">
                {{ Form::label('Sexo','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::select('sexo', [
                    'M' => 'Masculino',
                    'F' => 'Femenino'],
                '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'sexo']  ) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_sexo" style='display: none;'>Debe seleccionar una opción en el campo Sexo"</span>
            </div>

            <div class="form-group">
                {{ Form::label('Nombre de    persona','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('nombreAutoriza','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'autoriza')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_autoriza" style='display: none;'>Introduzca nombre de la persona que autoriza el seguro "sin espacio en blanco al inciar ni al terminar"</span>
            </div>

            <div class="form-group">
                {{ Form::label('Parentesco','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::select('parentesco', [
                    'TITULAR' => 'TITULAR',
                    'ABUELA' => 'ABUELA',
                    'ABUELO'=> 'ABUELO',
                    'CUÑADA'=>'CUÑADA',
                    'CUÑADO'=>'CUÑADO',
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
                    'NINGUNO'=>'NINGUNO'],
                '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'parentesco']  ) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_parentesco" style='display: none;'>Introduzca nombre de la persona que autoriza el seguro "sin espacio en blanco al inciar ni al terminar"</span>
            </div>

            <div class="form-group">
                {{ Form::label('Correo Electrónico','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::email('email','',array('class'=>"form-control",'id'=>'correo')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_correo" style='display: none;'>Introduzca su correo electronico</span>
            </div>

            <div class="form-group">
                {{ Form::label('Fechal movimiento','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::date('fechaMovimiento',date('Y-m-d'),array('class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly','id'=>'fechaMov')) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('Dirección','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('direccion','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'direccion')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_direccion" style='display: none;'>La direccion es requerida</span>
            </div>

            <div class="form-group">
                {{ Form::label('Número Exterior','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('num_ext','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'numExt')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_numExt" style='display: none;'>El numero exterior es requerido</span>
            </div>

            <div class="form-group">
                {{ Form::label('Vialidad','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::select('vialidad', [
                    'AND' => 'Andador',
                    'AUT' => 'Autopista',
                    'AV'=> 'Avenida',
                    'BJD'=>'Bajada',
                    'BLV'=>'Boulrvard',
                    'CALZ'=>'Calzada',
                    'CALLE'=>'Calle',
                    'CJON'=>'Callejon',
                    'CAM'=>'Camino',
                    'CARR'=>'Carretera',
                    'CDA'=>'Cerrada',
                    'CTO'=>'Circuito',
                    'CVLN'=>'Circunvalacion',
                    'CRO'=>'Crucero',
                    'CUCH'=>'Cuchilla',
                    'DIAG'=>'Diagonal',
                    'EJE'=>'Eje',
                    'GTA'=>'Glorieta',
                    'JDN'=>'Jardin',
                    'LIB'=>'Libramiento',
                    'PRJ'=>'Paraje',
                    'PARQ'=>'Parque',
                    'PSJ'=>'Pasaje',
                    'PSO'=>'Paseo',
                    'PERIF'=>'Periferico',
                    'PZA'=>'Plaza',
                    'PRIV'=>'Privada',
                    'PROL'=>'Prolongacion',
                    'RML'=>'Ramal',
                    'RET'=>'Retorno',
                    'RCDA'=>'Rinconada',
                    'VDA'=>'Vereda',
                    'VIA'=>'VIA',
                    'VDTO'=>'Viaducto'],
                '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'vialidad']  ) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_vialidad" style='display: none;'>Seleccione una opcion en el campo Vialidad</span>
            </div>

            <div class="form-group">
                {{ Form::label('Vivienda','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::select('vivienda', [
                    'CASA' => 'Casa',
                    'COND' => 'Condominio',
                    'DEPTO'=> 'Departamento',
                    'DPX'=>'Duplex',
                    'ED'=>'Edificio',
                    'ENT'=>'Entrada',
                    'SUITE'=>'Suite',
                    'TORRE'=>'Torre'],
                '', [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'vivienda']  ) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_vivienda" style='display: none;'>Seleccione una opcion en el campo Vivienda</span>
            </div>

            <div class="form-group">
                {{ Form::label('Número interior','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('numint','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'nunInt')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_nunInt" style='display: none;'>El numero interior es requerido</span>
            </div>

            <div class="form-group">
                {{ Form::label('Piso','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('piso','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'piso')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_piso" style='display: none;'>El numero de piso es requerido</span>
            </div>

            <div class="form-group">
                {{ Form::label('Asentamiento','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::select('asentamiento', [
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
                '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'asentamiento']  ) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_asentamiento" style='display: none;'>Seleccione una opción en el campo Asentamiento</span>
            </div>

            <div class="form-group">
                {{ Form::label('Estado','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                     {{Form::select('state',['sajkgfsa'=>'safjh'],'',['id'=>'state','class'=>'form-control Fase2','placeholder'=>'Selecciona un estado'])}}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_state" style='display: none;'>Seleccione una opción en el campo Estado</span>
            </div>

            <div class="form-group">
                {{ Form::label('Delegacion/Municipio','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                     {{Form::select('town',[],'',['id'=>'town','class'=>'form-control Fase2','placeholder'=>'Selecciona una delegacion o municipio'])}}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_town" style='display: none;'>Seleccione una opción en el campo Delegacion/municipio</span>
            </div>
            <div class="form-group">
                {{ Form::label('Colonia','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                     {{Form::select('col',[],'',['id'=>'col','class'=>'form-control Fase2','placeholder'=>'Selecciona una colonia'])}}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_col" style='display: none;'>Seleccione una opción en el campo Colonia</span>
            </div>

            <div class="form-group">
                {{ Form::label('Codigo Postal','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                     {{Form::select('cp',[],'',['id'=>'cp','class'=>'form-control Fase2','placeholder'=>'Selecciona una colonia'])}}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_cp" style='display: none;'>Seleccione una opción en el campo Codigo Postal</span>
            </div>

            <!-- <div class="form-group">
                <div class="col-sm-10" style='text-align: center;'>
                {{ Form::label('Entré calles','',array('class'=>"control-label")) }}
                </div>
            </div> -->

            <div class="form-group">
                {{ Form::label('Calle1','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('calle_1','No proporciono',array('class'=>"form-control", 'placeholder'=>"",'id'=>'calle_1')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_calle_1" style='display: none;'>Es requerido el llenado de este campo </span>
            </div>

            <div class="form-group">
                {{ Form::label('Calle 2','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('calle_2','No proporciono',array('class'=>"form-control", 'placeholder'=>"",'id'=>'calle_2')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_calle_2" style='display: none;'>Es requerido el llenado de este campo </span>
            </div>

            <!-- <div class="form-group">
                <div class="col-sm-10" style='text-align: center;'>
                {{ Form::label('Referencias Principales del Domicilio Asegurado','',array('class'=>"control-label")) }}
                </div>
            </div> -->

            <div class="form-group">
                {{ Form::label('Referencia 1','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">

                    {{ Form::text('ref_1','No proporciono',array('class'=>"form-control", 'placeholder'=>"",'id'=>'ref_1')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_ref_1" style='display: none;'>Es requerido el llenado de este campo </span>
            </div>







      <!--Parte Nueva-->

            <div class="form-group">
              {{ Form::label('Telefonos','',array('class'=>"col-sm-2 control-label")) }}
              <div class="col-sm-10">
              <!-- <select id="myList" onchange="myFunction()">
                <option></option>
                <option value="1">Telcel</option>
                <option value="2">Iusacel</option>
                <option value="3">Movistar</option>
                <option value="4">Unefon</option>
                <option value="5">Otro</option>
              </select> -->

              {{ Form::select('Telefonos', [
              '1' => 'Telcel',
              '2' => 'Iusacel',
              '3' => 'Movistar',
              '4' => 'Unefon',
              '5' => 'Otro'],
          '', [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'myList','onchange'=>'myFunction()']  ) }}
            </div>
            </div>
            <div class="form-group">
                  {{ Form::label('Compañia','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('demo','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'demo')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_ref_2" style='display: none;'>Es requerido el llenado de este campo </span>
            </div>

<!-- FIN PARTE NUEVA -->





            <div class="form-group">
                {{ Form::label('Referencia 2','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('ref_2','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'ref_2','maxlength'=>'4')) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_ref_2" style='display: none;'>Es requerido el llenado de este campo </span>
            </div>

            <div class="form-group" >
                {{ Form::label('RVT','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('rvtname','Nombre Agente',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'aceptaventa')) }}
                </div>
            </div>
            <div class="form-group" style='display:none;'>
                <div class="col-sm-10">
                    {{ Form::text('rvt','usuario',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'aceptaventa')) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('Turno','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::select('turno', [
                    'M' => 'Matutino',
                    'V' => 'Vespertino'],
                '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'turno']  ) }}
                </div>
                <span  class="errorcol-sm-8 col-md-offset-2" id="error_turno" style='display: none;'> Seleccione una opción en el campo Turno</span>
            </div>

            <div class="form-group">
                {{ Form::label('Hora de inicio venta','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::time('hora_ini',null,array('class'=>"form-control", 'placeholder'=>"")) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('Hora de fin venta','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::time('hora_fin',null,array('class'=>"form-control", 'placeholder'=>"")) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('# de pisos','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::text('num_pisos',null,array('class'=>"form-control", 'placeholder'=>"",'title'=>'La planta baja cuenta como Piso 1','id'=>'pisos')) }}
                </div>
                <span class="error" id="error_pisos" style='display: none;'> El numero de pisos es requerido</span>
            </div>

            <div class="form-group">
                {{ Form::label('Techo de vivienda','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::select('cubierta', [
                    '1' => 'Cubierta Pesada',
                    '2' => 'Cubierta ligera sin diseño',
                    '3'=> 'Cubierta ligera con diseño generico',
                    '4'=>'cubierta ligera con diseño especifico'],
                null, ['class'=>"form-control", 'placeholder'=>"",'id'=>'cubierta']  ) }}
                </div>
                <span class="error" id="error_cubierta" style='display: none;'> Seleccione una opción en el campo Material del Techo</span>
            </div>

            <div class="form-group">
                {{ Form::label('Cuerpo de agua','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::select('tipofuente', [
                    'MAR' => 'Mar',
                    'LG' => 'Lago',
                    'LGA'=> 'Laguna',
                    'RIO'=>'Rio',
                    'NGN'=>'Ninguno'],
                null, ['class'=>"form-control", 'placeholder'=>"",'id'=>'tipofuente']  ) }}
                </div>
                <span class="error" id="error_tipofuente" style='display: none;'> Seleccione una opción en el campo Cuerpo de Agua</span>
            </div>

            <div class="form-group">
                {{ Form::label('Distancia al cuerpo del agua','',array('class'=>"col-sm-2 control-label")) }}
                <div class="col-sm-10">
                    {{ Form::select('linea_mar', [
                    'SI' => 'Si',
                    'NO' => 'No'],
                null, ['class'=>"form-control", 'placeholder'=>"",'id'=>'linea_mar']  ) }}
                </div>
                <span class="error" id="error_linea_mar" style='display: none;'> Seleccione una opción en el campo Distancia del Cuerpo de Agua</span>
            </div>



            </div>



            <div class="form-group">
                <div class="col-sm-offset-10 col-sm-1">
                    {{ Form::submit('Enviar',['class'=>"btn btn-default","onClick"=>'return valida()','id'=>'submit']) }}
                </div>
            </div>


      </div>
      </div>
    </div>
  </div>
</div>
<script>
function myFunction() {
    var mylist = document.getElementById("myList").value;
    // document.getElementById("demo").value = mylist.options[mylist.selectedIndex].value;
    // alert(mylist);
    if (mylist == 1) {
      // alert("Telcel");
      document.getElementById("demo").value = "Telcel";
      document.getElementById("demo").readOnly = true;
    }
    else if (mylist == 2) {
      // alert("Iusacel");
      document.getElementById("demo").value = "Iusacel";
      document.getElementById("demo").readOnly = true;
    }
    else if (mylist == 3) {
      // alert("Movistar");
      document.getElementById("demo").value = "Movistar";
      document.getElementById("demo").readOnly = true;
    }
    else if (mylist == 4) {
      // alert("Unefon");
      document.getElementById("demo").value = "Unefon";
      document.getElementById("demo").readOnly = true;
    }
    else if (mylist == 5) {
      document.getElementById("demo").value = "";
      document.getElementById("demo").readOnly = false;
    }

}
</script>


@stop
