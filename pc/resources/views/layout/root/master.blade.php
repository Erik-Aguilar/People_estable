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
        <script src="{{asset('assets/css/rep.css')}}"></script>
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu<span class="caret"></span</a>
                    <ul class="dropdown-menu">
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Administracion<span class="caret"></span></a>
                          <ul class="dropdown-menu multi-level" role="menu">
                                <li><a href="{{ url('/Administracion/root') }}">Nuevo empleado</a></li>
                                <li><a href="{{ url('/Administracion/root/plantilla') }}">Plantilla</a></li>
                                <li><a href="{{ url('/Administracion/root/asistencia') }}">Reporte asistencia</a></li>
                                <li><a href="{{ url('/capacitacionRoot') }}">Reporte de Capacitacion</a></li>
                                <li><a href="{{ url('/Administracion/ReporteRooot') }}">Reporte Reclutamiento</a></li>
                                <li><a href="{{ url('/EdicionEdi') }}">Reporte de Edición por editor</a></li>
                                <li><a href="{{ url('/EdicionAva') }}">Reporte de Edición por avance</a></li>
                          </ul>
                        </li>
                    <li class="divider"></li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Citas Agendadas<span class="caret"></span></a>
                          <ul class="dropdown-menu multi-level" role="menu">
                            <li><a href="{{ url('citas') }}">Lista de citas</a></li>
                          </ul>
                        </li>

                    <li class="divider"></li>

                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Coordinador <span class="caret"></span></a>
                          <ul class="dropdown-menu multi-level" role="menu">
                            <li><a href="{{ url('/coordinador') }}">Pendiente de Alta</a></li>
                            <li><a href="{{ url('/coordinadortotal') }}">Listado</a></li>
                          </ul>
                        </li>

                    <li class="divider"></li>

                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes de Facebook<span class="caret"></span></a>
                          <ul class="dropdown-menu multi-level" role="menu">
                            <li><a href="{{ url('/reportesfacebook') }}">Ventas Hoy</a></li>
                            <li><a href="{{ url('/reportesfacebook/filtro') }}">Reporte por Filtro</a></li>
                          </ul>
                        </li>

                    <li class="divider"></li>

                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Inbursa<span class="caret"></span></a>
                          <ul class="dropdown-menu multi-level" role="menu">
                            <li><a href="{{ url('/inbursa') }}">Reportes</a></li>
                          </ul>
                        </li>

                    <li class="divider"></li>

                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Recepcion<span class="caret"></span></a>
                          <ul class="dropdown-menu multi-level" role="menu">
                              <li><a href="{{ url('/recepcion') }}">Pendiente de Alta</a></li>
                              <li><a href="{{ url('/recepciontotal') }}">Listado</a></li>
                          </ul>
                        </li>

                    <li class="divider"></li>

                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reclutamiento<span class="caret"></span></a>
                          <ul class="dropdown-menu multi-level" role="menu">
                              <li><a href="{{ url('rh/nuevo/candidato') }}">Nuevo Candidato</a></li>
                              <li><a href="{{ url('rh/candidatos') }}">Ver candidatos</a></li>
                              <li><a href="{{ url('rh/candidatosTotal') }}">listado de candidatos</a></li>
                              <li><a href="{{ url('rh/capacitacion') }}">Asistencia a capacitacion</a></li>
                              <li><a href="{{ url('rh/capacitacionMedio') }}">Capacitacion por medio de Reclutamiento</a></li>
                              <li><a href="{{ url('rh/capacitacionMedioActivo') }}">Capacitacion por Reclutador</a></li>
                          </ul>
                        </li>

                    </ul>
                </li>
                        <li>
                        <a href="{{ url('salir') }}" class="btn btn-link">
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




        <!-- Scripts
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

        <script src="{{asset('assets/js/rep.js')}}"></script>
        @yield('content2')

    </body>
</html>