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
    <h2>Reporte de calidad supervisor</h2>
      </div>
    </div>
    <div class="cuerpo">
      <div class="texto">
      Reporte de calidad supervisor<br/>
El siguiente reporte muestra el reporte de calidad, solamente de los supervisores.<br/>
Si se desea generar el reporte es indispensable que el usuario seleccione un rango de fechas.  <br/>
--La fecha de inicio debe ser menor a la fecha fin.  <br/>
--La fecha fin no debe ser mayor a la fecha inicio.  <br/>
Una vez seleccionado el rango de fechas de forma correcta, presione el botón enviar.  <br/>
Reporte de calidad por supervisor<br/>
El reporte mostrara los siguientes datos: <br/>
#: Numero consecutivo el cual se en numera a los supervisores activos. <br/>
Supervisor: Nombre  del supervisor activo. <br/>
Fecha: Muestra la fecha o las fechas en base al rango de fechas seleccionado. <br/>
->Calificación: muestra la calificación obtenida por fecha. <br/>
      </div>
    </div>
</div>
</div>
@stop
