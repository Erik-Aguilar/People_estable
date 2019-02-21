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
                    <a class="navbar-brand" >Back-Office</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo e(url('/bo/perRefRep')); ?>">Referencia Repetidas</a></li>
                                <li><a href="<?php echo e(url('/bo/reporteTipificacion')); ?>">Marcaciones de Back-Office</a></li>
                                <li><a href="<?php echo e(url('/Administracion/root/asistencia')); ?>">Reporte asistencia</a></li>
                                <li><a href="<?php echo e(url('/bo/PeriodoMarcacionBO')); ?>">Reporte Marcacion</a></li>
                                <li><a href="<?php echo e(url('/reporteRV')); ?>">Reporte de ventas completo</a></li>
                                <li><a href="<?php echo e(url('/bo/altas')); ?>">Subir Reporte de Altas</a></li>
                                <li><a href="<?php echo e(url('/reporteHistorico')); ?>">Reporte Historico de BO</a></li>
                                <li><a href="<?php echo e(url('/bo/marcacion')); ?>">Reporte Marcacion/ventas</a></li>
                                <li><a href="<?php echo e(url('/bo/marcacion2')); ?>">Reporte Marcacion/ventas 2</a></li>
                                <li><a href="<?php echo e(url('/bo/wa')); ?>">Genera base WhatsApp</a></li>
                                <li><a href="<?php echo e(url('/ValidadoresVidatel')); ?>">Reporte Validaciones Vidatel</a></li>
                                <li><a href="<?php echo e(url('/Estatus_Proceso1')); ?>">Monitoreo P1</a></li>
                                <li><a href="<?php echo e(url('/InbursaVidatel/reportes')); ?>">Reportes Vidatel</a></li>
                                <li><a href="<?php echo e(url('/banamex/backoffice')); ?>">Back-Office Banamex</a></li>
                                <li><a href="<?php echo e(url('/bo/asigna_base')); ?>">Asigna Base</a></li>
                                <li><a href="<?php echo e(url('/bo/base_wa')); ?>">Genera Base WhatsApp</a></li>
                                <li><a href="<?php echo e(url('/bo/subeArchivoIngresos')); ?>">Sube Archivo de Ingresos para BO</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes Facebook<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo e(url('/reportesfacebook')); ?>">Ventas Hoy</a></li>
                                <li><a href="<?php echo e(url('/reportesfacebook/filtro')); ?>">Reporte por Filtro</a></li>
                                <li><a href="<?php echo e(url('/ventasAgentesFacebook')); ?>">Ventas Facebook</a></li>
                                <li><a href="<?php echo e(url('/ventasRealesFacebook')); ?>">Ventas Reales</a></li>
                                <li><a href="<?php echo e(url('/reportesfacebookventasdif')); ?>">Ventas No Reales</a></li>
                                <li><a href="<?php echo e(url('/reportesfacebookventas')); ?>">Ventas facebook-Telemarketing</a></li>
                                <!--<li><a href="/">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="/">Separated link</a></li>
                                <li class="divider"></li>
                                <li><a href="/">One more separated link</a></li>-->
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
<?php echo $__env->yieldContent('content2'); ?>
    </body>
</html>
