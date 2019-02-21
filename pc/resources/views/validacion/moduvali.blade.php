@extends('layout.validacion.mod_vali')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Modulo de validación</h3>
            </div>
            <div class="panel-body">

              <table class="table table-striped table-bordered table-hover">
                  <thead>

                  <tr>
                          <th style="text-align: center;">Fechas</th>
                          <th style="text-align: center;">Dn</th>
                          <th style="text-align: center;">Tipificar</th>
                  </tr>

                  </thead>
                  <tbody>
                    @foreach($mod as $val)

                      <tr>
                          <td style="text-align: center;">{{$val->fecha}}</td>
                          <td style="text-align: center;"><a href="{{ url('dnmodulo/nuevos/ges/'.$val->dn)}}">{{$val->dn}}</a></td>
                          <td style="text-align: center;">{{$val->tipificar}}</td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>

            </div>
        </div>
    </div>
</div>
@stop
