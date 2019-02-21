@extends("layout.Inbursa.supervisor")
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Edición Ventas Inbursa</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Teléfono</th>
                            <th>Fecha</th>
                            <th>Estatus</th>
<!--                            <th>Editado</th>        -->
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($datos as $key => $value): ?>
                        <tr >
                            <td> <a href="{{ url('datosVentaRechazada/'.$value -> telefono.'/'.$value -> fecha_capt2 ) }}">{{ $value -> telefono }} </a></td>
                            <td> {{ $value -> fecha_capt2 }} </td>
                            @if($value -> editado == 1)
                              <td> Editado </td>
                            @else
                              <td> {{$value -> validacion}} </td>
                            @endif
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
@stop
