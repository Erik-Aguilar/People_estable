@extends($layout)
@section('content')
<html>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte Auri Llamadas (Periodo {{$fechai}} al {{$fechaf}})</h3>
                </div>
            <div class="panel-body"> <center>
     <div id="columnchart_material" style="width: 900px; height: 500px;"></div>


                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
              <script type="text/javascript">
                google.charts.load('current', {'packages':['bar']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                  <?php foreach ($llamadas as $key => $value): ?>
                    var data = google.visualization.arrayToDataTable([
                      ['', 'Telefonos marcados', 'Telefono no existe', 'Informacion por correo','contacto efectivo'],
                      ['Total en llamadas', {{ $value -> telefono }}, {{ $value -> tel_no_existe}}, {{ $value -> inf_correo }},{{ $value -> contacto_efectivo }}]
                    ]);
                  <?php endforeach ?>
                  var options = {
                    chart: {
                      title: 'Total de llamadas en Auri',
                    }
                  };

                  var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                  chart.draw(data, options);
                }
              </script>
              </center>
            </div>
        </div>
    </div>
</div>




</html>


@stop