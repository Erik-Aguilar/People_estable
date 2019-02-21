@extends($menu)
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Referencias Repetidas</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th># Empleado</th>
                            <th>Nombre</th>
                            <th>Fecha Ingreso</th>
                            <th>Fecha Baja</th>
                            <th>Motivo</th>
                            <th># Supervisor</th>
                            <th>Nombre</th>
                            <th>Mes Baja</th>
                            <th>Mes Ingreso</th>
                            <th>Dias I - B</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $a = 1;
                      ?>
                      @foreach($repBajas as $valuerepBajas)
                      <tr>
                        <td><?php
                        echo $a;
                        ?></td>
                        <td>{{ $valuerepBajas->num_emp }}</td>
                        <td>{{ $valuerepBajas->emp }}</td>
                        <td>{{ $valuerepBajas->fi }}</td>
                        <td>{{ $valuerepBajas->fb }}</td>
                        <td>{{ $valuerepBajas->mot }}</td>
                        <td>{{ $valuerepBajas->num_sup }}</td>
                        <td>{{ $valuerepBajas->sup }}</td>
                        <td>{{ $valuerepBajas->Mes_Ingreso }}</td>
                        <td>{{ $valuerepBajas->Mes_Baja }}</td>
                        <td>{{ $valuerepBajas->Dias_I_B }}</td>
                      </tr>
                      <?php
                      $a ++;
                      ?>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>


@stop
