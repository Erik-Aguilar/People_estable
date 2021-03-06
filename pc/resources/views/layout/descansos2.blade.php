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
<style media="screen">
        .fondo{
          position: fixed;
          width: 100%;
          height: 100%;
          left:0px;
          // background-image: url("assets/img/SantaCari.jpg");
          background: #009db4;
          background-repeat: no-repeat;
          /*background-size:100%  190%  ;*/
            background-size: 2300px 1800px;
          background-position:center ;
          opacity:0.7;
        }

        .login{
          position: fixed;
          top:40%;;
          left: 33%;
          width: 100%;
        }
        #logo{
          width: 50%;

        }
        .logo{
          position: fixed;
          top: 35px;
          left: 100px;
          /*right: -100px;*/
        }

        </style>


        <div class="container-fluid">
          <div class="fondo">
            <div class="row">
              <!-- <div class="logo">
                <img src="{{ asset('assets/img/Logo_Plano_blanco.png') }}" id="logo" alt="" />
              </div> -->
              <div class="login">
                <div class="Absolute-Center is-Responsive">
                  <div id="logo-container"></div>
                  <div class="col-md-4">

                  {{ Form::open(['action' => 'DescansosController@Salvar',
                                    'method' => 'post',
                                    'accept-charset'=>"UTF-8",
                                    'enctype'=>"multipart/form-data"
                                ]) }}
                                <div class="form-group input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                  <select class="form-control" name="descanso" disabled="" >
                                    <option value=""></option>
                                    <option value="2" >BREAK</option>
                                    <option value="4" >CAPACITACIÓN</option>
                                    <option value="5" >BAÑO</option>
                                    <option value="6" >RETROALIMENTACIÓN</option>
                                    <option value="8" >JUNTA</option>
                                  </select>
                                </div>

                      <p>
                        <div class="form-group">
                          <button type="submit" class="btn btn-danger btn-block">Fin</button>
                        </div>
                      </p>


                    <!-- </form> -->
                    {{ Form::close() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>



        <!-- Scripts -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>



















