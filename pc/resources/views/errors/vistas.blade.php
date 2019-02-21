@extends('layout.demos.reporte')
@section('content')
<div class="container">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nombre Vista</th>
        <th>Link Vista</th>
        <th>Descripcion</th>
      </tr>
    </thead>
    <tbody>
      <tr><!--Edicion-->
        <td>descarga</td>
        <td><a href="{{ url('/') }}">Link</a></td>
        <td><a href="{{ url('/') }}">Descripcion</a></td>
      </tr>
      <tr>
        <td>fechaEdicion</td>
        <td><a href="{{ url('/') }}">Link</a></td>
        <td><a href="{{ url('/') }}">Descripcion</a></td>
      </tr>
      <tr>
        <td>listaAudios</td>
        <td><a href="{{ url('/') }}">Link</a></td>
        <td><a href="{{ url('/') }}">Descripcion</a></td>
      </tr>
    </tbody><!--FIN Edicion-->
    <tbody><!--Demos-->
      <tr>
        <td>periodo</td>
        <td><a href="{{ url('/') }}">Link</a></td>
        <td><a href="{{ url('/') }}">Descripcion</a></td>
      </tr>
      <tr><!--Edicion-->
        <td>fechaEdicion</td>
        <td><a href="{{ url('/') }}">Link</a></td>
        <td><a href="{{ url('/') }}">Descripcion</a></td>
      </tr>
      <tr><!--Edicion-->
        <td>listaAudios</td>
        <td><a href="{{ url('/') }}">Link</a></td>
        <td><a href="{{ url('/') }}">Descripcion</a></td>
      </tr>
    </tbody>
  </table>
</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
@stop
