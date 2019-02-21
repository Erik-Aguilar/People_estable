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
        <link rel="stylesheet" href="<?php echo e(URL('/assets/js/dynatable/jquery.dynatable.css')); ?>">
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
                    <a class="navbar-brand" href="#">TM Prepago Coordinador</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menú<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo e(url('/coordinador')); ?>">Pendiente de Alta</a></li>
                                <li><a href="<?php echo e(url('/coordinadortotal')); ?>">Listado</a></li>
                                <li><a href="<?php echo e(url('/coordinadorAsistencia')); ?>">Asistencia</a></li>
                                <li><a href="<?php echo e(url('/coordinador/plantilla')); ?>">Personal</a></li>
                                <!--<li><a href="<?php echo e(url('/coordinador/rgo')); ?>">Reporte General de Operación</a></li> -->
                                <li><a href="<?php echo e(url('/coordinador/perRefRep')); ?>">Referencias Repetidas</a></li>
                                <li><a href="<?php echo e(url('/coordinador/perMonitoreoAC')); ?>">Reporte de Calidad</a></li>

                                <!-- <li><a href="<?php echo e(url('/EdicionEdi')); ?>">Reporte de edición por editor</a></li> -->
                                <!-- <li><a href="<?php echo e(url('/EdicionAva')); ?>">Reporte de edición por avance</a></li> -->
                                <li><a href="<?php echo e(url('/fechaNoEncontrado')); ?>">Reporte de audios no encontrados</a></li>
                                <!-- <li><a href="<?php echo e(url('/EdicionEsta')); ?>">Reporte de Edición por Estatus</a></li> -->
                                <!-- <li><a href="<?php echo e(url('/EdicionTipifica')); ?>">Reporte de Edición por Tipificación</a></li> -->
                                <li><a href="<?php echo e(url('/FechaNuevoReporte')); ?>">Reporte citas y entrevistas</a></li>
                                <li><a href="<?php echo e(url('/rh/Asistenciacapacitacion')); ?>">Reporte de asistencia a capacitacion</a></li>

                                <!--<li><a href="/">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="/">Separated link</a></li>
                                <li class="divider"></li>
                                <li><a href="/">One more separated link</a></li>-->
                            </ul>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" >Recepción</a>
                              <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                <!-- <li><a href="<?php echo e(url('/Administracion/admin')); ?>">Nuevo Empleado</a></li>-->
                                <li><a href="<?php echo e(url('rh/inicio')); ?>">Nuevo Candidato</a></li>
                                <li><a href="<?php echo e(url('/recepcion')); ?>">Pendiente de Alta</a></li>
                                <li><a href="<?php echo e(url('/Administracion/admin/plantilla')); ?>">Plantilla</a></li>
                                <li><a href="<?php echo e(url('/citas')); ?>">Citas</a></li>
                                <li><a href="<?php echo e(url('/recepcion/asistencia/')); ?>">Asistencia Capacitación</a></li>
                                <li><a href="<?php echo e(url('/Administracion/personal')); ?>">Personal</a></li>
                                <li><a href="<?php echo e(url('rh/candidatosTotal')); ?>">Listado de Candidatos</a></li>
                                <li><a href="<?php echo e(url('/rh/citasGeneral')); ?>">Citas Agendadas General</a></li>
                                <li><a href="<?php echo e(url('rh/capacitacion')); ?>">Asistencia a Capacitación</a></li>
                                <li><a href="<?php echo e(url('rh/capacitacionMedio')); ?>">Capacitación por Medio de Reclutamiento</a></li>
                                <li><a href="<?php echo e(url('rh/capacitacionMedioActivo')); ?>">Capacitación por Reclutador</a></li>
                                <li><a href="<?php echo e(url('rh/asistencia')); ?>">Asistencia</a></li>
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





        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

        <?php echo $__env->yieldContent('content2'); ?>
        <script src="<?php echo e(URL('/assets/js/dynatable/jquery.dynatable.js')); ?>"></script>
    </body>
</html>
