<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PeopleConnect</title>

    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/bootstrap/dist/css/bootstrap.min.css')); ?>">


    <!-- Optional theme -->
    <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css"> -->
    <!-- <link rel="stylesheet" href="<?php echo e(asset('/assets/css/united_bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/assets/css/united_bootstrap.css')); ?>"> -->
    <script src="<?php echo e(asset('/assets/js/2.1.3.jquery.min.js')); ?>" ></script>
    <link rel="stylesheet" href="<?php echo e(asset('/assets/css/layout-master.css')); ?>" >


</head>

<body>

  <nav class="navbar navbar-default navbar-fixed-bottom navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#menu-toggle">
          <span class="glyphicon glyphicon-menu-hamburger menu-toggle"  aria-hidden="true">
            PeopleConnect
          </span>
        </a>
      </div>
      <?php if(session('nombre')): ?>
      <ul class="nav navbar-nav navbar-right">
        <li><a><?php echo e(session('nombre')); ?></a></li>
      </ul>
      <?php else: ?>
      <ul class="nav navbar-nav navbar-right">
        <li><a>Invitado</a></li>
      </ul>
      <script type="text/javascript">
        window.location = "<?php echo e(url('/salir')); ?>";//here double curly bracket
      </script>
      <?php endif; ?>
    </div>
  </nav>

    <div id="wrapper" class="container-fluid" >

        <!-- Sidebar -->
        <div id="sidebar-wrapper" >
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        PeopleConnect
                    </a>
                </li>
                <!-- Calidad -->
                <?php if(session('area')=='Calidad' || session('puesto')=='Jefe de desarrollo'): ?>
                <li data-toggle="collapse" data-target="#calidad" class="collapsed active">
                  <a>
                    Calidad <span class="glyphicon glyphicon-chevron-down"></span>
                  </a>
                </li>

                <ul class="sub-menu collapse nav nav-pills nav-stacked" id="calidad">
                  <?php if(session('campaign')=='Inbursa' || session('puesto')=='Jefe de desarrollo'): ?>
                  <li data-toggle="collapse" data-target="#InbursaCalidad" class="collapsed active">
                    <a>
                      Inbursa <span class="glyphicon glyphicon-triangle-bottom"></span>
                    </a>
                  </li>
                  <ul class="sub-menu collapse nav nav-pills nav-stacked" id="InbursaCalidad">
                      <li class=""><a href="<?php echo e(url('/Inbursa/Calidad/Audios/Inicio')); ?>" class="glyphicon glyphicon-menu-right"> Edición</a></li>
                      <li class=""><a href="<?php echo e(url('/Inbursa/Calidad/Ventas/Inicio')); ?>" class="glyphicon glyphicon-menu-right"> Ventas</a></li>
                  </ul>
                  <?php endif; ?>
                </ul>

                <?php endif; ?>






                <!-- Inbursa -->
                <?php if(session('campaign')=='Inbursa' || session('area')=='Sistemas'): ?>
                  <li data-toggle="collapse" data-target="#InbursaOperaciones" class="collapsed active">
                    <a>
                      Inbursa <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                  </li>


                  <ul class="sub-menu collapse nav nav-pills nav-stacked" id="InbursaOperaciones">
                    <?php if(session('puesto')=='Operador de call center' || session('puesto')=='Jefe de desarrollo'): ?>
                    <li data-toggle="collapse" data-target="#OperadorInbursa" class="collapsed active">
                      <a>
                        Operador<span class="glyphicon glyphicon-triangle-bottom"></span>
                      </a>
                    </li>

                    <ul class="sub-menu collapse nav nav-pills nav-stacked" id="OperadorInbursa">
                        <li class=""><a href="<?php echo e(url('/Inbursa/Operaciones/Agente/Inicio')); ?>" class="glyphicon glyphicon-menu-right"> Captura</a></li>
                        <li class=""><a href="<?php echo e(url('/Inbursa/Calidad/Ventas/Inicio')); ?>" class="glyphicon glyphicon-menu-right"> Corroboración</a></li>
                    </ul>
                    <?php endif; ?>
                    <?php if(session('puesto')=='Validador' || session('puesto')=='Jefe de desarrollo'): ?>
                    <li data-toggle="collapse" data-target="#ValidadorInbursa" class="collapsed active">
                      <a>
                        Validación <span class="glyphicon glyphicon-triangle-bottom"></span>
                      </a>
                    </li>

                    <ul class="sub-menu collapse nav nav-pills nav-stacked" id="ValidadorInbursa">
                        <li class=""><a href="<?php echo e(url('/Inbursa/Calidad/Audios/Inicio')); ?>" class="glyphicon glyphicon-menu-right"> Captura</a></li>
                        <li class=""><a href="<?php echo e(url('/Inbursa/Calidad/Ventas/Inicio')); ?>" class="glyphicon glyphicon-menu-right"> Corroboración</a></li>
                    </ul>
                    <?php endif; ?>




                    <?php if(session('area')=='Sistemas' || session('puesto')=='Supervisor'): ?>
                    <li data-toggle="collapse" data-target="#ReportesInbursa" class="collapsed active">
                      <a>
                        Reportes <span class="glyphicon glyphicon-triangle-bottom"></span>
                      </a>
                    </li>

                    <ul class="sub-menu collapse nav nav-pills nav-stacked" id="ReportesInbursa">
                        <li class=""><a href="<?php echo e(url('/Inbursa/Reportes/Envio/Ventas/Inicio')); ?>" class="glyphicon glyphicon-menu-right"> Enviar ventas</a></li>
                        <li class=""><a href="<?php echo e(url('/Inbursa/Reportes/Envio/Validaciones/Inicio')); ?>" class="glyphicon glyphicon-menu-right"> Enviar validaciones</a></li>
                        <li class=""><a href="<?php echo e(url('/Inbursa/Reportes/Envio/Rechazos/Inicio')); ?>" class="glyphicon glyphicon-menu-right"> Subir rechazos</a></li>
                    </ul>
                    <?php endif; ?>
                  </ul>







                  <li data-toggle="collapse" data-target="#InbursaSolucionesOperaciones" class="collapsed active">
                    <a>
                      Inbursa Soluciones <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                  </li>

                  <ul class="sub-menu collapse nav nav-pills nav-stacked" id="InbursaSolucionesOperaciones">
                    <?php if(session('area')=='Sistemas' || session('puesto')=='Supervisor'): ?>
                    <li data-toggle="collapse" data-target="#ReportesInbursaSoluciones" class="collapsed active">
                      <a>
                        Reportes Soluciones <span class="glyphicon glyphicon-triangle-bottom"></span>
                      </a>
                    </li>

                    <ul class="sub-menu collapse nav nav-pills nav-stacked" id="ReportesInbursaSoluciones">
                        <li class=""><a href="<?php echo e(url('/InbursaSoluciones/Reportes/Envio/Ventas/Inicio')); ?>" class="glyphicon glyphicon-menu-right">Ventas Soluciones</a></li>
                        <li class=""><a href="<?php echo e(url('/InbursaSoluciones/Reportes/Envio/Validaciones/Inicio')); ?>" class="glyphicon glyphicon-menu-right">Validaciones Soluciones </a></li>
                        <!-- <li class=""><a href="<?php echo e(url('/hola3')); ?>" class="glyphicon glyphicon-menu-right">Rechazos Soluciones</a></li> -->
                    </ul>
                    <?php endif; ?>
                  </ul>

                <?php endif; ?>
                <li>
                  <a href="<?php echo e(url('/salir')); ?>">
                    Salir <span class="glyphicon glyphicon-off"></span>
                  </a>
                </li>

            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" >
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                      <?php echo $__env->yieldContent('content'); ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->

    <script>
    // $("#wrapper").toggleClass("toggled");
    $(".menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>


</body>
<script src="<?php echo e(asset('/assets/js/jquery-3_2_1.min.js')); ?>" ></script>
<script src="<?php echo e(asset('/assets/js/popper.min.js')); ?>" ></script>
<script src="<?php echo e(asset('assets/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>

<?php echo $__env->yieldContent('contentScript'); ?>

</html>
