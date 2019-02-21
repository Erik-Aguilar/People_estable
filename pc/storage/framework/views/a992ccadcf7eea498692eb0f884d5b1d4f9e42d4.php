<!DOCTYPE html>
<html>
  <head>
    <title>PeopleConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://bootswatch.com/3/darkly/bootstrap.min.css">
    <link rel="stylesheet" href="https://bootswatch.com/3/darkly/bootstrap.css">
    <style media="screen">
      #collapse1{
        overflow-y:scroll;
        height:600px;
      }
    </style>
  </head>
  <body>
<br>
    <div class="container">
      <div class="panel-group">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                Log
              </h4>
            </div>
            <div id="collapse1" >
              <table class="table table-striped table-hover " id="mensajes2">

              </table>
            </div>
          </div>
        </div>
      </div>

  </body>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  <script type="text/javascript">
      var es = new EventSource("<?php echo url('/monitor/inbursa/event') ;?>");

      es.onmessage = function(e) {
        var data=e.data;
        $("#mensajes2").html(data);
      }
    </script>
</html>
