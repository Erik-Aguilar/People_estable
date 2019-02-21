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
    <h2>Módulo de edición</h2>
      </div>
    </div>
    <div class="cuerpo">
      <div class="texto">
       Módulo de edición  <br/>
->Edición <br/>
Si se desea generar el reporte es indispensable que el usuario seleccione un rango de fechas.  <br/>
--La fecha de inicio debe ser menor a la fecha fin.  <br/>
--La fecha fin no debe ser mayor a la fecha inicio.  <br/>
Una vez seleccionado el rango de fechas de forma correcta, presione el botón enviar.  <br/>
->Ventas Inbursa  <br/>
Dependiendo el rango de fechas seleccionado es el número de registros que este generara; este reporte mostrara los siguientes datos: <br/>
<-Teléfono (seleccionable): Sobre todos aquellos números que fueron ventas. <br/>
 <-Fecha (no seleccionable): fecha en la que se realizó la venta. <br/>
<-Estatus (no seleccionable): Estado de la venta.  <br/>
Se lo que se desea es visualizar y descargar los audios generados por algún número de teléfono es especial, debe dar clic sobre el número que se desea.  <br/>
->Descarga de audios <br/>
A hora usted podrá visualizar, todos los audios con referencia al número de teléfono seleccionado, el reporte muestra.  <br/>
<-fecha: De la cual se registró el audio.  <br/>
<-Hora: La hora en la cual se registró el audio.  <br/>
<-Escuchar: Reproductor de audio, con solo 2 botones, uno para escuchar y el otro para pausarlo.  <br/>
<-Descargar: Botón para descargar el audio. <br/>
Si se desea cargar el archivo ya editado hay un botón adicional “seleccionar archivo”, con el cual se puede seleccionar un archivo de las carpetas y cargarlo a la lista, para confirmar el envio basta con dar clic en el botón de enviar.  <br/> 
      </div>
    </div>
</div>
</div>
@stop
