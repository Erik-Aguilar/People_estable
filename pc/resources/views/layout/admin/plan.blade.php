<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PeopleConnect</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    </head>
    <body>
        <header>
            <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Administración</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                      <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes<span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/Administracion/root/asistencia') }}">Reporte asistencia</a></li>
                            <li><a href="{{ url('/capacitacionRoot') }}">Reporte de Capacitacion</a></li>
                            <li><a href="{{ url('/Administracion/ReporteRooot') }}">Reporte Reclutamiento</a></li>
                            <li><a href="{{ url('Administracion/ReportBaja') }}">Reporte bajas</a></li>
                            <li><a href="{{ url('/Administracion/operaciones/reporte') }}">Reporte general de operaciones</a></li>
                            <li><a href="{{ url('/Administracion/periodoIncidencia') }}">Reporte de Incidencias</a></li>
                            <li><a href="{{ url('/Administracion/fechaCitas') }}">Reporte Citas</a></li>
                            <li><a href="{{ url('/Administracion/root/perRefRep') }}">Referencias repetidas</a></li>
                            <li><a href="{{ url('/Administracion/root/perMarInbursa') }}">Reporte de marcación inbursa</a></li>
                            <li><a href="{{ url('/Administracion/root/perMonitoreoAC') }}">Reporte de calidad</a></li>
                            <li><a href="{{ url('/EdicionEdi') }}">Reporte de Edición por editor</a></li>
                            <li><a href="{{ url('/EdicionAva') }}">Reporte de Edición por avance</a></li>
                            <li><a href="{{ url('/reporteMarcacionEstado') }}">Reporte de Marcacion general</a></li>
                            <li><a href="{{ url('/reporteMarcacionContactacionDia') }}"> Reporte de contactacion por dia</a></li>
                            <li><a href="{{ url('/reporteMarcacionConversionDia') }}"> Reporte de conversion por dia </a></li>
                            <li><a href="{{ url('/reporteBlaster') }}"> Reporte Blaster </a></li>


                            <li><a href="/reporteMarcacionEstado">Marcacion General por estados Inbursa</a></li>
                            <li><a href="/reporteMarcacionContactacionDia">Marcacion contactacion por dia Inbursa</a></li>
                            <li><a href="/reporteMarcacionConversionDia">Marcacion conversion por dia Inbursa</a></li>
                            <li><a href="/reporteMarcacionEstadoMapfre">Marcacion General por estados Mapfre</a></li>
                            <li><a href="/reporteMarcacionContactacionDiaMapfre">Marcacion contactacion por dia Mapfre</a></li>
                            <li><a href="/reporteMarcacionConversionDiaMapfre">Marcacion conversion por dia Mapfre</a></li>
                            <li><a href="/ReporteVPHMapfre">Reporte de ventas Mapfre</a></li>
                          </ul>
                      </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('Administracion/admin') }}">Nuevo empleado</a></li>
                                <li><a href="{{ url('Administracion/admin/plantilla') }}">Plantilla</a></li>
                                <li><a href="{{ url('Administracion/admin/asistencia') }}">Reporte asistencia</a></li>
                                <!--<li><a href="/">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="/">Separated link</a></li>
                                <li class="divider"></li>
                                <li><a href="/">One more separated link</a></li>-->
                            </ul>
                        </li>
                        <li><a href="{{ url('salir') }}" class="btn btn-link">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        </header>
        <br>
        <br>
        <br>
        <br>
        <br>




            @yield('content')
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        @yield('content2')
    </body>
</html>
