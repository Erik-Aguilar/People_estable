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
                    <a class="navbar-brand" href="#">Reclutamiento</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo e(url('rh/inicio')); ?>">Nuevo Candidato</a></li>
                                <li><a href="<?php echo e(url('rh/candidatos')); ?>">Ver candidatos</a></li>
                                <li><a href="<?php echo e(url('rh/candidatosTotal')); ?>">listado de candidatos</a></li>
                                <li><a href="<?php echo e(url('rh/citasPersonal')); ?>">Citas Agendadas Personal</a></li>
                                <li><a href="<?php echo e(url('/rh/citasGeneral')); ?>">Citas Agendadas General</a></li>
                                <li><a href="<?php echo e(url('rh/capacitacion')); ?>">Asistencia a capacitacion</a></li>
                                <li><a href="<?php echo e(url('rh/capacitacionMedio')); ?>">Capacitacion por medio de Reclutamiento</a></li>
                                <li><a href="<?php echo e(url('rh/capacitacionMedioActivo')); ?>">Capacitacion por Reclutador</a></li>
                                <li><a href="<?php echo e(url('rh/asistencia')); ?>">Asistenacia</a></li>
                                <!--li><a href="/">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="/">Separated link</a></li>
                                <li class="divider"></li>
                                <li><a href="/">One more separated link</a></li>-->
                                <li><a href="<?php echo e(url('/Administracion/root')); ?>">Nuevo empleado</a></li>
                                <!-- <li><a href="<?php echo e(url('rh/inicio')); ?>">Nuevo Candidato</a></li> -->
                                <li><a href="<?php echo e(url('/recepcion')); ?>">Pendiente de Alta</a></li>
                                <li><a href="<?php echo e(url('/Administracion/admin/plantilla')); ?>">Plantilla</a></li>
                                <li><a href="<?php echo e(url('/citas')); ?>">Citas</a></li>
                                <li><a href="<?php echo e(url('/recepcion/asistencia/')); ?>">Asistencia Capacitación</a></li>
                                <li><a href="<?php echo e(url('/Administracion/personal')); ?>">Personal</a></li>
                                <li><a href="<?php echo e(url('/FechaNuevoReporte')); ?>">Reporte de citas y entrevistas</a></li>
                                <li><a href="<?php echo e(url('/subirCancelaciones')); ?>">Subir reporte de cancelaciones</a></li>
                                <li><a href="<?php echo e(url('/cancelaciones')); ?>">Reporte de cancelaciones </a></li>

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



        <!-- Scripts -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

        <?php echo $__env->yieldContent('contentScript'); ?>
        <?php echo $__env->yieldContent('content2'); ?>
        <?php echo e(Html::script('assets/dropdown.js')); ?>

        <script src="<?php echo e(URL('/assets/js/dynatable/jquery.dynatable.js')); ?>"></script>

    </body>
</html>
