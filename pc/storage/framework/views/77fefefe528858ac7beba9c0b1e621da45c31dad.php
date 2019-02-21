<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PeopleConnect</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="<?php echo e(asset('assets/css/welcome.css')); ?>" > -->
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
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Planeación<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo e(url('/direccion/proyeccion/prepago/').date('/Y-m-d')); ?>">TM Prepago</a></li>
                                    <li><a href="<?php echo e(url('/direccion/proyeccion/pospago')); ?>">TM Pospago</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tickets<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo e(url('/NuevoTicket')); ?>">Nuevo Ticket</a></li>
                                    <li><a href="<?php echo e(url('/ListaTicket')); ?>">Lista de Ticket Levantados</a></li>
                                    <li><a href="<?php echo e(url('/ListaSistemaTicket')); ?>">Ver Ticket</a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo e(url('/Administracion/root/asistencia')); ?>">Reporte asistencia</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/root/asistencias_bajas')); ?>">Reporte asistencia inactivos</a></li>
                                    <li><a href="<?php echo e(url('Administracion/ReportBaja')); ?>">Reporte bajas</a></li>
                                    <li><a href="<?php echo e(url('/capacitacionRoot')); ?>">Reporte de Capacitacion</a></li>
                                    <li><a href="<?php echo e(url('/capacitacion/campaign/inicio')); ?>">Reporte de Capacitacion por Campaña</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/operaciones/reporte')); ?>">Reporte general de operaciones</a></li>
                                    <li><a href="<?php echo e(url('/cancelaciones')); ?>">Reporte cancelaciones</a></li>
                                    <li><a href="<?php echo e(url('/ReporteOperacion')); ?>">Reporte de operación</a></li>
                                    <li><a href="<?php echo e(url('/reporteBlaster')); ?>"> Reporte Blaster </a></li>
                                    <li><a href="<?php echo e(url('/bo/historico')); ?>">Reporte Historico BO</a></li>
                                    <li><a href="<?php echo e(url('/bo/marcacion')); ?>">Reporte Marcacion/ventas</a></li>
                                    <li><a href="<?php echo e(url('/bo/marcacion2')); ?>">Reporte Marcacion/ventas 2</a></li>

                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Recursos Humanos<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo e(url('/FechaNuevoReporte')); ?>">Reporte de citas y entrevistas</a></li>
                                    <li><a href="<?php echo e(url('/fechaCitas')); ?>">Reporte Citas</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/ReporteRooot')); ?>">Reporte Reclutamiento</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/periodoIncidencia')); ?>">Reporte de Incidencias</a></li>
                                    <li><a href="<?php echo e(url('/calRecluta')); ?>">Auditoria a llamadas de reclutamiento</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">TM Prepago<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo e(url('/reporteRV')); ?>">Reporte de ventas completo</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/root/repventas3Movi')); ?>">Reporte de ventas TM Prepago por Franja Horaria</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/root/PosicionesMovi')); ?>">Reporte de posiciones TM Prepago</a></li>
                                    <li><a href="<?php echo e(url('/reporteMarcacionEstadoTelefonica')); ?>">Reporte general de marcacion Telefonica</a></li>
                                    <li><a href="<?php echo e(url('/inicioCaidas')); ?>"> Reporte de Caidas en Validacion </a></li>
                                    <li><a href="<?php echo e(url('/inicioRechazos')); ?>"> Reporte de rechazos en Validacion </a></li>
                                    <li><a href="<?php echo e(url('/Administracion/root/perRefRep')); ?>">Referencias repetidas</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/root/perMonitoreoAC')); ?>">Reporte de calidad</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Banamex<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo e(url('/banamex/reportes')); ?>"> Reportes Banamex</a></li>
                                    <li><a href="<?php echo e(url('/banamex/validacion')); ?>">Validacion Banamex</a></li>
                                    <li><a href="<?php echo e(url('/banamex/backoffice')); ?>">Back-Office Banamex</a></li>
                                    <li><a href="<?php echo e(url('/banamex/productividad')); ?>">Productividad Agentes Banamex</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Facebook<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo e(url('/reportesfacebook')); ?>">Ventas Hoy</a></li>
                                    <li><a href="<?php echo e(url('/reportesfacebook/filtro')); ?>">Reporte por Filtro</a></li>
                                    <!-- <li><a href="<?php echo e(url('/ventasAgentesFacebook')); ?>">Ventas Facebook</a></li>
                                    <li><a href="<?php echo e(url('/ventasRealesFacebook')); ?>">Ventas Reales</a></li> -->
                                    <li><a href="<?php echo e(url('/reportesfacebookventasdif')); ?>">Ventas No Reales</a></li>
                                    <!-- <li><a href="<?php echo e(url('/reportesfacebookventas')); ?>">Ventas facebook-Telemarketing</a></li> -->
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Edición<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo e(url('/EdicionEdi')); ?>">Reporte de Edición por editor</a></li>
                                    <li><a href="<?php echo e(url('/EdicionAva')); ?>">Reporte de Edición por avance</a></li>
                                    <li><a href="<?php echo e(url('/fechaNoEncontrado')); ?>">Reporte de audios no encontrados</a></li>
                                    <li><a href="<?php echo e(url('/EdicionEsta')); ?>">Reporte de Edición por Estatus</a></li>
                                    <li><a href="<?php echo e(url('/EdicionTipifica')); ?>">Reporte de Edición por Tipificación</a></li>
                                    <li><a href="<?php echo e(url('/reporte1Calidad')); ?>"> Reporte 1 de calidad de edición </a></li>
                                    <li><a href="<?php echo e(url('/reporte2Calidad')); ?>"> Reporte 2 de calidad de edición </a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Inbursa<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo e(url('/Administracion/root/perMarInbursa')); ?>">Reporte de marcación inbursa</a></li>
                                    <li><a href="<?php echo e(url('/reporteMarcacionEstado')); ?>">Reporte general de marcacion Inbursa</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/root/PosicionesInbursa')); ?>">Reporte de posiciones Inbursa</a></li>
                                </ul>
                            </li>

                           <!-- <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Mapfre<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo e(url('/reporteMarcacionEstadoMapfre')); ?>">Reporte general de marcacion Mapfre</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/root/PosicionesMapfre')); ?>">Reporte de posiciones Mapfre</a></li>
                                    <li><a href="<?php echo e(url('/ReporteVPHMapfre')); ?>">Reporte de ventas Mapfre</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/root/repventas3Mapfre')); ?>">Reporte de ventas Mapfre por Franja Horaria</a></li>
                                </ul>
                            </li>-->

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" >Menu</a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                    <li><a href="<?php echo e(url('/Administracion/root')); ?>">Nuevo empleado</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/root/plantilla')); ?>">Plantilla</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/root/plantillaV2')); ?>">Plantilla version minimizada</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/personal')); ?>">Personal</a></li>
                                    <li><a href="<?php echo e(url('/Administracion/root/PendienteAlta')); ?>">Pendiente de Alta</a></li>
                                    <li><a href="<?php echo e(url('Nomina/nomina/web')); ?>">Nomina</a></li>
                                </ul>
                            </li>
                            <li><a href="<?php echo e(url('salir')); ?>" class="btn btn-link">
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


        <?php echo $__env->yieldContent('content'); ?>


        <!-- Scripts-->
        <!--
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
                <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>


                <script src="https://code.jquery.com/jquery-3.1.1.min.js" defer></script>
                <script src="dist/js/bootstrap-submenu.min.js" defer></script>  -->



        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <?php echo $__env->yieldContent('content2'); ?>
        <script src="<?php echo e(URL('/assets/js/dynatable/jquery.dynatable.js')); ?>"></script>
    </body>
</html>
