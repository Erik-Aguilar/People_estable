@extends('a.layout-master')
@section('content')

<style media="screen">
body {

/* Ubicación de la imagen */

background-image: url({{asset('/assets/img/home.jpg')}});

/* Para dejar la imagen de fondo centrada, vertical y

horizontalmente */

background-position: center center;

/* Para que la imagen de fondo no se repita */

background-repeat: no-repeat;

/* La imagen se fija en la ventana de visualización para que la altura de la imagen no supere a la del contenido */

background-attachment: fixed;

/* La imagen de fondo se reescala automáticamente con el cambio del ancho de ventana del navegador */

/*background-size: cover;*/

/* Se muestra un color de fondo mientras se está cargando la imagen

de fondo o si hay problemas para cargarla */

background-color: white;

}


</style>
@stop
