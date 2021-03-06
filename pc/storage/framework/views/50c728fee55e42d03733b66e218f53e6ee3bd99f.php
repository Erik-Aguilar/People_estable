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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo e(url('/reportes')); ?>">Ventas</a></li>
                                <li><a href="<?php echo e(url('/reportesBo')); ?>">Reportes de BackOffice</a></li>
                                <li><a href="<?php echo e(url('/reportesRechazo')); ?>">Reportes de Rechazos</a></li>
                                <li><a href="<?php echo e(url('/reportesFvc')); ?>">Reportes de FVC</a></li>
                                <li><a href="<?php echo e(url('/reportespreactivas')); ?>"> Reportes de Preactivas</a></li>
                                <li><a href="<?php echo e(url('/reporteBlaster')); ?>"> Reporte de Blaster </a></li>
                                <li><a href="<?php echo e(url('/reportesAltas')); ?>">Reporte Centralizado de altas y marcaciones de BO</a></li>
                                <li><a href="<?php echo e(url('/reporteActivos/plantilla')); ?>">Activos</a></li>
                                <li><a href="<?php echo e(url('/ReportePlantilla')); ?>">Filtro de Plantilla</a></li>
                                <li><a href="<?php echo e(url('/ReporteOperacion')); ?>">Reporte de operación</a></li>
                                <li><a href="<?php echo e(url('Administracion/ReportBaja')); ?>">Reporte bajas</a></li>

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

    </body>
</html>
