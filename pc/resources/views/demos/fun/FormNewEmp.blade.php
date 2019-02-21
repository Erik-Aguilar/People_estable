@extends('layout.demos.reporte')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Nuevo Empleado</h3>
            </div>
            <div class="panel-body">
                
                {{ Form::open(['action' => 'DemosController@NewEmpleado',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario"
                          ]) }}
                          
                          
                          <div class="form-group">
                              {{ Form::label('Nombre *','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('nombre',null,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Paterno *','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('paterno',null,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Materno','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('materno',null,array('class'=>"form-control", 'placeholder'=>"")) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Telefono fijo',null,array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::number('telefono_fijo',null,array('class'=>"form-control")) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Telefono celular','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::number('telefono_cel',null,array('class'=>"form-control")) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Fecha de Cumpleaños','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::date('fecha_cumple',null,array('class'=>"form-control", 'placeholder'=>"********")) }}
                              </div>
                          </div>
                          
                          <div class="form-group">
                            {{ Form::label('En caso de emergencia llamar a ','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{ Form::text('nom_emergencia1',null,array('class'=>"form-control", 'placeholder'=>"Nombre del Contacto emergencia 1")) }}
                                {{ Form::number('emergencia1',null,array('class'=>"form-control", 'placeholder'=>"Telefono 1")) }}
                                {{ Form::text('nom_emergencia2',null,array('class'=>"form-control", 'placeholder'=>"Nombre del Contacto emergencia 2")) }}
                                {{ Form::number('emergencia1',null,array('class'=>"form-control", 'placeholder'=>"Telefono 2")) }}
                            </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Usuario externo','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('user_ext',null,array('class'=>"form-control", 'placeholder'=>"PC0000")) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Usuario Elastix','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('user_elx',null,array('class'=>"form-control", 'placeholder'=>"111")) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Usuario Auxiliar','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('usuarioAux',null,array('class'=>"form-control")) }}
                              </div>
                          </div>
                          
                          <div class="form-group">
                              {{ Form::label('Campaña','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                {{Form::select('campaign',$camp->prepend(''),'',['onChange'=>'area()','id'=>'campaign','class'=>'form-control','placeholder'=>'Selecciona un campaña'])}}
                              </div>
                          </div>
                          
                          <div class="form-group">
                              {{ Form::label('Area *','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                {{Form::select('areas',[],'',['onChange'=>'puesto()','id'=>'areas','class'=>'form-control','placeholder'=>'Selecciona un area'])}}
                              </div>
                          </div>
                          
                          <div class="form-group">
                              {{ Form::label('Puesto *','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                {{Form::select('puestos',[],'',['onChange'=>'valida(),turno()','id'=>'puestos','class'=>'form-control','placeholder'=>'Selecciona un puesto'])}}
                              </div>
                          </div>
                          
                          <div class="form-group">
                              {{ Form::label('Sucursal *','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::select('sucursal', [
                                  'Zapata'=>'Zapata',
                                  'Roma'=>'Roma'],
                                  '', ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                          </div>


                          <div class="form-group">
                              {{ Form::label('Turno *','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{Form::select('turnos',[],'',['id'=>'turnos','class'=>'form-control','placeholder'=>'Selecciona un turno'])}}
                              </div>
                          </div>
                          
                          
                          <div class="form-group">
                            {{ Form::label('Jefe directo','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                                {{Form::select('supervisores',[],'',['id'=>'supervisores','class'=>'form-control','placeholder'=>'Selecciona un supervisor'])}}
                            </div>
                          </div>
                          
                          
                          
                          
                {{ Form::close() }}
                
            </div>
        </div>
    </div>
</div>

@stop

@section('content2')

<script type="text/javascript">

function area() {
var compa =$("#campaign").val();//Captura el valor del selec con el Id #
console.log(compa);

    $.ajax({
        /*url:"/demosF/nuevo/area/"+compa, //Busca la ruta*/
        url:"http://localhost/trunk/pc/public/demosF/nuevo/area/"+compa, //Busca la ruta
        type:'get',

        beforeSend:function () {
            console.log('espere');
        },
        success:function (area) {//Llena el select con la consulta que esta en el controlador
            console.log(area);
            $('#areas').empty();
            $('#areas').append(new Option('', ''));
            for ( i = 0; i < area.length; i++) {
                $('#areas').append('<option value="'+area[i].area+'">'+area[i].area+'</option>');
            }
        }
    });
}

function puesto() {
    var compa =$("#campaign").val();//Captura el valor del selec con el Id #
    // console.log(compa);
    var area =$("#areas").val();//Captura el valor del selec con el Id #
    // console.log(area);
    // var afa = "/demosF/nuevo/puesto/"+compa+"/"+area; //Busca la ruta
    // console.log(afa);
    $.ajax({
        /*url:"/demosF/nuevo/puesto/"+compa+"/"+area, //Busca la ruta*/
        url:"http://localhost/trunk/pc/public/demosF/nuevo/puesto/"+compa+"/"+area, //Busca la ruta
        type:'get',

        beforeSend:function () {
            console.log('espere');
        },
        success:function (puesto) {
            console.log(puesto);
            $('#puestos').empty();
            $('#puestos').append(new Option('', ''));
            for (var i = 0; i < puesto.length; i++) {
                $('#puestos').append('<option value="'+puesto[i].puesto+'">'+puesto[i].puesto+'</option>');
            }
        }
    });
}


function turno() {
    var compa =$("#campaign").val();//Captura el valor del selec con el Id #
    // console.log(compa);
    var area =$("#areas").val();//Captura el valor del selec con el Id #
    // console.log(area);
    var puesto =$("#puestos").val();//Captura el valor del selec con el Id #
    // console.log(puesto);
    // var afa = "/demosF/nuevo/turno/"+compa+"/"+area+"/"+puesto; //Busca la ruta
    // console.log(afa);
    $.ajax({
        /*url:"/demosF/nuevo/turno/"+compa+"/"+area+"/"+puesto, //Busca la ruta*/
        url:"http://localhost/trunk/pc/public/demosF/nuevo/turno/"+compa+"/"+area+"/"+puesto, //Busca la ruta
        type:'get',

        beforeSend:function () {
            console.log('espere');
        },
        success:function (data) {
            console.log(data);
            $('#turnos').empty();
            $('#turnos').append(new Option('', ''));
            for (var i = 0; i < data.length; i++) {
                $('#turnos').append('<option value="'+data[i].turno+'">'+data[i].turno+'</option>');
            }
        }
    });
}

</script>

<script type="text/javascript"> 
function sup() {
  var area =$("#areas").val();//Captura el valor del selec con el Id #
  // console.log(area);
// var aaaa ="/demosF/nuevo/super/"+area;
// console.log(aaaa);
  $.ajax({
    /*url:"/demosF/nuevo/super/"+area, //Busca la ruta*/
    url:"http://localhost/trunk/pc/public/demosF/nuevo/super/"+area, //Busca la ruta
    type:'get',
    
    beforeSend:function () {
      console.log('espere');
    },
    success:function (supe) {//Llena el select con la consulta que esta en el controlador
      console.log(supe);
      $('#supervisores').empty();
      $('#supervisores').append(new Option('', ''));
      for ( i = 0; i < supe.length; i++) {
        $('#supervisores').append('<option value="'+supe[i].nombre_completo+'">'+supe[i].nombre_completo+'</option>');
      }

    }
  });

}



function jefe() {
  var area =$("#areas").val();//Captura el valor del selec con el Id #
  // console.log(area);
// var aaaa ="/demosF/nuevo/super/"+area;
// console.log(aaaa);
  $.ajax({
    url:"/demosF/nuevo/jefe/", //Busca la ruta


    type:'get',

    beforeSend:function () {
      console.log('espere');
    },
    success:function (jefe) {//Llena el select con la consulta que esta en el controlador
      console.log(jefe);
      $('#supervisores').empty();
      $('#supervisores').append(new Option('', ''));
      for ( i = 0; i < jefe.length; i++) {
        $('#supervisores').append('<option value="'+jefe[i].nombre_completo+'">'+jefe[i].nombre_completo+'</option>');
      }

    }
  });

}


function coord() {
  var area =$("#areas").val();//Captura el valor del selec con el Id #
  // console.log(area);
// var aaaa ="/demosF/nuevo/super/"+area;
// console.log(aaaa);
  $.ajax({
    url:"/demosF/nuevo/coord/", //Busca la ruta


    type:'get',

    beforeSend:function () {
      console.log('espere');
    },
    success:function (coord) {//Llena el select con la consulta que esta en el controlador
      console.log(coord);
      $('#supervisores').empty();
      $('#supervisores').append(new Option('', ''));
      for ( i = 0; i < coord.length; i++) {
        $('#supervisores').append('<option value="'+coord[i].nombre_completo+'">'+coord[i].nombre_completo+'</option>');
      }

    }
  });

}



function gerente() {
  var area =$("#areas").val();//Captura el valor del selec con el Id #
  // console.log(area);
// var aaaa ="/demosF/nuevo/super/"+area;
// console.log(aaaa);
  $.ajax({
    url:"/demosF/nuevo/gerente/", //Busca la ruta


    type:'get',

    beforeSend:function () {
      console.log('espere');
    },
    success:function (gerente) {//Llena el select con la consulta que esta en el controlador
      console.log(gerente);
      $('#supervisores').empty();
      $('#supervisores').append(new Option('', ''));
      for ( i = 0; i < gerente.length; i++) {
        $('#supervisores').append('<option value="'+gerente[i].nombre_completo+'">'+gerente[i].nombre_completo+'</option>');
      }

    }
  });

}




function valida() {
  var puesto =$("#puestos").val();//Captura el valor del selec con el Id #
  // console.log(puesto+"PUESTOSSSSSSSSS");

  if (puesto == 'Jefe de administracion' || puesto == 'Jefe de desarrollo' || puesto == 'Jefe de soporte') {
    jefe();
    // console.log(puesto+"  puesto de jefe");
  }

  else if (puesto == 'Coordinador de Calidad' || puesto == 'Coordinador de Capacitacion' || puesto == 'Coordinador' || puesto == 'Coordinador de reclutamiento') {
    coord();
    // console.log(puesto+"  puesto de coordinador");
  }

  else if (puesto == 'Gerente') {
    gerente();
    // console.log(puesto+"  puesto de gerente");
  }

  else if (puesto != 'Jefe de administracion' && puesto != 'Jefe de desarrollo' && puesto != 'Jefe de soporte' && puesto != 'Coordinador de Calidad' && puesto != 'Coordinador de Capacitacion' && puesto != 'Coordinador' && puesto != 'Coordinador de reclutamiento' && puesto != 'Gerente') {
    sup();
    // console.log(puesto+"  puesto de OTRA COSA");
  }

}
</script>

@stop