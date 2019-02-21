@extends('layout.demos.reporte')
@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Asistencia Telefonica</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre Operador</th>
              <th>Hora</th>
              <th>Asistencia</th>
              <th>Motivo Falta</th>
              <th>Observaciones</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Nancy Rodriguez Cedillo</td>
              <td>08:45:50</td>
              <td>
                <select>
                  <option value=""></option>
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
              </td>
              <td>
                <select>
                  <option value=""></option>
                  <option value="Enfermedad">Enfermedad</option>
                  <option value="Personal">Personal</option>
                  <option value="No contesta">No contesta</option>
                  <option value="Sin motivo">Sin motivo</option>
                  <option value="Defuncion">Defuncion</option>
                  <option value="Tramites">Tramites</option>
                  <option value="Vacaciones">Vacaciones</option>
                </select>
              </td>
              <td>
                <input type="textarea" name="name" value="">
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Maria de los Angeles Chona Ramirez</td>
              <td>08:45:50</td>
              <td>
                <select>
                  <option value=""></option>
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
              </td>
              <td>
                <select>
                  <option value=""></option>
                  <option value="Enfermedad">Enfermedad</option>
                  <option value="Personal">Personal</option>
                  <option value="No contesta">No contesta</option>
                  <option value="Sin motivo">Sin motivo</option>
                  <option value="Defuncion">Defuncion</option>
                  <option value="Tramites">Tramites</option>
                  <option value="Vacaciones">Vacaciones</option>
                </select>
              </td>
              <td>
                <input type="textarea" name="name" value="">
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>Maria del Refugio Villalpando Sanchez </td>
              <td>08:45:50</td>
              <td>
                <select>
                  <option value=""></option>
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
              </td>
              <td>
                <select>
                  <option value=""></option>
                  <option value="Enfermedad">Enfermedad</option>
                  <option value="Personal">Personal</option>
                  <option value="No contesta">No contesta</option>
                  <option value="Sin motivo">Sin motivo</option>
                  <option value="Defuncion">Defuncion</option>
                  <option value="Tramites">Tramites</option>
                  <option value="Vacaciones">Vacaciones</option>
                </select>
              </td>
              <td>
                <input type="textarea" name="name" value="">
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>Eduardo Morales Martinez </td>
              <td>08:45:50</td>
              <td>
                <select>
                  <option value=""></option>
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
              </td>
              <td>
                <select>
                  <option value=""></option>
                  <option value="Enfermedad">Enfermedad</option>
                  <option value="Personal">Personal</option>
                  <option value="No contesta">No contesta</option>
                  <option value="Sin motivo">Sin motivo</option>
                  <option value="Defuncion">Defuncion</option>
                  <option value="Tramites">Tramites</option>
                  <option value="Vacaciones">Vacaciones</option>
                </select>
              </td>
              <td>
                <input type="textarea" name="name" value="">
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>Ivan Rosendo Reyes Villegas</td>
              <td>08:45:50</td>
              <td>
                <select>
                  <option value=""></option>
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
              </td>
              <td>
                <select>
                  <option value=""></option>
                  <option value="Enfermedad">Enfermedad</option>
                  <option value="Personal">Personal</option>
                  <option value="No contesta">No contesta</option>
                  <option value="Sin motivo">Sin motivo</option>
                  <option value="Defuncion">Defuncion</option>
                  <option value="Tramites">Tramites</option>
                  <option value="Vacaciones">Vacaciones</option>
                </select>
              </td>
              <td>
                <input type="textarea" name="name" value="">
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>Michelle Herrera Cruz</td>
              <td>08:45:50</td>
              <td>
                <select>
                  <option value=""></option>
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
              </td>
              <td>
                <select>
                  <option value=""></option>
                  <option value="Enfermedad">Enfermedad</option>
                  <option value="Personal">Personal</option>
                  <option value="No contesta">No contesta</option>
                  <option value="Sin motivo">Sin motivo</option>
                  <option value="Defuncion">Defuncion</option>
                  <option value="Tramites">Tramites</option>
                  <option value="Vacaciones">Vacaciones</option>
                </select>
              </td>
              <td>
                <input type="textarea" name="name" value="">
              </td>
            </tr>
          </tbody>
        </table>
        <div class="">
                {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
        </div>
      </div>
    </div>
  </div>
</div>
@stop
