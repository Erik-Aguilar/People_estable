@extends('layout.demos.reporte')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Módulo de edición</h3>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <th> Fecha</th>
              <th> Hora</th>
              <th> Escuchar</th>
              <th> Descargar</th>
            </tr>
          </thead>
          <tbody>
            <tr >
              <td>10/05/2016</td>
              <td>10:30:00</td>
              <td>
                <div>
                  <button type="button" class="btn btn-default" onclick="document.getElementById('audio1').play()">
                    <span class="glyphicon glyphicon-play"></span>
                  </button>
                  <button type="button" class="btn btn-default" onclick="document.getElementById('audio1').pause()">
                    <span class="glyphicon glyphicon-pause"></span>
                  </button>
                </div>
              </td>
              <td>
                <a href="" type="button" class="btn btn-default" download="audio.wav">
                  <span class="glyphicon glyphicon-download-alt"></span>
                </a>
              </td>
            </tr>
            <tr >
                <td>10/05/2016</td>
                <td>10:30:00</td>
              <td>
              <div>
                <button type="button" class="btn btn-default" onclick="document.getElementById('audio2').play()">
                  <span class="glyphicon glyphicon-play"></span>
                </button>
                <button type="button" class="btn btn-default" onclick="document.getElementById('audio2').pause()">
                  <span class="glyphicon glyphicon-pause"></span>
                </button>
                </div>
              </td>
              <td>
                <a href="" type="button" class="btn btn-default" download="Kalimba.mp3">
                  <span class="glyphicon glyphicon-download-alt"></span>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="">
          <input type="text" value="5588861795" readonly>
          <input type="date" value="2013-05-08" readonly>
        </div>
        <br>
        <div class="">
          <input name="imagen" type="file" />
        </div>
        <br>
      <div class="">
              {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
      </div>
      </div>
    </div>
  </div>
</div>
@stop
