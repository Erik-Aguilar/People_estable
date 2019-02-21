@extends('layout.vistas')
@section('content')
<div class="container">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Módulo</th>
        <th>Vista previa</th>
        <th>Descripción</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Modulo de ingresos</td>
        <td><a href="{{ url('/demosF/verIngresos') }}">Vista previa</a></td>
        <td></a></td>
      </tr>
      <tr>
        <td>Reporte de analista de calidad</td>
        <td><a href="{{ url('/periodoCalidadAnalC') }}">Vista previa</a></td>
        <td><a href="{{ url('/CalidadAnalC') }}">Descripción</a></td>
      </tr>
      <tr>
        <td>Reporte de calidad supervisor</td>
        <td><a href="{{ url('/periodoCalidadSup') }}">Vista previa</a></td>
        <td><a href="{{ url('/CalidadSup') }}">Descripción</a></td>
      </tr>
      <tr>
        <td>Reporte de citas y entrevistas facebook</td>
        <td><a href="{{ url('/periodo') }}">Vista previa</a></td>
        <td><a href="{{ url('/citasFace') }}">Descripción</a></td>
      </tr>
      <tr>
      <tr>
        <td>Modulo de rechazos</td>
        <td><a href="{{ url('/cRechazos') }}">Vista previa</a></td>
        <td><a href="{{ url('/calRechazos') }}">Descripción</a></td>
      </tr>
      <tr>
        <td>Reporte general de Incidencias</td>
        <td><a href="{{ url('/periodoInci') }}">Vista previa</a></td>
        <td><a href="{{ url('/desInci') }}">Descripción</a></td>
      </tr>
      <tr>
        <td>Módulo de incidencias</td>
        <td><a href="{{ url('/noEmpInci') }}">Vista previa</a></td>
        <td><a href="{{ url('/rIncidencias') }}">Descripción</a></td>
      </tr>
      <tr>
        <td>Asistencia telefonica</td>
        <td><a href="{{ url('/paseListaMovi') }}">Vista previa</a></td>
        <td><a href="{{ url('/listaTelefonica') }}">Descripción</a></td>
      </tr>
      <tr>
        <td>Reporte general de operación</td>
        <td><a href="{{ url('/periodo') }}">Vista previa</a></td>
        <td><a href="{{ url('/rGeneralEmp') }}">Descripción</a></td>
      </tr>
      <tr>
        <td>Módulo de edición</td>
        <td><a href="{{ url('/rangFechas') }}">Vista previa</a></td>
        <td><a href="{{ url('/mEdicion') }}">Descripción</a></td>
      </tr>
    </tbody>
  </table>
</div>
@stop
