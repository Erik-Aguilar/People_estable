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
    <h2>Reporte general de operación</h2>
      </div>
    </div>
    <div class="cuerpo">
      <div class="texto">
Reporte general de operación  <br/>
->Reporte general de operación <br/>
Si se desea generar el reporte es indispensable que el usuario seleccione un rango de fechas.  <br/>
--La fecha de inicio debe ser menor a la fecha fin.  <br/>
--La fecha fin no debe ser mayor a la fecha inicio.  <br/>
Una vez seleccionado el rango de fechas de forma correcta, de clic sobre el botón enviar.  <br/>
->Reportes coordinador por campaña <br/>
La información del reporte será mostrada en base al rango de fecha seleccionado, este reporte mostrara los siguientes datos: <br/>
-# (no seleccionable): Indicador del número de registros mostrados.<br/>
-Nombre de la campaña (seleccionable): Muestra al coordinador(es) de la campaña(s).  <br/>
--Agentes activos <br/>
-Matutino (no seleccionable): Número del personal activo en el turno matutino.  <br/>
-Vespertino (no seleccionable): Número del personal activo en el turno vespertino. <br/>
--Ventas <br/>
-Matutino (no seleccionable): Número de ventas realizadas durante el turno matutino. <br/>
-Vespertino (no seleccionable): Número de ventas realizadas durante el turno vespertino. <br/>
--VPH (Ventas Por Hora)<br/>
-Matutino (no seleccionable): Porcentaje de ventas realizadas por hora, en el turno matutino. <br/>
-Vespertino (no seleccionable): porcentaje de ventas realizadas por hora, en el turno vespertino.<br/>
Si lo que se desea es visualizar es un reporte sobre un solo coordinador, de clic sobre el nombre del coordinador.  <br/>
->Reporte supervisor <br/>
A hora se podrán visualizar los supervisores a cargo del coordinador seleccionado, con los siguientes datos: <br/>
-# (no seleccionable): Indicador del número de registros mostrados.<br/>
-Nombre de coordinador (seleccionable): muestra el nombre el coordinador.  <br/>
--Agentes activos <br/>
-Matutino (no seleccionable): Número del personal activo en el turno matutino.  <br/>
-Vespertino (no seleccionable): Número del personal activo en el turno vespertino. <br/>
--Ventas <br/>
-Matutino (no seleccionable): Número de ventas realizadas durante el turno matutino. <br/>
-Vespertino (no seleccionable): Número de ventas realizadas durante el turno vespertino. <br/>
--VPH (Ventas Por Hora)<br/>
-Matutino (no seleccionable): Porcentaje de ventas realizadas por hora, en el turno matutino. <br/>
-Vespertino (no seleccionable): porcentaje de ventas realizadas por hora, en el turno vespertino.<br/>
Si lo que se desea es visualizar es un reporte sobre un solo supervisores, de clic sobre el nombre del supervisor.   <br/>
->Reporte agente  <br/>
El siguiente reporte mostrara a los agentes a cargo del supervisor seleccionado, mostrando los siguientes datos: <br/>
-# (no seleccionable): Indicador del número de registros mostrados.<br/>
-Nombre del supervisor (el anteriormente seleccionado) : En el campo se muestran todos los agentes a cargo del supervisor. <br/>
-Turno (no seleccionable): Se muestra el turno agente. <br/>
-Ventas (no seleccionable): El total de ventas realizadas por dicho agente. <br/>
-VPH (no seleccionable): el porcentaje de ventas por hora realizadas por dicho agente. <br/>
      </div>
    </div>
</div>
</div>
@stop
