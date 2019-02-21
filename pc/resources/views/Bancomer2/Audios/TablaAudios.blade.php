@extends('layout.Banamex.coordinador.coordinador')
@section('content')
  <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
              <div class="panel-heading">
                  <h3 class="panel-title">DN's Audios</h3>
              </div>
              <div class="panel-body">


                  <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                   <thead>

                          <tr>
                              <th>DN</th>
                              <th>status</th>
                              {{-- <th> Escuchar</th>
                              <th> Descargar</th> --}}
                              <tbody>

                                @foreach ($de_enes as $key => $value)

                                  @php
                                  $anio = date('Y', strtotime($value->fecha));
                                  $mes = date('m', strtotime($value->fecha));
                                  $dia = date('d', strtotime($value->fecha));
                                  @endphp

                                  <tr>

                                    <td> <a href="{{ url('BancomerDescarga/'.$campaign.'/'.$anio.'/'.$mes.'/'.$dia.'/'.substr($value->dn, -10) )}}" >{{ $value->dn}}</a> </td>
                                    <td> {{ $value->status}} </td>


                                  </tr>
                                @endforeach

                              </tbody>
                          </tr>
                      </thead>
                  </table>
              </div>
      </div>
  </div>
@stop
@section('content2')
  <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script>
  $(document).ready(function () {
    $('#dataTables-example').DataTable({
      responsive: true
    });
  });

  </script>
@stop
