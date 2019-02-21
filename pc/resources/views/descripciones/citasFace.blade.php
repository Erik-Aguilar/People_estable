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
    <h2>Reporte de citas y entrevistas Facebook </h2>
      </div>
    </div>
    <div class="cuerpo">
      <div class="texto">
        Reporte de citas y entrevistas Facebook <br/>
        El siguiente reporte muestra a las citas programadas de los empleados.<br/>
        Si se desea generar el reporte es indispensable que el usuario seleccione un rango de fechas.  <br/>
        --La fecha de inicio debe ser menor a la fecha fin.  <br/>
        --La fecha fin no debe ser mayor a la fecha inicio.  <br/>
        Una vez seleccionado el rango de fechas de forma correcta, presione el botón enviar.  <br/> 
        Con lo cual se mostraran los siguientes datos. <br/>
        #: Muestra un número consecutivo de los datos mostrados. <br/>
        Nombre: Muestra el nombre del empleado al que están programadas la citas. <br/>
        Fecha: Muestra la fecha del sistema y fechas futuras en las cuales las citas se encuentran programadas. Este campo se divide en dos partes más. <br/>
        ->Citas: Muestra el total de  citas programadas para esa fecha. <br/>
        ->Entrevista: Muestra el total de entrevistas realizadas en el día. <br/>

      </div>
    </div>
</div>
</div>
@stop
