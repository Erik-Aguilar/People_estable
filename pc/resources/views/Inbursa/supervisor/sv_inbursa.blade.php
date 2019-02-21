@extends($menu)
@section('content')

<style media="screen">
  .panel-title,.panel-body,.panel-heading{text-align: center;}
</style>


<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6">
      <div class="row">
        <div class="col-lg-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
              <h3 class="today">
                <?php date_default_timezone_set ( 'America/Mexico_City' ); echo date('h:i A');?>
              </h3>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
              <h3 class="today">
                <?php echo date('D d F Y'); ?>
              </h3>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="panel panel-default">
            <div class="panel-heading">
                <img src="{{ asset('assets/img/logopeople.png') }}" id="logo" alt="" />
            </div>
            <div class="panel-body">
              <img src="{{ asset('assets/img/inbursalogo.png') }}" id="logo" alt="" />
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Ventas de hoy</h3>
            </div>
            <div class="panel-body">
              @foreach ($ventasHoy as $valueventasHoy)
              {{$valueventasHoy->vHoy}}
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Ventas diarias promedio</h3>
            </div>
            <div class="panel-body">
              Panel content
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title">Ventas totales reportadas</h3>
            </div>
            <div class="panel-body">
              Panel content
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">Ventas totales aprobadas</h3>
            </div>
            <div class="panel-body">
              Panel content
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="panel panel-warning">
            <div class="panel-heading">
              <h3 class="panel-title">Nivel de eficiencia</h3>
            </div>
            <div class="panel-body">
              Panel content
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="row">
        <div class="col-lg-12">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="warning text-center"><h4>Num.</h4></th>
                <th class="info"><h4>Agente</h4></th>
                <th class="success text-center"><h4>Ventas</h4></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($ventaXemp as $key => $valueventaXemp)
              <tr>
                <td class="warning text-center">{{$key+1}}</td>
                <td class="info">{{$valueventaXemp->nombre_completo}}</td>
                <td class="success text-center">{{$valueventaXemp->ventas}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@stop
