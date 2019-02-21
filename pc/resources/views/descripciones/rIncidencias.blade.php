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
    <h2>Reporte de incidencias</h2>
      </div>
    </div>
    <div class="cuerpo">
      <div class="texto">
        Reporte de incidencias <br/>
->Reporte de incidencias<br/>
Si se desea generar el reporte es indispensable que el usuario ingrese el número de empleado, este datos es obligatorio.  <br/>
Una vez seleccionado ingresado el número de empleado correcto, de clic sobre el botón enviar.  <br/>
->Incidencias <br/>
La información del reporte será mostrada en base al número de empleado ingresado, este reporte mostrara los siguientes datos: <br/>
-Número de empleado (No modificable): Número de empleado anteriormente insertado. <br/>
-Nombre (No modificable): Nombre del empleado al cual corresponde el número de empleado.  <br/>
-Motivo (Modificable, Obligatorio): Razón por la cual se levanta la incidencia. <br/>
-Fecha inicio (Modificable, Obligatorio): Día en la cual se realizó la incidencia. <br/>
-Fecha fin (Modificable, Obligatorio): Día en la cual concluye la incidencia. <br/>
-Observaciones (Modificables, No obligatorias): Campo para ingresar datos complementarios que ayudaran a explicar la incidencia. <br/>
-Comprobante (no seleccionable): Documento, el cual comprueba el por qué la incidencia, como comprobar falta por medio de receta médica.<br/>
Una vez concluido el reporte, de clic sobre el botón enviar para ingresar la información.   <br/>

      </div>
    </div>
</div>
</div>
@stop
