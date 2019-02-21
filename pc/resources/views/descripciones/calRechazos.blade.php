@extends('layout.vistas')


@section('content')
<style media="screen">
.encabezado{
  position: fixed;
  margin-left: 20%;
  width: 50%;
  height: 15%;
  border: 1px solid black;
  background: #FBFBF9
}
.cuerpo{
  position: fixed;
  margin-left: 20%;
  margin-top:7.1%; ;
  width: 50%;
  height: 100%;
  border: 1px solid black;
  overflow: scroll;
  background: #FBFBF9
}
.texto{
  padding: 10px;
}
.titulo{
  padding-top: 0px;
  padding-left: 10px;
}
body{
  background-color: #DEDEDE;
}
</style>
<div class="container">
    <div class="encabezado">
      <div class="titulo">
    <h2>Modulo de rechazos</h2>
      </div>
    </div>
    <div class="cuerpo">
      <div class="texto">
        Módulo de rechazos<br/>
En pantalla se pueden visualizar los datos requeridos para marcar un DN como rechazado. <br/>
DN (Obligatorio): Número el cual se desea rechazar. <br/>
Fecha Validación (Obligatorio): Fecha en la cual se esta dando de alta el DN como rechazado. <br/>
Campaña (Obligatorio): Espesifique la campaña a la cual pertenece el DN rechazado. <br/>
Nombre Del Analista De BO (Obligatorio): Muestra una lista de los analistas de back office activos, del cual se debe seleccionar uno. <br/>
Nombre Del Operador (Obligatorio): Muestra una lista de los operadores activos, del cual se debe seleccionar uno. <br/>
Nombre Del Validador (Obligatorio): Muestra una lista de los validadores activos, del cual se debe seleccionar uno. <br/>
Imputable A (Obligatorio): Muestra una lista de los puestos, de la cual se deberá seleccionar por el cual el DN fue rechazado. <br/>
¿Recuperación exitosa? (Obligatorio): Muestra una lista con dos posibles respuestas (si/no), en caso de que el DN puedo recuperarse del rechazo. <br/>
NIP Proporcionado Por Cliente (Obligatorio): se captura el NIP que el cliente proporciono sobre el DN. <br/>
Comentarios (Obligatorio): Ingresar una pequeña nota en la cual se explique el motivo por el cual se ha generado el Rechazo<br/>
 Si todos los datos fueron capturados correctamente, de clic sobre el botón enviar. <br/>

      </div>
    </div>
</div>
</div>
@stop
