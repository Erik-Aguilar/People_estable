@extends($menu)
@section('content')

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th>DN</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $value)
                                    <tr >
                                      <td><a href="/bo/consulta/{{ $value->dn }}">{{ $value->dn }}</a></td>
                                      <td>{{ $value->fecha }}</td>
                                      <td>{{ $value->hora }}</td>
                                      <td>{{ $value->estatus }}</td>
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
        @section('content2')

        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <script>
          $(document).ready(function () {
              $('#dataTables-example').DataTable({
                  responsive: true,
                  "order": [[ 1, 'desc' ]]
              });
          });
        </script>
    @stop
