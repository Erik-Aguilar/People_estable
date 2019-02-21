@extends('layout.operaciones.TMreportetipifica')
@section('content')


<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.js"></script>
<script src= "Scripts/jquery-1.5.2.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>

<script>
   
    
</script> 


<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"> Periodo Turno Validacion</h3>
      </div>
        <div class="panel-body">
          <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
            <div class="carousel-inner" role="listbox" style="text-align: center; font-size: 14px">


              <div class="item active" id="myCarousel">
                <table class="table table-bordered">
                  <tr>
                    <span>
                      <a class="left" href="#myCarousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                    </span>

                    <span> {{ $fechaValue[0]}} </span>
                    <span> al </span>
                    <span> {{ $ultimo = end($fechaValue)}} </span>

                    <span>
                      <a class="right" href="#myCarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </span>
                  </tr>

                </table>
              </div>

@foreach($fechaValue as $fecha)
              <div class="item" id="myCarousel">
                <table class="table table-bordered">
                  <tr>
                    <th style="text-align: center;" rowspan="2" > Campaña </th>
                    <th style="text-align: center;" rowspan="2"> Turno </th>
                    <th style="text-align: center;" class="dropdown" colspan="16">
                      
                      <span>
                        <a class="left" href="#myCarousel" role="button" data-slide="prev">
                          <span class="glyphicon glyphicon-chevron-left"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                      </span>
                      
                      <span> {{ $fecha }} </span>
                      
                      <span>                      
                        <a class="right" href="#myCarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" id="b1"></span>
                        <span class="sr-only">Next</span>
                        </a>
                      </span>

                    </th>
                  </tr>

                  <tr >
                    <th style="text-align: center; font-size: 12px"> Buzon de Voz </th>
                    <th style="text-align: center; font-size: 12px"> DN gestionado por otro Call Center </th>
                    <th style="text-align: center; font-size: 12px"> DN Lista Negra </th>
                    <th style="text-align: center; font-size: 12px"> Llamar despues </th>
                    <th style="text-align: center; font-size: 12px"> Lo pensara </th>
                    <th style="text-align: center; font-size: 12px"> No contesta </th>
                    <th style="text-align: center; font-size: 12px"> No es Titular </th>
                    <th style="text-align: center; font-size: 12px"> No le interesa </th>
                    <th style="text-align: center; font-size: 12px"> Problemas Marcacion </th>
                    <th style="text-align: center; font-size: 12px"> Recarga Fija </th>
                    <th style="text-align: center; font-size: 12px"> Rechaza Oferta </th>
                    <th style="text-align: center; font-size: 12px"> Renta Fija </th>
                    <th style="text-align: center; font-size: 12px"> Renta Movil </th>
                    <th style="text-align: center; font-size: 12px"> Se corta llamada </th>
                    <th style="text-align: center; font-size: 12px"> Tono Ocupado </th>
                    <th style="text-align: center; font-size: 12px"> Transferencia a Validacion </th>
                  </tr>

                  <tr>
                    <th style="text-align: center; font-size: 12px"> TM Prepago </th>
                    <th style="text-align: center; font-size: 12px"> Turno </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                    <th style="text-align: center; font-size: 12px">  </th>
                  </tr>
                </table>
              </div>
@endforeach

            </div>

            
            <!-- -->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@stop

<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.js"></script>
