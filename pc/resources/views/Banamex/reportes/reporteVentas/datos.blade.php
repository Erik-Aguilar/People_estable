@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Banamex</h3>
            </div>
            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="myModal" role="dialog">
              <div class="modal-dialog" role="document" style="width:1250px; height:550px;">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Captura</h4>
                  </div>
                  <div class="modal-body">
                    <img src="" height="550" width="1200" id='imaf'>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->





            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                          <th>Dn</th>
                          <th>Nombre del audio</th>
                          <th>Folio</th>
                          <th>Nombre de la imagen</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($datos as $key=> $value)
                      <tr>
                        <td>{{$value->dn}}</td>
                        <td>
                          <div class="form-group">
                            <div class="col-sm-10">
                              {{$value->nombre_audio}}
                            </div>
                            <div class="col-sm-1 ">
                              @if($value->nombre_audio!='Audio No Encontrado' && $value->nombre_audio!='')
                              <button style="text-align:left" class="btn btn-primary glyphicon glyphicon-download audiof" type="button" value="{{$value->v_id}}" name="button" ></button>
                              @endif
                            </div>
                          </div>
                        </td>
                        <td>{{$value->folio}}</td>
                        <td>
                          <div class="form-group">
                            <div class="col-sm-8 ">
                              {{$value->nombre_imagen}}
                            </div>
                            <div class="col-sm-1 col-sm-offset-1">
                              @if($value->nombre_imagen!='')
                              <button class="btn btn-primary glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#myModal" value="{{$value->v_id}}" ></button>
                              @endif
                            </div>
                          </div>

                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('content2')
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!--alertify -->
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.core.css">
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.default.css">
<script src="http://blog.reaccionestudio.com/ejemplos/alertify_js/lib/alertify.js"></script>

<script>

    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    $( ".audiof" ).click(function( event ) {
      window.open("/banamex/download/"+this.value, '_blank');
      // console.log(this.value);
      // $.ajax({
      //   url:   "/banamex/download/"+this.value,
      //   type:  'get',
      //   beforeSend: function () {
      //     console.log('espere');
      //   },
      //   success:  function (data)
      //   {
      //
      //     console.log('ok');
      //     console.log(data);
      //   }
      // });
      // $( "#log" ).html( "clicked: " + event.target.nodeName );
    });
    $( "button" ).click(function( event ) {
      console.log(this.value);
      $.ajax({
        url:   "/banamex/image/"+this.value,
        type:  'get',
        beforeSend: function () {
          console.log('espere');
        },
        success:  function (data)
        {
          console.log(data);
          $("#imaf").attr('src',data);
        }
      });
    });



</script>

@stop
