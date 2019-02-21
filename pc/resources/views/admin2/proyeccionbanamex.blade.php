@extends($menu)
@section('content')

<style media="screen">


table{
  table-layout: fixed;
}
table .tit{
  width: 120px;
  overflow: auto;
}
table .tit2{
  width: 80px;
  overflow: auto;
}
table td {
  /*border: 1px solid;*/
  border-style: outset;
}

table th {
  /*border: 1px solid;*/
  border-style: outset;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}
</style>

<div class="row">
    <div class="col-md-12 ">
      <div class="panel panel-info">

        <div class="panel-heading">
          <div class="row">
            <h3 class="col-lg-2">
              Banamex

              <select class="form-control" id="select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                <option value="{{URL('/direccion/proyeccion/banamex')}}/{{date('Y-m-d')}}"></option>
                @foreach($rfechas as $value)
                <option value="{{URL('/direccion/proyeccion/banamex')}}/{{$value->a}}-{{$value->m}}-{{date('d')}}">{{$value->a}}-{{$value->m}}</option>
                @endforeach
              </select>

            </h3>
          </div>
        </div>

        <div class="panel-body">



          <!-- Prepago -->
          <div id="myTabContent" class="tab-content span3 ">

            <div class="tab-pane fade active in" id="home">
              <table class="table ">
                <thead>
                  <tr>
                    <th class="tit" >Metas</th>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $end_date=$ff /*--}}
                    {{--*/ $color1='black' /*--}}
                    {{--*/ $color2='black' /*--}}
                    {{--*/ $prom_Mat=1 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))
                      <th style=" text-align: center; " > {{ date('d', strtotime($date)) }}</th>
                      {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                    @endwhile
                    <th class="tit2" > Total </th>
                  </tr>
                </thead>
                <tbody>

                  <!-- Posiciones -->
                  <tr class="info">
                    <td >Posiciones por día (Mat)</td>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $tot = 0/*--}}
                    {{--*/ $dias = 0/*--}}
                    {{--*/ $cont_pos_mat = 0 /*--}}
                    {{--*/ $cont_pos_mat_div = 0 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))
                    {{--*/ $pp= array_key_exists($date, $tmpreposm) ? $tmpreposm[$date] : 0 /*--}}
                    {{--*/ $pr= array_key_exists($date, $pmr) ? $pmr[$date] : 0 /*--}}
                    {{--*/ $color='black'; $calc=0;
                    if($pp!=0){
                      $calc= round(($pr/$pp)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }

                      if($pp != 0){
                          $dias = $dias+1;
                      }
                      $tot = $tot + $pp;


                    } /*--}}
                      <td >
                        <input type="number" id="tmpreposm{{$date}}" onchange="tmpreposgen(this.id)" value="{{ $pp }}"  style="color: {{$color}};width: 40px; background-color:transparent; border-color:transparent;">
                        <div id="tmpreposm{{$date}}2" >
                          <span class="badge" style="background-color:{{$color}};">{{ $pr }}</span>
                          <span class="badge" style="background-color:{{$color}};">{{ $calc }} %</span>
                        </div>
                      </td>
                      {{--*/
                        $cont_pos_mat+=$pr;
                        if($pr!=0){
                          $cont_pos_mat_div++;
                        }
                        /*--}}

                      {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                    @endwhile
                    <td>
                        {{ round(($tot/$dias), 2) }}
                        {{--*/
                          if($cont_pos_mat_div!=0){
                            $calc= round(($cont_pos_mat/$cont_pos_mat_div) ,0);
                            if ($calc < 80){
                            $color1= 'red';
                            }
                            elseif($calc > 90){
                              $color1='green';
                            }
                            else{
                            $color1='orange';
                            }
                            $prom_Mat=round((round($cont_pos_mat/$cont_pos_mat_div,2)*100)/round(($tot/$dias), 2),2);
                            if ($prom_Mat < 80){
                            $color2= 'red';
                            }
                            elseif($prom_Mat > 90){
                              $color2='green';
                            }
                            else{
                            $color2='orange';
                            }
                          }
                          /*--}}
                        <div id="tmpreposm{{$date}}2" >
                          <span class="badge" style="background-color:{{$color1}};">{{ $cont_pos_mat_div!=0?round($cont_pos_mat/$cont_pos_mat_div,2):0 }}</span><br>
                          <span class="badge" style="background-color:{{$color2}};">{{ $prom_Mat }} %</span>
                        </div>
                    </td>

                  </tr>

                  <tr class="info">
                    <td>Posiciones por día (Ves)</td>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $tot = 0/*--}}
                    {{--*/ $dias = 0/*--}}
                    {{--*/ $cont_pos_mat = 0 /*--}}
                    {{--*/ $cont_pos_mat_div = 0 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))
                    {{--*/ $pp= array_key_exists($date, $tmpreposv) ? $tmpreposv[$date] : 0 /*--}}
                    {{--*/ $pr= array_key_exists($date, $pvr) ? $pvr[$date] : 0 /*--}}
                    {{--*/ $color='black'; $calc=0;
                    if($pp!=0){
                      $calc= round(($pr/$pp)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }
                      if($pp != 0){
                          $dias += 1;
                      }
                      $tot = $tot + $pp;
                    } /*--}}
                      <td >
                        <input type="number" id="tmpreposv{{$date}}" value="{{$pp}}"  onchange="tmpreposgen(this.id)" style="color: {{$color}}; width: 40px; background-color:transparent; border-color:transparent;">
                        <div id="tmpreposv{{$date}}2" >
                          <span class="badge" style="background-color:{{$color}};">{{ $pr }}</span>
                          <span class="badge" style="background-color:{{$color}};">{{ $calc }} %</span>
                        </div>
                      </td>
                      {{--*/
                        $cont_pos_mat+=$pr;
                        if($pr!=0){
                          $cont_pos_mat_div++;
                        }
                        /*--}}
                      {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}

                    @endwhile
                    <td>
                       {{ round(($tot/$dias), 2) }}
                        {{--*/
                          if($cont_pos_mat_div!=0){
                            $calc= round(($cont_pos_mat/$cont_pos_mat_div) ,0);
                            if ($calc < 80){
                            $color1= 'red';
                            }
                            elseif($calc > 90){
                              $color1='green';
                            }
                            else{
                            $color1='orange';
                            }
                            $prom_Mat=round((round($cont_pos_mat/$cont_pos_mat_div,2)*100)/round(($tot/$dias), 2),2);
                            if ($prom_Mat < 80){
                            $color2= 'red';
                            }
                            elseif($prom_Mat > 90){
                              $color2='green';
                            }
                            else{
                            $color2='orange';
                            }
                          }
                          /*--}}
                        <div id="tmpreposm{{$date}}2" >
                          <span class="badge" style="background-color:{{$color1}};">{{ $cont_pos_mat_div!=0?round($cont_pos_mat/$cont_pos_mat_div,2):0 }}</span><br>
                          <span class="badge" style="background-color:{{$color2}};">{{ $prom_Mat }} %</span>
                        </div>
                       </td>
                  </tr>

                  <tr class="info">
                    <td>Posiciones por día (Gen)</td>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $tot = 0/*--}}
                    {{--*/ $dias = 0/*--}}
                    {{--*/ $cont_pos_mat = 0 /*--}}
                    {{--*/ $cont_pos_mat_div = 0 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))
                    {{--*/ $ppm= array_key_exists($date, $pmr) ? $pmr[$date] : 0 /*--}}
                    {{--*/ $ppv= array_key_exists($date, $pvr) ? $pvr[$date] : 0 /*--}}
                    {{--*/ $pp= array_key_exists($date, $tmpreposg) ? $tmpreposg[$date] : 0 /*--}}
                    {{--*/ $pr= round(($ppm + $ppv) / 2 ,0) /*--}}

                    {{--*/ $color='black'; $calc=0;
                    if($pp!=0){
                      $calc= round(($pr/$pp)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }
                      if($pp != 0){
                          $dias += 1;
                      }
                      $tot = $tot + $pp;

                    } /*--}}

                      <td>
                        <input type="text" id="tmpreposg{{$date}}" value="{{$pp}}"  style="color: {{$color}}; width: 40px; background-color:transparent; border-color:transparent;" readonly>
                        <div id="tmpreposg{{$date}}2">
                          <span class="badge" style="background-color:{{$color}};">{{ $pr }}</span>
                          <span class="badge" style="background-color:{{$color}};">{{ $calc }} %</span>
                        </div>
                      </td>
                      {{--*/
                        $cont_pos_mat+=$pr;
                        if($pr!=0){
                          $cont_pos_mat_div++;
                        }
                        /*--}}
                      {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                    @endwhile
                    <td> {{ round(($tot/$dias), 2) }}
                      {{--*/
                        if($cont_pos_mat_div!=0){
                          $calc= round(($cont_pos_mat/$cont_pos_mat_div) ,0);
                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }
                          $prom_Mat=round((round($cont_pos_mat/$cont_pos_mat_div,2)*100)/round(($tot/$dias), 2),2);
                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /*--}}
                      <div id="tmpreposm{{$date}}2" >
                        <span class="badge" style="background-color:{{$color1}};">{{ $cont_pos_mat_div!=0?round($cont_pos_mat/$cont_pos_mat_div,2):0 }}</span><br>
                        <span class="badge" style="background-color:{{$color2}};">{{ $prom_Mat }} %</span>
                      </div>
                  </td>
                  </tr>

                  <!-- VPH -->

                <tr class="success">
                    <td>VPH por día (Mat)</td>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $tot = 0/*--}}
                    {{--*/ $dias = 0/*--}}
                    {{--*/ $cont_pos_mat = 0 /*--}}
                    {{--*/ $cont_pos_mat_div = 0 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))
                    {{--*/ $pm= array_key_exists($date, $pmr) ? $pmr[$date] : 0 /*--}}
                    {{--*/ $vm= array_key_exists($date, $vmr) ? $vmr[$date] : 0 /*--}}
                    {{--*/
                        $vphp= array_key_exists($date, $tmprevphm) ? $tmprevphm[$date] : 0;
                        $color='black'; $calc=0; $vph=0;
                        if($vphp!=0 && $pm !=0){
                            $vph= round(($vm / ($pm*6)), 2);
                            $calc= round(($vph/$vphp)*100 ,0);
                            if ($calc < 80){
                            $color= 'red';
                            }elseif($calc > 90){
                                $color='green';
                            }else{
                            $color='orange';
                            }


                        }
                        $tot = $tot + $vphp;
                        if($vphp != 0){
                            $dias += 1;
                        }
                /*--}}
                      <td>
                        <input type="float" id="tmprevphm{{$date}}" onchange="tmprevphgen(this.id)" value="{{$vphp}}"  style="color: {{$color}}; width: 40px; background-color:transparent; border-color:transparent;">
                        <div id="tmprevphm{{$date}}2" >
                          <span class="badge" style="background-color:{{$color}};">{{ $vph }}</span>
                          <span class="badge" style="background-color:{{$color}};">{{ $calc }} %</span>
                        </div>
                      </td>
                      {{--*/
                        $cont_pos_mat+=$vph;
                        if($vph!=0){
                          $cont_pos_mat_div++;
                        }
                        /*--}}

                      {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}

                    @endwhile
                    <td> {{ round(($tot/$dias), 2) }}
                      {{--*/
                        if($cont_pos_mat_div!=0){

                          $calc1= ($cont_pos_mat/$cont_pos_mat_div);

                          $calc= (($calc1/round(($tot/$dias)*100, 2)*100))*100;
                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }
                          $prom_Mat=round((round($cont_pos_mat/$cont_pos_mat_div,2)*100)/round(($tot/$dias), 2),2);
                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /*--}}
                      <div id="tmpreposm{{$date}}2" >
                        <span class="badge" style="background-color:{{$color1}};">{{ $cont_pos_mat_div!=0?round($cont_pos_mat/$cont_pos_mat_div,2):0 }}</span><br>
                        <span class="badge" style="background-color:{{$color2}};">{{ $prom_Mat }} %</span>
                      </div>
                  </td>
                </tr>

                <tr class="success">
                    <td>VPH por día (Ves)</td>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $tot = 0/*--}}
                    {{--*/ $dias = 0/*--}}
                    {{--*/ $cont_pos_mat = 0 /*--}}
                    {{--*/ $cont_pos_mat_div = 0 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))
                        {{--*/ $pm = array_key_exists($date, $pvr) ? $pvr[$date] : 0 /*--}}
                        {{--*/ $vm = array_key_exists($date, $vvr) ? $vvr[$date] : 0 /*--}}

                        {{--*/
                            $vphv= array_key_exists($date, $tmprevphv) ? $tmprevphv[$date] : 0;
                            $color='black'; $calc=0; $vph=0;
                            if($vphv!=0 && $pm !=0 ){
                                $vph= round(($vm / ($pm*6)), 2);
                                $calc= round(($vph/$vphv)*100, 0);
                                if ($calc <80){
                                $color = 'red';
                                }elseif($calc > 90){
                                    $color='green';
                                }else{
                                $color='orange';
                                }
                            }

                            $tot = $tot + (array_key_exists($date, $tmprevphv) ? $tmprevphv[$date] : 0);
                            if((array_key_exists($date, $tmprevphv) ? $tmprevphv[$date] : 0) != 0){
                                    $dias += 1;
                            }
                        /*--}}
                        <td style="text-align: center;">
                            <input type="float" id="tmprevphv{{$date}}" value="{{array_key_exists($date, $tmprevphv) ? $tmprevphv[$date] : 0}}"  onchange="tmprevphgen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;">
                            <div id="tmprevphv{{$date}}2">
                                <span class="badge" style="background-color: {{$color}};"> {{ $vph }} </span>
                                <span class="badge" style="background-color: {{$color}};"> {{$calc}}%</span>
                            </div>
                        </td>
                        {{--*/
                          $cont_pos_mat+=$vph;
                          if($vph!=0){
                            $cont_pos_mat_div++;
                          }
                          /*--}}
                        {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                    @endwhile
                    <td> {{ round(($tot/$dias), 2) }}
                      {{--*/
                        if($cont_pos_mat_div!=0){

                          $calc1= ($cont_pos_mat/$cont_pos_mat_div);

                          $calc= (($calc1/round(($tot/$dias)*100, 2)*100))*100;
                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }
                          $prom_Mat=round((round($cont_pos_mat/$cont_pos_mat_div,2)*100)/round(($tot/$dias), 2),2);
                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /*--}}
                      <div id="tmpreposm{{$date}}2" >
                        <span class="badge" style="background-color:{{$color1}};">{{ $cont_pos_mat_div!=0?round($cont_pos_mat/$cont_pos_mat_div,2):0 }}</span><br>
                        <span class="badge" style="background-color:{{$color2}};">{{ $prom_Mat }} %</span>
                      </div>
                  </td>
                </tr>

                  <tr class="success">
                    <td>VPH por día (Gen)</td>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $tot = 0/*--}}
                    {{--*/ $dias = 0/*--}}
                    {{--*/ $cont_pos_mat = 0 /*--}}
                    {{--*/ $cont_pos_mat_div = 0 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))
                        {{--*/ $pm= array_key_exists($date, $pmr) ? $pmr[$date] : 0 /*--}}
                        {{--*/ $vm= array_key_exists($date, $vmr) ? $vmr[$date] : 0 /*--}}

                        {{--*/ $pm2 = array_key_exists($date, $pvr) ? $pvr[$date] : 0 /*--}}
                        {{--*/ $vm2 = array_key_exists($date, $vvr) ? $vvr[$date] : 0 /*--}}
                        {{--*/
                            $vph_p=array_key_exists($date, $tmprevphg) ? $tmprevphg[$date] : 0;
                            $vphp= array_key_exists($date, $tmprevphm) ? $tmprevphm[$date] : 0;
                            $vphv= array_key_exists($date, $tmprevphv) ? $tmprevphv[$date] : 0;
                            $color='black'; $calc=0; $vph=0; $vphpromedio=0; $alcance=0;
                            if($pm!=0 && $pm2!=0 && $vph_p!=0){
                                $vph= round(($vm / ($pm*6)), 2);

                                $vph2= round(($vm2 / ($pm2*6)), 2);

                                $vphpromedio = round((($vph+$vph2)/2),2);
                                $alcance=  round(($vphpromedio / $vph_p) *100,0) ;

                                if ($alcance < 80){
                                $color = 'red';
                                }elseif($alcance > 90){
                                    $color='green';
                                }else{
                                    $color='orange';
                                }
                            }
                            if(array_key_exists($date, $tmprevphg) ? $tmprevphg[$date] : 0 != 0){
                                $dias += 1;
                            }
                            $tot = $tot + (array_key_exists($date, $tmprevphg) ? $tmprevphg[$date] : 0);
                        /*--}}

                      <td style="text-align: center;">
                        <input type="float" id="tmprevphg{{$date}}" value="{{ $vph_p }}"  onchange="tmprevphgen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;" >
                        <span class="badge" style="background-color: {{$color}};"> {{$vphpromedio}}</span>
                        <span class="badge" style="background-color: {{$color}};"> {{$alcance}} %</span>
                      </td>
                      {{--*/
                        $cont_pos_mat+=$vphpromedio;
                        if($vph!=0){
                          $cont_pos_mat_div++;
                        }
                        /*--}}
                      {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                    @endwhile
                    <td> {{ round(($tot/$dias), 2) }}
                      {{--*/
                        if($cont_pos_mat_div!=0){

                          $calc1= ($cont_pos_mat/$cont_pos_mat_div);

                          $calc= (($calc1/round(($tot/$dias)*100, 2)*100))*100;
                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }
                          $prom_Mat=round((round($cont_pos_mat/$cont_pos_mat_div,2)*100)/round(($tot/$dias), 2),2);
                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /*--}}
                        <div id="tmpreposm{{$date}}2" >
                          <span class="badge" style="background-color:{{$color1}};">{{ $cont_pos_mat_div!=0?round($cont_pos_mat/$cont_pos_mat_div,2):0 }}</span><br>
                          <span class="badge" style="background-color:{{$color2}};">{{ $prom_Mat }} %</span>
                        </div>
                      </td>
                  </tr>

                  <!-- Ventas -->
                  <tr class="danger">
                    <td>Ventas por día (Mat)</td>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $tot = 0/*--}}
                    {{--*/ $dias = 0/*--}}
                    {{--*/ $cont_pos_mat = 0 /*--}}
                    {{--*/ $cont_pos_mat_div = 0 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))
                    {{--*/ $vp= array_key_exists($date, $tmprevenm) ? $tmprevenm[$date] : 0 /*--}}
                    {{--*/ $vr= array_key_exists($date, $vmr) ? $vmr[$date] : 0 /*--}}
                    {{--*/ $color='black'; $calc=0;
                    if($vp!=0){
                      $calc= round(($vr/$vp)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }

                      $tot = $tot + $vp;
                    } /*--}}
                      <td>
                        <input type="number" id="tmprevenm{{$date}}" onchange="tmprevengen(this.id)" value="{{$vp}}"  style="color: {{$color}}; width: 40px; background-color:transparent; border-color:transparent;">
                        <div id="tmprevenm{{$date}}2" >
                          <span class="badge" style="background-color:{{$color}};">{{ $vr }} </span>
                          <span class="badge" style="background-color:{{$color}};">{{ $calc }} %</span>
                        </div>
                      </td>
                      {{--*/
                        $cont_pos_mat+=$vr;
                        if($vr!=0){
                          $cont_pos_mat_div++;
                        }
                        /*--}}
                      {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                    @endwhile
                    <td> {{ $tot }}
                      {{--*/
                        $color='black'; $calc=0;
                        if($cont_pos_mat_div!=0){
                          $calc= round(($cont_pos_mat/$tot)*100 ,0);

                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }

                          $prom_Mat=round(((($cont_pos_mat/$tot)*100 /$tot)*100)*100,2) ;
                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /*--}}


                      <div id="tmpreposm{{$date}}2" >
                        <span class="badge" style="background-color:{{$color1}};">{{ $cont_pos_mat}}</span><br>
                        <span class="badge" style="background-color:{{$color2}};">{{ $prom_Mat }} %</span>
                      </div>
                    </td>
                  </tr>

                  <tr class="danger">
                    <td>Ventas por día (Ves)</td>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $tot = 0/*--}}
                    {{--*/ $cont_pos_mat = 0 /*--}}
                    {{--*/ $cont_pos_mat_div = 0 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))
                    {{--*/ $vp= array_key_exists($date, $tmprevenv) ? $tmprevenv[$date] : 0 /*--}}
                    {{--*/ $vr= array_key_exists($date, $vvr) ? $vvr[$date] : 0 /*--}}
                    {{--*/ $color='black'; $calc=0;
                    if($vp!=0){
                      $calc= round(($vr/$vp)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }
                      $tot = $tot + $vp;
                    } /*--}}
                      <td>
                        <input type="number" id="tmprevenv{{$date}}" value="{{$vp}}"  onchange="tmprevengen(this.id)" style="color: {{$color}}; width: 40px; background-color:transparent; border-color:transparent;">
                        <div id="tmprevenv{{$date}}2" >
                          <span class="badge" style="background-color:{{$color}};">{{ $vr }}</span>
                          <span class="badge" style="background-color:{{$color}};">{{ $calc }} %</span>
                        </div>
                      </td>
                      {{--*/
                        $cont_pos_mat+=$vr;
                        if($vr!=0){
                          $cont_pos_mat_div++;
                        }
                        /*--}}
                      {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                    @endwhile
                    <td> {{ $tot }}
                      {{--*/
                        $color='black'; $calc=0;
                        if($cont_pos_mat_div!=0){
                          $calc= round(($cont_pos_mat/$tot)*100 ,0);

                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }

                          $prom_Mat=round(((($cont_pos_mat/$tot)*100 /$tot)*100)*100,2) ;
                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /*--}}


                      <div id="tmpreposm{{$date}}2" >
                        <span class="badge" style="background-color:{{$color1}};">{{ $cont_pos_mat}}</span><br>
                        <span class="badge" style="background-color:{{$color2}};">{{ $prom_Mat }} %</span>
                      </div>
                    </td>

                  </tr>

                  <tr class="danger">
                    <td>Ventas por día (Gen)</td>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $tot = 0/*--}}
                    {{--*/ $cont_pos_mat = 0 /*--}}
                    {{--*/ $cont_pos_mat_div = 0 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))

                    {{--*/ $pm= array_key_exists($date, $pmr) ? $pmr[$date] : 0 /*--}}
                    {{--*/ $vm= array_key_exists($date, $vmr) ? $vmr[$date] : 0 /*--}}

                    {{--*/ $pm2 = array_key_exists($date, $pvr) ? $pvr[$date] : 0 /*--}}
                    {{--*/ $vm2 = array_key_exists($date, $vvr) ? $vvr[$date] : 0 /*--}}
                    {{--*/
                        $ven_p=array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0;
                        $venp= array_key_exists($date, $tmprevenm) ? $tmprevenm[$date] : 0;
                        $venv= array_key_exists($date, $tmprevenv) ? $tmprevenv[$date] : 0;
                        $color='black'; $calc=0; $ven=0; $venpromedio=0; $alcance=0;
                        if($ven_p!=0 && $vm2!=0){

                            $venpromedio = round((($vm+$vm2)),2);
                            $alcance=  round(($venpromedio / $ven_p) *100,0) ;

                            if ($alcance < 80){
                            $color = 'red';
                            }elseif($alcance > 90){
                                $color='green';
                            }else{
                                $color='orange';
                            }
                        }
                        if(array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0 != 0){
                            $dias += 1;
                        }
                        $tot = $tot + (array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0);
                    /*--}}

                      <td style="text-align: center;">
                        <input type="text" id="tmpreveng{{$date}}" value="{{array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0}}"  style="width: 40px; background-color:transparent; border-color:transparent;" readonly>
                        <div id="tmprevenv{{$date}}2" >
                          <span class="badge" style="background-color:{{$color}};">{{ $venpromedio }}</span>
                          <span class="badge" style="background-color:{{$color}};">{{ $alcance }} %</span>
                        </div>
                      </td>

                      {{--*/
                        $cont_pos_mat+=$venpromedio;
                        if($venpromedio!=0){
                          $cont_pos_mat_div++;
                        }
                        /*--}}
                      {{--*/ $tot = $tot + (array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0); /*--}}
                      {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}

                    @endwhile
                    <td> {{ $tot }}

                      {{--*/
                        $color='black'; $calc=0;
                        if($cont_pos_mat_div!=0){
                          $calc= round(($cont_pos_mat/$tot)*100 ,0);

                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }

                          $prom_Mat=round(($calc/$tot)*100,2);

                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /*--}}
                        
                        <div id="tmpreposm{{$date}}2" >
                            <span class="badge" style="background-color:{{$color1}};">{{ $cont_pos_mat}}</span><br>
                            <span class="badge" style="background-color:{{$color2}};">{{ $prom_Mat }} %</span>
                        </div>
                    </td>
                  </tr>
                        
                       <!-- % de autenticacion  -->
                    <tr class="warning">
                        <td>% de Autenticacion (Mat)</td>
                        {{--*/ $date=$fi /*--}}
                        {{--*/ $tot1 = 0 /*--}}
                        {{--*/ $tot2 = 0 /*--}}
                        {{--*/ $tot3 = 0 /*--}}
                        {{--*/ $contador = 0 /*--}}


                        @while (strtotime($date) <= strtotime($end_date))
                        {{--*/ $rechazosp= array_key_exists($date, $tmprerechm) ? $tmprerechm[$date] : 0 /*--}}
                        {{--*/ $rechazos= array_key_exists($date, $rechazos_mat) ? $rechazos_mat[$date] : 0 /*--}}
                        {{--*/ $color='black'; $calc=0;
                        if($rechazosp!=0){
                          $calc= round(($rechazos/$rechazosp)*100 ,0);
                          if ($calc > 100){
                          $color= 'red';
                          }
                          else{
                          $color='green';
                          }

                          $contador += 1;
                          $tot1 += $rechazosp;
                          $tot2 += $rechazos;
                          $tot3 += $calc;

                        } /*--}}
                        <td style="text-align: center;">
                          <input type="float" id="tmprerechm{{$date}}" onchange="tmprerechgen(this.id)" value="{{$rechazosp}}"
                          style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                          <div id="tmprerechm{{$date}}2" >
                            <span class="badge" style="background-color:{{$color}};">{{ $rechazos}}</span><br>
                            <span class="badge" style="background-color:{{$color}};">{{ $calc }} %</span>
                          </div>
                        </td>
                        {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                        @endwhile
                        <td>
                            <div>
                              <span> {{ round($tot1/$contador,2) }} %</span><br>
                              <span class="badge" style="background-color:{{$color}};">{{ round($tot2/$contador,2) }} %</span>
                              <span class="badge" style="background-color:{{$color}};">{{ round($tot3/$contador,2) }} %</span>
                            </div>
                        </td>
                    </tr>

                    <tr class="warning">
                        <td>% de Autenticacion (Ves)</td>
                        {{--*/ $date=$fi /*--}}
                        {{--*/ $tot1 = 0 /*--}}
                        {{--*/ $tot2 = 0 /*--}}
                        {{--*/ $tot3 = 0 /*--}}
                        {{--*/ $contador = 0 /*--}}

                        @while (strtotime($date) <= strtotime($end_date))
                            {{--*/ $rechazosp= array_key_exists($date, $tmprerechv) ? $tmprerechv[$date] : 0 /*--}}
                            {{--*/ $rechazos= array_key_exists($date, $rechazos_ves) ? $rechazos_ves[$date] : 0 /*--}}
                            {{--*/ $color='black'; $calc=0;
                            if($rechazosp!=0){
                              $calc= round(($rechazos/$rechazosp)*100 ,0);
                              if ($calc > 100){
                                $color= 'red';
                              }else{
                                $color='green';
                              }
                              $contador += 1;
                              $tot1 += $rechazosp;
                              $tot2 += $rechazos;
                              $tot3 += $calc;

                            } /*--}}
                            <td style="text-align: center;">
                            <input type="float" id="tmprerechv{{$date}}" value="{{$rechazosp}}"  onchange="tmprerechgen(this.id)" style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                            <div id="tmprerechv{{$date}}2" >
                              <span class="badge" style="background-color:{{$color}};">{{ $rechazos}}</span><br>
                              <span class="badge" style="background-color:{{$color}};">{{ $calc }} %</span>
                            </div>
                            </td>
                            {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                        @endwhile
                        <td>
                            <div>
                              <span> {{ round($tot1/$contador,2) }} %</span><br>
                              <span class="badge" style="background-color:{{$color}};">{{ round($tot2/$contador,2) }} %</span>
                              <span class="badge" style="background-color:{{$color}};">{{ round($tot3/$contador,2) }} % </span>
                            </div>
                        </td>
                    </tr>

                    <tr class="warning">
                        <td>% de Autenticacion (Gen)</td>
                        {{--*/ $date=$fi /*--}}
                        {{--*/ $tot1 = 0 /*--}}
                        {{--*/ $tot2 = 0 /*--}}
                        {{--*/ $tot3 = 0 /*--}}
                        {{--*/ $contador = 0 /*--}}

                        @while (strtotime($date) <= strtotime($end_date))

                        {{--*/ $rechazosp= array_key_exists($date, $tmprerechg) ? $tmprerechg[$date] : 0 /*--}}
                        {{--*/ $rechazos= ((array_key_exists($date, $rechazos_mat) ? $rechazos_mat[$date] : 0) + (array_key_exists($date, $rechazos_ves) ? $rechazos_ves[$date] : 0)) / 2 /*--}}
                        {{--*/ $color='black'; $calc=0;
                        if($rechazosp!=0){
                          $calc= round(($rechazos/$rechazosp)*100 ,0);
                          if ($calc > 100){
                          $color= 'red';
                          }else{
                          $color='green';
                          }
                          $contador += 1;
                          $tot1 += $rechazosp;
                          $tot2 += $rechazos;
                          $tot3 += $calc;

                        } /*--}}

                        <td style="text-align: center;">
                          <input type="float" id="tmprerechg{{$date}}" onchange="tmprerechgen(this.id)"
                          value="{{$rechazosp}}"
                          style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%

                          <div id="tmprerechg{{$date}}2" >
                            <span class="badge" style="background-color:{{$color}};">{{ $rechazos}}</span><br>
                            <span class="badge" style="background-color:{{$color}};">{{ $calc }} %</span>
                          </div>

                        </td>
                        {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                        @endwhile
                        <td>
                          <div>
                            <span> {{ round($tot1/$contador,2) }} %</span><br>
                            <span class="badge" style="background-color:{{$color}};">{{ round($tot2/$contador,2) }} %</span>
                            <span class="badge" style="background-color:{{$color}};">{{ round($tot3/$contador,2) }} %</span>
                          </div>
                        </td>
                    </tr>

                    
                    <!-- % de Aprobacion -->
                    
                     <tr class="info">
                    <td>% de aprobacion (Mat)</td>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $tot1 = 0 /*--}}
                    {{--*/ $tot2 = 0 /*--}}
                    {{--*/ $tot3 = 0 /*--}}
                    {{--*/ $contador = 0 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))
                    {{--*/ $recuperado= round(array_key_exists($date, $recuperado_mat) ? $recuperado_mat[$date] : 0,0) /*--}}
                    {{--*/ $recuperado_pronostico= array_key_exists($date, $tmprerecum) ? $tmprerecum[$date] : 0 /*--}}
                    {{--*/ $color='black'; $calc=0;
                    if($recuperado_pronostico!=0){
                      $calc= round(($recuperado/$recuperado_pronostico)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }

                      $contador += 1;
                      $tot1 += $recuperado_pronostico;
                      $tot2 += $recuperado;
                      $tot3 += $calc;

                    }

                    /*--}}
                      <td style="text-align: center;">
                        <input type="float" id="tmprerecum{{$date}}" onchange="tmprerecugen(this.id)" value="{{$recuperado_pronostico}}"  style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                        <div id="tmprevenm{{$date}}2" >
                          <span class="badge" style="background-color:{{$color}};">{{ $recuperado }} %</span>
                          <span class="badge" style="background-color:{{$color}};">{{ $calc }} %</span>
                        </div>
                      </td>
                      {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                    @endwhile
                    <td>
                        <div>
                          <span> {{ round($tot1/$contador,2) }} %</span><br>
                          <span class="badge" style="background-color:{{$color}};">{{ round($tot2/$contador,2) }} %</span>
                          <span class="badge" style="background-color:{{$color}};">{{ round($tot3/$contador,2) }} %</span>
                        </div>
                    </td>
                  </tr>

                  <tr class="info">
                    <td>% de Aprobacion (Ves)</td>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $tot1 = 0 /*--}}
                    {{--*/ $tot2 = 0 /*--}}
                    {{--*/ $tot3 = 0 /*--}}
                    {{--*/ $contador = 0 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))
                    {{--*/ $recuperado= round(array_key_exists($date, $recuperado_ves) ? $recuperado_ves[$date] : 0,0) /*--}}
                    {{--*/ $recuperado_pronostico= array_key_exists($date, $tmprerecuv) ? $tmprerecuv[$date] : 0 /*--}}
                    {{--*/ $color='black'; $calc=0;
                    if($recuperado_pronostico!=0){
                      $calc= round(($recuperado/$recuperado_pronostico)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }

                      $contador += 1;
                      $tot1 += $recuperado_pronostico;
                      $tot2 += $recuperado;
                      $tot3 += $calc;

                    }

                    /*--}}
                      <td style="text-align: center;">
                        <input type="float" id="tmprerecuv{{$date}}" onchange="tmprerecugen(this.id)" value="{{$recuperado_pronostico}}"  style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                        <div id="tmprevenm{{$date}}2" >
                          <span class="badge" style="background-color:{{$color}};">{{ $recuperado }} %</span>
                          <span class="badge" style="background-color:{{$color}};">{{ $calc }} %</span>
                        </div>
                      </td>
                      {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                    @endwhile
                    <td>
                        <div>
                          <span> {{ round($tot1/$contador,2) }} %</span><br>
                          <span class="badge" style="background-color:{{$color}};">{{ round($tot2/$contador,2) }} %</span>
                          <span class="badge" style="background-color:{{$color}};">{{ round($tot3/$contador,2) }} %</span>
                        </div>
                    </td>
                  </tr>


                  <tr class="info">
                    <td>% Aprobacion (Gen)</td>
                    {{--*/ $date=$fi /*--}}
                    {{--*/ $tot1 = 0 /*--}}
                    {{--*/ $tot2 = 0 /*--}}
                    {{--*/ $tot3 = 0 /*--}}
                    {{--*/ $contador = 0 /*--}}

                    @while (strtotime($date) <= strtotime($end_date))

                    {{--*/ $rechazosp= array_key_exists($date, $tmprerecug) ? $tmprerecug[$date] : 0 /*--}}
                    {{--*/ $rechazos= round(((array_key_exists($date, $recuperado_mat) ? $recuperado_mat[$date] : 0) + (array_key_exists($date, $recuperado_ves) ? $recuperado_ves[$date] : 0)) / 2,0) /*--}}
                    {{--*/ $color='black'; $calc=0;
                    if($rechazosp!=0){
                      $calc= round(($rechazos/$rechazosp)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }

                      $contador += 1;
                      $tot1 += $rechazosp;
                      $tot2 += $rechazos;
                      $tot3 += $calc;

                    } /*--}}

                      <td style="text-align: center;">
                        <input type="float" id="tmprerecug{{$date}}" onchange="tmprerecugen(this.id)"
                        value="{{$rechazosp}}"
                        style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%

                        <div id="tmprerecug{{$date}}2" >
                          <span class="badge" style="background-color:{{$color}};">{{ $rechazos}} %</span><br>
                          <span class="badge" style="background-color:{{$color}};">{{ $calc }} %</span>
                        </div>

                      </td>
                      {{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /*--}}
                    @endwhile
                    <td>
                        <div>
                          <span> {{ round($tot1/$contador,2) }} %</span><br>
                          <span class="badge" style="background-color:{{$color}};">{{ round($tot2/$contador,2) }} %</span>
                          <span class="badge" style="background-color:{{$color}};">{{ round($tot3/$contador,2) }} %</span>
                        </div>
                    </td>
                  </tr>          
                    
                    
                    
                    

                    
                  
                </tbody>
              </table>
            </div>

          </div>
          <!-- <button type="button" name="button" class="btn btn-success" id="guardar" >Aplicar cambios</button> -->


        </div>
      </div>
    </div>
  </div>


@stop

@section('content2')
<script type="text/javascript">
function tmpreposgen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmpreposg" + id.substr(id.length - 10);
  var idmat = "#tmpreposm" + id.substr(id.length - 10);
  var idves = "#tmpreposv" + id.substr(id.length - 10);
  var val= parseInt( (parseInt($(idmat).val()) + parseInt($(idves).val()))/2 );
  act(fecha,"banamex","pos",parseInt($(idmat).val()),"m");
  act(fecha,"banamex","pos",parseInt($(idves).val()),"v");
  act(fecha,"banamex","pos",val,"g");
  $(idgen).val( val );

  // calcula ventas
  var idvengen = "#tmpreveng" + id.substr(id.length - 10);
  var idvenmat = "#tmprevenm" + id.substr(id.length - 10);
  var idvenves = "#tmprevenv" + id.substr(id.length - 10);

  var idvphgen = "#tmprevphg" + id.substr(id.length - 10);
  var idvphmat = "#tmprevphm" + id.substr(id.length - 10);
  var idvphves = "#tmprevphv" + id.substr(id.length - 10);

  $(idvenmat).val( (parseInt($(idmat).val()) * 6) *  parseFloat( $(idvphmat).val()) );
  $(idvenves).val( (parseInt($(idves).val()) * 6) *  parseFloat( $(idvphves).val()) );
  $(idvengen).val( parseInt($(idvenmat).val()) + parseInt($(idvenves).val()) );

  act(fecha,"banamex","ven",parseInt($(idvenmat).val()),"m");
  act(fecha,"banamex","ven",parseInt($(idvenves).val()),"v");
  act(fecha,"banamex","ven",parseInt($(idvengen).val()),"g");

}

function tmprevphgen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprevphg" + id.substr(id.length - 10);
  var idmat = "#tmprevphm" + id.substr(id.length - 10);
  var idves = "#tmprevphv" + id.substr(id.length - 10);
  var val= (parseFloat($(idmat).val())  + parseFloat($(idves).val()) ) / 2;
  $(idgen).val( val );
  act(fecha,"banamex","vph",$(idmat).val(),"m");
  act(fecha,"banamex","vph",$(idves).val(),"v");
  act(fecha,"banamex","vph",$(idgen).val(),"g");



  var idvengen = "#tmpreveng" + id.substr(id.length - 10);
  var idvenmat = "#tmprevenm" + id.substr(id.length - 10);
  var idvenves = "#tmprevenv" + id.substr(id.length - 10);

  var idvphgen = "#tmprevphg" + id.substr(id.length - 10);
  var idvphmat = "#tmprevphm" + id.substr(id.length - 10);
  var idvphves = "#tmprevphv" + id.substr(id.length - 10);

  var idposgen = "#tmpreposg" + id.substr(id.length - 10);
  var idposmat = "#tmpreposm" + id.substr(id.length - 10);
  var idposves = "#tmpreposv" + id.substr(id.length - 10);



  $(idvenmat).val( (parseInt($(idposmat).val()) * 6) *  parseFloat( $(idvphmat).val()) );
  $(idvenves).val( (parseInt($(idposves).val()) * 6) *  parseFloat( $(idvphves).val()) );
  $(idvengen).val( parseInt($(idvenmat).val()) + parseInt($(idvenves).val()) );

  act(fecha,"banamex","ven",parseInt($(idvenmat).val()),"m");
  act(fecha,"banamex","ven",parseInt($(idvenves).val()),"v");
  act(fecha,"banamex","ven",parseInt($(idvengen).val()),"g");


  var idpaltas_m = "#tmprealtm" + id.substr(id.length - 10);
  var idpaltas_v = "#tmprealtv" + id.substr(id.length - 10);
  var idpaltas_g = "#tmprealtg" + id.substr(id.length - 10);

  var idaltasnum_m = "#tmprealtnumm" + id.substr(id.length - 10);
  var idaltasnum_v = "#tmprealtnumv" + id.substr(id.length - 10);
  var idaltasnum_g = "#tmprealtnumg" + id.substr(id.length - 10);

  $(idaltasnum_m).val( ( parseInt($(idvenmat).val()) ) *   (parseInt($(idpaltas_m).val()) / 100) ) ;
  $(idaltasnum_v).val( ( parseInt($(idvenves).val()) ) *   (parseInt($(idpaltas_v).val()) / 100) ) ;
  $(idaltasnum_g).val( ( parseInt($(idvengen).val()) ) *   (parseInt($(idpaltas_g).val()) / 100) ) ;

  act(fecha,"banamex","numalt",parseInt($(idaltasnum_m).val()),"m");
  act(fecha,"banamex","numalt",parseInt($(idaltasnum_v).val()),"v");
  act(fecha,"banamex","numalt",parseInt($(idaltasnum_g).val()),"g");

}

function tmprevengen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmpreveng" + id.substr(id.length - 10);
  var idmat = "#tmprevenm" + id.substr(id.length - 10);
  var idves = "#tmprevenv" + id.substr(id.length - 10);
  var val= parseInt($(idmat).val()) + parseInt($(idves).val());
  act(fecha,"banamex","ven",parseInt($(idmat).val()),"m");
  act(fecha,"banamex","ven",parseInt($(idves).val()),"v");
  act(fecha,"banamex","ven",val,"g");
  $(idgen).val( val );
}

function tmprerechgen(id) {
  /*tmprerechm rechazos mat*/
  /*tmprerecum recuperacion mat*/
  /*tmprerfinm final mat*/
  var fecha = id.substr(id.length - 10);
  /*--- rechazos ---*/
  var idgen = "#tmprerechg" + id.substr(id.length - 10);
  var idmat = "#tmprerechm" + id.substr(id.length - 10);
  var idves = "#tmprerechv" + id.substr(id.length - 10);
  /*--- Recuperacion --*/
  var idgen_recu = "#tmprerecug" + id.substr(id.length - 10);
  var idmat_recu = "#tmprerecum" + id.substr(id.length - 10);
  var idves_recu = "#tmprerecuv" + id.substr(id.length - 10);
  /*--- Finales ---*/
  var idgen_fin = "#tmprerfing" + id.substr(id.length - 10);
  var idmat_fin = "#tmprerfinm" + id.substr(id.length - 10);
  var idves_fin = "#tmprerfinv" + id.substr(id.length - 10);
  /*-------------*/
  var val= (parseFloat($(idmat).val()) + parseFloat($(idves).val()))/2;
  //  var val2= (parseInt($(idmat_fin).val()) + parseInt($(idves_fin).val())) /2;
  /*-------valores rechazos finales------*/
  var valm= ((parseFloat($(idmat).val())*.100) * (parseFloat($(idmat_recu).val())*.100));
  var valv= ((parseFloat($(idves).val())*.100) * (parseFloat($(idves_recu).val())*.100));
  // var valf= ((parseFloat($(idgen).val())*.100) * (parseFloat($(idgen_recu).val())*.100));
  /*-------------*/

  act(fecha,"banamex","rech",parseFloat($(idmat).val()),"m");
  act(fecha,"banamex","rech",parseFloat($(idves).val()),"v");
  act(fecha,"banamex","rech",val,"g");
  /*---------- Guarda valores rechazos finales ---------*/
  act(fecha,"banamex","rfin",valm,"m");
  act(fecha,"banamex","rfin",valv,"v");
  // act(fecha,"tmpre","rfin",valf,"g");
  /*---------------------*/

  $(idgen).val( val );
  $(idmat_fin).val( valm );
  $(idves_fin).val( valv );

 var valf= ((parseFloat($(idgen).val())*.100) * (parseFloat($(idgen_recu).val())*.100));
 act(fecha,"tmpre","rfin",valf,"g");
 $(idgen_fin).val( valf );


}

function tmprerecugen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprerecug" + id.substr(id.length - 10);
  var idmat = "#tmprerecum" + id.substr(id.length - 10);
  var idves = "#tmprerecuv" + id.substr(id.length - 10);
  /*--- rechazos ---*/
  var idgen_re = "#tmprerechg" + id.substr(id.length - 10);
  var idmat_re = "#tmprerechm" + id.substr(id.length - 10);
  var idves_re = "#tmprerechv" + id.substr(id.length - 10);
  /*--- Finales ---*/
  var idgen_fin = "#tmprerfing" + id.substr(id.length - 10);
  var idmat_fin = "#tmprerfinm" + id.substr(id.length - 10);
  var idves_fin = "#tmprerfinv" + id.substr(id.length - 10);

  var val= (parseFloat($(idmat).val()) + parseFloat($(idves).val())) / 2;

  var valm= ((parseFloat($(idmat).val())*.100) * (parseFloat($(idmat_re).val())*.100));
  var valv= ((parseFloat($(idves).val())*.100) * (parseFloat($(idves_re).val())*.100));


  act(fecha,"banamex","recu",parseFloat($(idmat).val()),"m");
  act(fecha,"banamex","recu",parseFloat($(idves).val()),"v");
  act(fecha,"banamex","recu",val,"g");

  act(fecha,"banamex","rfin",valm,"m");
  act(fecha,"banamex","rfin",valv,"v");

  $(idgen).val( val );

  $(idmat_fin).val( valm );
  $(idves_fin).val( valv );

 var valf= ((parseFloat($(idgen).val())*.100) * (parseFloat($(idgen_re).val())*.100));
 act(fecha,"tmpre","rfin",valf,"g");
 $(idgen_fin).val( valf );
}

function tmprerfingen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprerfing" + id.substr(id.length - 10);
  var idmat = "#tmprerfinm" + id.substr(id.length - 10);
  var idves = "#tmprerfinv" + id.substr(id.length - 10);
  var val= (parseInt($(idmat).val()) + parseInt($(idves).val())) /2;
  act(fecha,"banamex","rfin",parseInt($(idmat).val()),"m");
  act(fecha,"banamex","rfin",parseInt($(idves).val()),"v");
  act(fecha,"banamex","rfin",val,"g");
  $(idgen).val( val );
}

function tmpreinggen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmpreingg" + id.substr(id.length - 10);
  var idmat = "#tmpreingm" + id.substr(id.length - 10);
  var idves = "#tmpreingv" + id.substr(id.length - 10);
  var val= (parseInt($(idmat).val()) + parseInt($(idves).val())) /2 ;
  act(fecha,"banamex","ing",parseInt($(idmat).val()),"m");
  act(fecha,"banamex","ing",parseInt($(idves).val()),"v");
  act(fecha,"banamex","ing",val,"g");
  $(idgen).val( val );
}

function tmprealtgen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprealtg" + id.substr(id.length - 10);
  var idmat = "#tmprealtm" + id.substr(id.length - 10);
  var idves = "#tmprealtv" + id.substr(id.length - 10);
  var val= parseInt($(idmat).val()) + parseInt($(idves).val());
  act(fecha,"banamex","alt",parseInt($(idmat).val()),"m");
  act(fecha,"banamex","alt",parseInt($(idves).val()),"v");
  act(fecha,"banamex","alt",val,"g");
  $(idgen).val( val );
}

function tmprealtnum(id){

}
function act(fecha,camp,met,val,turno) {
  var url="{{URL('direccion/proyeccion/salvar')}}" + "/" + fecha +"/" + camp + "/" + met + "/" + val + "/" + turno;
  $.get(url);
}

// $("#guardar").click(function () {
//   var a = document.querySelectorAll("input");
//   var arr=[];
//     for(var b in a){
//       var c = a[b];
//       if(typeof c=="object"){
//         if(c.id != ''){
//             arr[c.id] = c.value;
//         }
//       }
//     }
//   console.log(arr);
// });


</script>

@stop
