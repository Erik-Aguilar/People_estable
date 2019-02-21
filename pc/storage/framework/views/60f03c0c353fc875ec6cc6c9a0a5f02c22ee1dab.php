<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

 <style media="screen">
    .panel> .panel-heading {
      color: #fff;
      background: #fc1700;
      border: #fc1700;
    }
    .panel{
      border-color: #fc1700;
    }
  /*----------------*/
  .navbar-default {
    background-color: #fc1700;
    border-color: #fc1700;
}
/* title */
.navbar-default .navbar-brand {
    color: #fff;
}
.navbar-default .navbar-brand:hover,
.navbar-default .navbar-brand:focus {
    color: #fff;
}
/* link */
.navbar-default .navbar-nav > li > a {
    color: #fff;

}
.navbar-default .navbar-nav > li > a:hover,
.navbar-default .navbar-nav > li > a:focus {
    color: #000;
    background-color: #EA1501;
}
.navbar-default .navbar-nav > .active > a,
.navbar-default .navbar-nav > .active > a:hover,
.navbar-default .navbar-nav > .active > a:focus {
    color: #000;
    background-color: #EA1501;
}
.navbar-default .navbar-nav > .open > a,
.navbar-default .navbar-nav > .open > a:hover,
.navbar-default .navbar-nav > .open > a:focus {
    color: #000;
    background-color: #EA1501;
}
/* caret */
.navbar-default .navbar-nav > .dropdown > a .caret {
    border-top-color: #fff;
    border-bottom-color: #fff;
}
.navbar-default .navbar-nav > .dropdown > a:hover .caret,
.navbar-default .navbar-nav > .dropdown > a:focus .caret {
    border-top-color: #333;
    border-bottom-color: #333;
}
.navbar-default .navbar-nav > .open > a .caret,
.navbar-default .navbar-nav > .open > a:hover .caret,
.navbar-default .navbar-nav > .open > a:focus .caret {
    border-top-color: #000;
    border-bottom-color: #000;
}
/* mobile version */
.navbar-default .navbar-toggle {
    border-color: #DDD;
}
.navbar-default .navbar-toggle:hover,
.navbar-default .navbar-toggle:focus {
    background-color: #DDD;
}
.navbar-default .navbar-toggle .icon-bar {
    background-color: #CCC;
}
@media (max-width: 767px) {
    .navbar-default .navbar-nav .open .dropdown-menu > li > a {
        color: #777;
    }
    .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
    .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {

        color: #333;
    }
}
.navbar-default .dropdown-menu {
     background-color: #fc1700;
     color:#fff;
}
.navbar-default .dropdown-menu:hover {

     color:#fff;
}
.navbar-default .navbar-nav .open .dropdown-menu>li>a{
    background-color: #fc1700;
    color:#ffffff;
}
.navbar-default .navbar-nav .open .dropdown-menu>li>a:hover{

    color:#000;
}
  /*-------------------*/
    </style>


  
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
              <a class="navbar-brand" href="#">Mapfre</a>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu<span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#"></a></li>
                        <li><a href="#"></a></li>
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
    <style media="screen">
      body{
        margin: 5%;
      }
    </style>

    <div class="container-fluid">
      <?php echo $__env->yieldContent('content'); ?>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
