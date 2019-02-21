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
        <!-- <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}" > -->
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
                    <a class="navbar-brand" href="#">Supervisor Inbursa</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('inbursa') }}">Reportes Inbursa</a></li>
                                <li><a href="{{ url('/InbursaVidatel/reportes') }}">Reportes Vidatel</a></li>
                                <li><a href="{{ url('/Inbursa_soluciones/reportes') }}">Reportes Soluciones</a></li>
                                <!--<li><a href="{{ url('prepago/supervisor') }}">Cambiar rango de fecha</a></li>-->
                                <li><a href="{{ url('/operaciones/reporte') }}">Reporte general de operaciones</a></li>
                                <li><a href="{{ url('prepago/supervisor/plantilla') }}">Plantilla</a></li>
                                <li><a href="{{ url('prepago/supervisor/Asistencia') }}">Pase de Asistencia</a></li>
                                <li><a href="{{ url('prepago/supervisor/AsistenciaDatos') }}">Asistencia</a></li>
                                <!--<li><a href="{{ url('prepago/supervisor/perRefRep') }}">Referencias repetidas</a></li>-->
                                <!-- <li><a href="{{ url('/reporteRV') }}">Reporte de ventas completo</a></li> -->

                                <!--<li><a href="{{ url('/subirVentas') }}">Subir ventas</a></li>
                                <li><a href="{{ url('/subirVentasRechazadas') }}">Subir ventas rechazadas</a></li>
                                <li><a href="{{ url('/ventasRechazadas') }}">Lista ventas a editar</a></li>
                                <li><a href="{{ url('/inicioDescargaVentasRechazadas') }}">Descargar ventas editadas</a></li>-->
                                <li><a href="{{ url('/EdicionAva') }}">Edicion por avance</a></li>
                                <li><a href="{{ url('/EdicionEsta') }}">Edicion por Estatus</a></li>
			                     <li><a href="{{ url('/EdicionEdi') }}">Edicion por editor</a></li>
                                <li><a href="{{ url('/asistenciaHistorico') }}">Reporte Historico Asistencias</a></li>
                                <!--<li><a href="/">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="/">Separated link</a></li>
                                <li class="divider"></li>
                                <li><a href="/">One more separated link</a></li>-->
                            </ul>
                        </li>
                        <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Calidad | Inbursa<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/calidad/inbursa') }}">Nuevo rango de fechas</a></li>
                                    <li><a href="{{ url('/calidad/inbursaVidatel') }}">Nuevo rango de fechas Vidatel</a></li>
                                    <li><a href="{{ url('/platillaAsistencia') }}">Reporte de asistencias</a></li>
                                    <li><a href="/inicioFormaCalidad">Auditar Audios</a></li>
                                    <!--<li><a href="{{ url('/calidad/inbursa/Validacion') }}">Validacion</a></li>
                                    <li><a href="{{ url('/admin/asistencia') }}">Reporte asistencia</a></li>
                                    <li><a href="/">Something else here</a></li>
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
        <!-- Scripts -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
@yield('content2')
    </body>
</html>
