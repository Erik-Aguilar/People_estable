@extends('layout.operaciones.TMreportetipifica2')
@section('content')


<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.js"></script>
<script src= "Scripts/jquery-1.5.2.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>


<div class="">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"> Periodo Turno Validacion</h3>
      </div>
        <div class="panel-body" style="overflow: auto;" >


                <table class="table table-bordered">
                  <tr>
                    <th style="text-align: center;" rowspan="2" > Campaña </th>
                    <th style="text-align: center;" rowspan="2"> Turno </th>
                    <th style="text-align: center;" class="dropdown" colspan="16">
                      
                      <span>
                      <!-- envia la fecha a la funcion fechamenos() en operacionController-->
                        <a href="{{ url('reportetipi/'.$fecha) }}" class="left" role="button" data-slide="prev">
                          <span class="glyphicon glyphicon-chevron-left"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                      </span>
                      
                      <span style="font-size: 18px"> {{$fecha}} </span>
                      
                      <span>
                      <!-- envia la fecha a la funcion fechamas() en operacionController-->                      
                        <a href="{{ url('reporteetipi/'.$fecha) }}" class="right" role="button" data-slide="next">
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
                    <th style="text-align: center; font-size: 12px"> {{$valores[0] -> turno}} </th>
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'BuzÃ³n de voz')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach

                  <!--  @foreach($valores as $valor)
                      @if($valor -> cod == 'DN gestionado por otro Call Center')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                        <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach

                    @foreach($valores as $valor)
                      @if($valor -> cod == 'DN Lista Negra')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'Llamar despuÃ©s')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'Lo pensarÃ¡')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach

                    @foreach($valores as $valor)
                      @if($valor -> cod == 'No contesta')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'No es Titular')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'No le interesa')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'Problemas MarcaciÃ³n')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'Recarga Fija')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'Rechaza Oferta')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'Renta Fija')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'Renta Movil')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'Se corta llamada')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'Tono Ocupado')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach
                    
                    @foreach($valores as $valor)
                      @if($valor -> cod == 'Transferencia a ValidaciÃ³n')
                        <th style="text-align: center; font-size: 12px"> {{$valor -> total}}  </th>
                      @else
                          <th style="text-align: center; font-size: 12px"> 0 </th>
                      @endif
                    @endforeach

                    -->

                  </tr>

                </table>
              </div>

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
