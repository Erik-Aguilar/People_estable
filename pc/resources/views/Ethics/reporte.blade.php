@extends('layout.Ethics.reportes')

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-info">
        <div class="panel-heading form-horizontal ">

          <div class="col-xs-3 col-xs-offset-4">
            <input style="text-align: center" type="date" class="form-control" id="fechaReporte">
          </div>
          <br><br>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-hover ">
            <thead>
              <tr>
                <th>#</th>
                <th>Campaña</th>
                <th>Nombre</th>
                <th>Puesto</th>
                <th>Estatus</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="contenidoReporte">
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>

@stop

@section('content2')
<script type="text/javascript">
  $("#fechaReporte").change(function (){
    var url = "{{URL('/ethics/reporte/datos')}}" + "/" +$("#fechaReporte").val();
    var html="";
    var num=0;
    var urlAudio='';
    $.get(url, function (data) {

      $.each( data, function( key, value ) {
        urlAudio= "{{URL('/ethics/reporte/descarga')}}" + "/" + value.fecha + "/" + value.audio ;
        num=key+1;
        html+="<tr>";
        html += "<td>" + num + "</td>"  ;
        html += "<td>" + value.empresa + "</td>"  ;
        html += "<td>" + value.nombre + "</td>"  ;
        html += "<td>" + value.puesto + "</td>"  ;
        html += "<td>" + value.estatus + "</td>"  ;
        html += "<td> <a class='btn btn-info glyphicon glyphicon-download-alt' href='" + urlAudio + "'></a></td>"
        html += "</tr>";
      });

      $("#contenidoReporte").html(html);

      console.log(html);
    });

  });
</script>
@stop
