@extends('a.layout-master')
@section('content')

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Calidad</h3>
  </div>
  <div class="panel-body">

    <form class="form-horizontal" action="{{url('/Inbursa/Calidad/Audios/Lista')}}" method="post">
      <fieldset>
        <legend>Seleccione una fecha</legend>
        <div class="form-group">
          <label for="inputEmail" class="col-lg-2 control-label">Fecha de edición</label>
          <div class="col-lg-8">
            <input type="date" class="form-control" name="fecha" value="{{date('Y-m-d')}}">
          </div>
          <div class="col-lg-2">
            <!-- <button type="reset" class="btn btn-default">Cancel</button> -->
            <button type="submit" class="btn btn-primary">Buscar</button>
          </div>
        </div>


      </fieldset>
    </form>

  </div>
</div>

@stop
