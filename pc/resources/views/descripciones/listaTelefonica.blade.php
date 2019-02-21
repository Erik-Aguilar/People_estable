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
    <h2>Asistencia de telefónica</h2>
      </div>
    </div>
    <div class="cuerpo">
      <div class="texto">
        Asistencia de telefónica  <br/>
Si se desea realizar el pase de asistencia, se tendrán los siguientes campos, con la finalidad de que sea detallado.<br/>
--#: Numero consecutivo para formar el listado de los operadores activos.  <br/>
--Nombre Operador: Nombre del operador el cual está activo en la campaña.  <br/>
--Hora: Muestra la hora en la que se firmó el operador. <br/>
--Asistencia (Selección): Se podrá seleccionar las siguientes opciones<br/>
->Si<br/>
->No<br/>
--Motivo Falta (Selección): Se podrá seleccionar las siguientes opciones<br/>
->Enfermedad<br/>
->Personal<br/>
->No contesta<br/>
->Sin motivo<br/>
->Defunción<br/>
->Tramites<br/>
->Vacaciones<br/>
--Observaciones (Editable): Si se desea ingresar algún dato extra insértense en este campo.
Una vez terminado el pase de asistencia asegúrese de presionar clic sobre el botón enviar.  <br/>

      </div>
    </div>
</div>
</div>
@stop
