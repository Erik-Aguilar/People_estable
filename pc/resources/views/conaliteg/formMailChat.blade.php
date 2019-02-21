@extends($layout)
@section('content')

<div class="container-fluid">
  <div class="row">
  <div class="col-md-8 col-md-offset-2">

    {{ Form::open(['action' => 'ConalitegController@SaveAux',
                    'method' => 'post',
                    'class'=>"form-horizontal",
                    'accept-charset'=>"UTF-8",
                    'id'=>'myform',
                    'enctype'=>"multipart/form-data"
                ]) }}

  <fieldset>
    <legend>
      <h3>Encuesta Chat / Email</h3>
  </legend>
    <div class="form-group">

    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Nombre *</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="nombre" name="nombre" value="" required="" {{ ($descanso) ? 'disabled=""' : '' }}  pattern="[a-zA-Z áéíóúñÁÉÍÓÚÑ]*" >
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Apellido paterno *</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="paterno" name="paterno" value="" required="" {{ ($descanso) ? 'disabled=""' : '' }}  pattern="[a-zA-Z áéíóúñÁÉÍÓÚÑ]*" >
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Apellido materno *</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="materno" name="materno" value="" required="" {{ ($descanso) ? 'disabled=""' : '' }}  pattern="[a-zA-Z áéíóúñÁÉÍÓÚÑ]*" >
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Teléfono local</label>
      <div class="col-lg-8">
        <input type="tel" class="form-control" id="tel_local" name="tel_local" value=""  {{ ($descanso) ? 'disabled=""' : '' }}  pattern="[0-9]{10}">
      </div>
    </div>
    <!-- <div class="form-group">
      <label for="" class="col-lg-2 control-label">Clave lada</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="lada" name="lada" value=""  {{ ($descanso) ? 'disabled=""' : '' }}  >
      </div>
    </div> -->
    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Sexo *</label>
      <div class="col-lg-8">
        <select class="form-control" name="sexo" id="sexo" required="" {{ ($descanso) ? 'disabled=""' : '' }}  >
          <option value=""></option>
          <option value="Femenino">Femenino</option>
          <option value="Masculino">Masculino</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Estado *</label>
      <div class="col-lg-8">
           {{Form::select('estado',$states,'',['required'=>'required','id'=>'state','class'=>'form-control','placeholder'=>'Selecciona un estado','required'=>'required' , ($descanso) ? 'disabled=""' : ''  ])}}
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Municipio *</label>
      <div class="col-lg-8">
           {{Form::select('municipio',[],'',['required'=>'required','id'=>'town','class'=>'form-control','placeholder'=>'Selecciona una delegacion o municipio','required'=>'required', ($descanso) ? 'disabled=""' : ''   ])}}
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Tipo de usuario *</label>
      <div class="col-lg-8">
        <select class="form-control" name="tipou" id="tipou" required="" {{ ($descanso) ? 'disabled=""' : '' }}  >
          <option value=""></option>
          <option value="DIRECTOR DE NIVEL">DIRECTOR DE NIVEL</option>
          <option value="DIRECTOR DE CENTRO DE TRABAJO">DIRECTOR DE CENTRO DE TRABAJO</option>
          <option value="PROFESOR">PROFESOR</option>
          <option value="ALUMNO">ALUMNO</option>
          <option value="PADRE DE FAMILIA">PADRE DE FAMILIA</option>

          <!-- <option value="DIRECTOR DE CENTRO DE TRABAJO">DIRECTOR DE CENTRO DE TRABAJO</option>
          <option value="DIRECTOR DE NIVEL">DIRECTOR DE NIVEL</option>
          <option value="INCIDENCIA">INCIDENCIA</option>
          <option value="MAESTRO">MAESTRO</option>
          <option value="OTRO">OTRO</option> -->
          <!-- <option value="OTROS / EMAIL">OTROS / EMAIL</option>
          <option value="PROFESOR">PROFESOR</option> -->
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Email</label>
      <div class="col-lg-8">
        <input type="email" class="form-control" id="email" name="email" value="" {{ ($descanso) ? 'disabled=""' : '' }}   >
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Categoría *</label>
      <div class="col-lg-8">
        <select class="form-control" name="categoria" id="categoria" required="" {{ ($descanso) ? 'disabled=""' : '' }}  >
          <option value=""></option>
          <!-- <option value="INCIDENCIA">INCIDENCIA</option> -->
          <option value="SOPORTE">SOPORTE</option>
          <option value="INFORMACIÓN">INFORMACIÓN</option>
          <option value="SUGERENCIA">SUGERENCIA</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Subcategoría *</label>
      <div class="col-lg-8">
        <select class="form-control" name="subcategoria" id="subcategoria" required="" {{ ($descanso) ? 'disabled=""' : '' }}  >
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Clave escuela</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="clave" name="clave" value="" {{ ($descanso) ? 'disabled=""' : '' }}  >
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Status *</label>
      <div class="col-lg-8">
        <select class="form-control" name="status" id="status" required="" {{ ($descanso) ? 'disabled=""' : '' }}  >
          <option value=""></option>
          <option value="INCIDENCIA">INCIDENCIA</option>
          <option value="LLAMADA DE PRUEBA">LLAMADA DE PRUEBA</option>
          <option value="PENDIENTE / SEGUIMIENTO">PENDIENTE / SEGUIMIENTO</option>
          <option value="RESUELTO">RESUELTO</option>
          <option value="SE CORTA LLAMADA">SE CORTA LLAMADA</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-lg-2 control-label">Medio *</label>
      <div class="col-lg-8">
        <select class="form-control" name="medio" id="medio" required="" {{ ($descanso) ? 'disabled=""' : '' }}  >
          <option value=""></option>
          <option value="EMAIL">EMAIL</option>
          <option value="CHAT">CHAT</option>
        </select>
      </div>
    </div>
    <!-- <div class="form-group">
      <label for="" class="col-lg-2 control-label">Escuela nombre</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="escuela_nombre" name="escuela_nombre" value="" {{ ($descanso) ? 'disabled=""' : '' }}  >
      </div>
    </div> -->
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Comentarios</label>
      <div class="col-lg-8">
        <textarea class="form-control" id="comentarios" name="comentarios"></textarea>
      </div>
    </div>
    <!-- <div class="form-group">
      <label for="" class="col-lg-2 control-label">Operador</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="operador" name="operador" value="{{$nombre}}" readonly="" >
      </div>
    </div> -->

    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="submit" class="btn btn-primary" {{ ($descanso) ? 'disabled=""' : '' }}  >Guardar</button>
      </div>
    </div>
  </fieldset>
{{ Form::close() }}

  </div>
  <!-- <div class="col-md-4">
    <br>
                <fieldset>
                  <legend>
                    <h3>Salescom</h3>
                </legend>
                  <br>
                </fieldset>
  </div> -->

</div>
</div>
@stop
@section('content2')
<script>

</script>
<script type="text/javascript">

$("#categoria").on("change", sub);
$("#getAjax").click(GetDataCall);
$("#myform").submit(validForm);
function sub() {
  var st = $("#categoria").val();
  if(st=='INCIDENCIA'){
      $("#subcategoria").html("<option value=''></option><option value='USUARIO CORTO COMUNICACIÓN'>USUARIO CORTO COMUNICACIÓN</option><option value='NO RESPONDE'>NO RESPONDE</option><option value='PROBLEMAS DE AUDIO'>PROBLEMAS DE AUDIO</option><option value='PROBLEMAS TÉCNICOS'>PROBLEMAS TÉCNICOS</option>");
  }
  else if (st=='SOPORTE') {
    $("#subcategoria").html("<option value=''></option><option value='ADMINISTRACIÓN DEL CENTRO DE TRABAJO'>ADMINISTRACIÓN DEL CENTRO DE TRABAJO</option>"+
    "<option value='ASIGNAR PROFESORES A MATERIA'>ASIGNAR PROFESORES A MATERIA</option>"+
    "<option value='ELIMINAR GRUPOS'>ELIMINAR GRUPOS</option>"+
    "<option value='MANEJO DE VENTANAS EN APLICATIVO'>MANEJO DE VENTANAS EN APLICATIVO</option>"+
    "<option value='MODIFICAR CONTRASEÑA'>MODIFICAR CONTRASEÑA</option>"+
    "<option value='RECUPERAR CONTRASEÑA'>RECUPERAR CONTRASEÑA</option>"+
    "<option value='REGISTRO DE PROFESORES'>REGISTRO DE PROFESORES</option>"+
    "<option value='SELECCIÓN DE LIBROS'>SELECCIÓN DE LIBROS</option>"+
    "<option value='TABLERO DIRECTOR CT'>TABLERO DIRECTOR CT</option>"+
    "<option value='TABLERO PROFESORES'>TABLERO PROFESORES</option>"+
    "<option value='DISTRIBUCIÓN DE MATRICULA'>DISTRIBUCIÓN DE MATRICULA</option>"+
    "<option value='CIERRE DE ESCUELA POR ERROR'>CIERRE DE ESCUELA POR ERROR</option>");
  }else if (st=='INFORMACIÓN') {
    $("#subcategoria").html("<option value=''></option><option value='DUDAS DE PERFIL'>DUDAS DE PERFIL</option>"+
    "<option value='LINK DE INGRESO A LA PÁGINA WEB'>LINK DE INGRESO A LA PÁGINA WEB</option>"+
    "<option value='CONTACTO'>CONTACTO</option>"+
    "<option value='DISPONIBILIDAD DEL SISTEMA'>DISPONIBILIDAD DEL SISTEMA</option>"+
    "<option value='VIGENCIA DEL EVENTO'>VIGENCIA DEL EVENTO</option>");
  }
  else if (st=='SUGERENCIA') {
    $("#subcategoria").html("<option value=''><option value='CONSULTA DE TUTORIALES'>CONSULTA DE TUTORIALES</option>"+
    "<option value='CONSULTA CATÁLOGO DE LIBROS EN LÍNEA'>CONSULTA CATÁLOGO DE LIBROS EN LÍNEA</option>");
  }
  else {
    $("#subcategoria").html("");
  }

  //$("#subcategoria").html("");
  //$("#subcategoria").html("");
}

function GetDataCall() {
  // alert("{{URL('/conaliteg/getDataCall')}}");
  $.get("{{URL('/conaliteg/getDataCall')}}", function (data) {
      //success data
      //console.log(data.name);
      $("#d1").val(data.number);
      //$("#d2").val(data.id1);
      $("#d3").val(data.id1);
      $("#d4").val(data.link1);

      $("#d5").val(data.op1);
      $("#d6").val(data.op2);
      $("#d7").val(data.id2);
      $("#d8").val(data.link2);
  })

}
function validForm() {

  var vd1 = $("#d1").val();
  //$("#d2").val(data.id1);
  var vd3 = $("#d3").val();
  var vd4 = $("#d4").val();

  var vd5 = $("#d5").val();
  var vd6 = $("#d6").val();
  var vd7 = $("#d7").val();
  var vd8 = $("#d8").val();

  if (vd1=='' && vd3=='' && vd4=='' && vd5=='' && vd6=='' && vd7=='' && vd8=='') {
    alert('Tienes que presionar el botón de datos');
    return false;
  }
}


</script>
@stop
