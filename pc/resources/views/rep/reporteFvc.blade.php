@extends('layout.rep.basic')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reporte de FVC</h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"><a href="#">Reporte de FVC</a></li>
        </ul>
        <br>
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="text-align:center">Campaña</th>
              <th style="text-align:center">Dia</th>
              <th style="text-align:center"># con FVC</th>
              <th style="text-align:center"># sin FVC</th>
              <th style="text-align:center">% con FVC</th>
              <th style="text-align:center">% sin FVC</th>
            </tr>
          </thead>
          <tbody>
            @foreach($ventas as $valueUser)
            <tr>
              <td style="text-align:center">TM Prepago</td>
              <td style="text-align:center">{{ $valueUser->fecha }}</td>
              <td style="text-align:center">{{ $valueUser->conFvc }}</td>
              <td style="text-align:center">{{ $valueUser->sinFvc }}</td>
              <td style="text-align:center">{{ number_format($valueUser->porconfvc,2,'.','')}} %</td>
              <td style="text-align:center">{{ number_format($valueUser->porsinfvc,2,'.','')}} %</td>
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

</script>

@stop
