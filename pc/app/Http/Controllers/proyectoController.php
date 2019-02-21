<?php

namespace App\Http\Controllers;

use App\Model\proyecto\proyectos;
use App\Model\proyecto\comentarios_tickets;
use App\Model\Empleado;
use App\Model\Candidato;
use Session;
use Illuminate\Http\Request;
use DB;

class proyectoController extends Controller {

    public function Nuevo() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.admin.admin";
                break;
            case 'Programador 1': $menu = "layout.sistemas.sistemas";
                break;
            case 'Becario de desarrollo': $menu = "layout.sistemas.sistemas";
                break;
            case 'Jefe de desarrollo': $menu = "layout.sistemas.sistemas";
                break;
            case 'Becario soporte': $menu = "layout.soporte.basic";
                break;
            case 'Técnico de soporte 1': $menu = "layout.soporte.basic";
                break;
            case 'Técnico de soporte 2': $menu = "layout.soporte.basic";
                break;
            case 'Jefe de soporte': $menu = "layout.soporte.basic";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }

        return view('SistemasProyect.nuevoProyecto', compact('menu'));
    }

    public function NuevoProyecto(Request $request) {
        $user = Session::all();

        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.admin.admin";
                break;
            case 'Programador 1': $menu = "layout.sistemas.sistemas";
                break;
            case 'Becario de desarrollo': $menu = "layout.sistemas.sistemas";
                break;
            case 'Jefe de desarrollo': $menu = "layout.sistemas.sistemas";
                break;
            case 'Becario soporte': $menu = "layout.soporte.basic";
                break;
            case 'Técnico de soporte 1': $menu = "layout.soporte.basic";
                break;
            case 'Técnico de soporte 2': $menu = "layout.soporte.basic";
                break;
            case 'Jefe de soporte': $menu = "layout.soporte.basic";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }

        //$nom_completo = valiAcento($request->nombre) . " " . valiAcento($request->paterno) . " " . valiAcento($request->materno);

        $proyecto = new proyectos;
        $proyecto->titulo = $request->titulo;
        $proyecto->descripcion = $request->descripcion;
        $proyecto->quien_solicita = $user['user'];
        $proyecto->estatus = 'Enviado';
        //$proyecto->camapana = $request->campana;
        //$tickets->tipo_solicitud = $request->tipo_solicitud;
        //$tickets->grupo = $request->grupo;
        $proyecto->save();

        return view('SistemasProyect.enviada', compact('menu'));
    }

    public function lista() {
        $noEmpleado = session('user');

        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.admin.admin";
                break;
            case 'Programador 1': $menu = "layout.sistemas.sistemas";
                break;
            case 'Becario de desarrollo': $menu = "layout.sistemas.sistemas";
                break;
            case 'Jefe de desarrollo': $menu = "layout.sistemas.sistemas";
                break;
            case 'Becario soporte': $menu = "layout.soporte.basic";
                break;
            case 'Técnico de soporte 1': $menu = "layout.soporte.basic";
                break;
            case 'Técnico de soporte 2': $menu = "layout.soporte.basic";
                break;
            case 'Jefe de soporte': $menu = "layout.soporte.basic";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }

        $valores = proyectos::select(DB::raw('id,titulo, estatus, updated_at as hora_envio'))
                ->where('quien_solicita', [$noEmpleado])
                ->orderBy('id', 'desc')
                ->get();

        return view('SistemasProyect.ListaProyecto', compact('valores', 'menu'));
    }

    public function listaDetalle($value = "") {

        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.admin.admin";
                break;
            case 'Programador 1': $menu = "layout.sistemas.sistemas";
                break;
            case 'Becario de desarrollo': $menu = "layout.sistemas.sistemas";
                break;
            case 'Jefe de desarrollo': $menu = "layout.sistemas.sistemas";
                break;
            case 'Becario soporte': $menu = "layout.soporte.basic";
                break;
            case 'Técnico de soporte 1': $menu = "layout.soporte.basic";
                break;
            case 'Técnico de soporte 2': $menu = "layout.soporte.basic";
                break;
            case 'Jefe de soporte': $menu = "layout.soporte.basic";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }

        $identificador = false;
        if (proyectos::find($value)) {
            $valores = proyectos::select(DB::raw("proyectos.id, proyectos.asignado,if(proyectos.asignado is not null, 
(select can.nombre_completo from sistemas.proyectos 
inner join pc.candidatos as can on asignado = can.id where proyectos.id ='$value'),'Sin Asignacion') as nom_asignado,
proyectos.encargado,
if(proyectos.encargado is not null, 
(select ca.nombre_completo from sistemas.proyectos 
inner join pc.candidatos as ca on encargado = ca.id where proyectos.id ='$value'),'Sin Encargado') as nom_encargado,
titulo,descripcion,quien_solicita,estatus,campana,proyectos.updated_at as hora_envio, c.nombre_completo,c.area, c.puesto,c.campaign"))
                    ->join('pc.candidatos as c', 'quien_solicita', '=', 'c.id')
                    ->where('proyectos.id', $value)
                    ->get();

            /*$ticket_com = comentarios_tickets::select(DB::raw('id_comentario,comentario_tecnico,comentarios_solicitante'))
                    ->where('id_proyecto', $value)
                    ->get();

            $ticket_histo = comentarios_tickets::select(DB::raw('c.nombre_completo,time(comentarios_tickets.created_at) as hora,date(comentarios_tickets.created_at) as dia,comentario_tecnico,comentarios_solicitante,estatus'))
                    ->join('pc.candidatos as c', 'quien_contesta', '=', 'c.id')
                    ->where('id_proyecto', $value)
                    ->get();
*/
            $sistemas = Empleado::select('candidatos.id', 'candidatos.nombre_completo')
                    ->join('pc.candidatos', 'candidatos.id', '=', 'empleados.id')
                    ->where(['area' => 'Sistemas', 'estatus' => 'Activo'])
                    ->orderBy('nombre_completo', 'asc')
                    ->pluck('nombre_completo', 'id');

            $encargado = Candidato::select('id', 'nombre_completo')
                    ->whereIn('id', [1610040033, 1610040040, 1708080003])
                    ->orderBy('nombre_completo', 'asc')
                    ->pluck('nombre_completo', 'id');
            $user = Session::all();

            //dd($valores);
            //return view('tickets.verTicket', compact('valores', 'ticket_com', 'menu'));

            if (empty($ticket_com[0]) == True) {
                return view('SistemasProyect.detalleProyecto', compact('valores', 'sistemas', 'encargado', 'menu'));
            }
            return view('SistemasProyect.detalleProyectoSin', compact('valores', 'sistemas', 'encargado', 'menu'));
            //return view('SistemasProyect.detalleProyecto', compact('ticket_com', 'ticket_histo', 'valores', 'menu'));
        } else {
            dd($valores);
        }
    }

    public function detalle() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.admin.admin";
                break;
            case 'Programador 1': $menu = "layout.sistemas.sistemas";
                break;
            case 'Becario de desarrollo': $menu = "layout.sistemas.sistemas";
                break;
            case 'Jefe de desarrollo': $menu = "layout.sistemas.sistemas";
                break;
            case 'Becario soporte': $menu = "layout.soporte.basic";
                break;
            case 'Técnico de soporte 1': $menu = "layout.soporte.basic";
                break;
            case 'Técnico de soporte 2': $menu = "layout.soporte.basic";
                break;
            case 'Jefe de soporte': $menu = "layout.soporte.basic";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }

        return view('SistemasProyect.detalleProyecto', compact('menu'));
    }

}
