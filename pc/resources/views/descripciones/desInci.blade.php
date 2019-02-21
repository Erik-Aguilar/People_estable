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
->Reporte general de incidencia
Si se desea generar el reporte es indispensable que el usuario seleccione un rango de fechas. 
--La fecha de inicio debe ser menor a la fecha fin. 
--La fecha fin no debe ser mayor a la fecha inicio. 
Una vez seleccionado el rango de fechas de forma correcta, de clic sobre el botón enviar. 
A continuación se genera el reporte de incidencias, se mostraran los siguientes campos. <br/>
--#: Numero consecutivo para formar el listado de los operadores activos.  <br/>
--Nombre Operador: Nombre del operador el cual está activo en la campaña.  <br/>
--Supervisor: Nombre del supervisor. <br/>
--De: Muestra la fecha inicio de la cual se pidió el periodo, o la fecha de activación del usuario dentro del rango de fechas. <br/>
--Al: Muestra la fecha fin de la cual se pidió el periodo, o la fecha de activación del usuario dentro del rango de fechas.  <br/>
--Días justificados: Muestra el total de los días que fueron justificados por el operador, dentro del rango de fechas solicitado. <br/>
--Total: muestra el total de justificaciones del periodo solicitado. <br/>

      </div>
    </div>
</div>
</div>
@stop
