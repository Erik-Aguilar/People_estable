<?php

namespace App\Http\Controllers;

use App\Model\ticket\tickets;
use App\Model\ticket\comentarios_tickets;
use App\Model\Empleado;
use App\Model\Candidato;
use Session;
use Illuminate\Http\Request;
use DB;

class TicketController extends Controller {

  function menu()
  {
    $puesto = session('puesto');
    $camp = session('campaign');
    #dd(session());
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
        case 'Operador de Call Center': $menu = "layout.tmpre.basic";
            break;
        case 'Supervisor':
        switch ($camp) {
          case 'TM Prepago': $menu = "layout.tmpre..super.inicio";
            break;

          default: $menu = "layout.rep.basic";
            break;
        }
            break;
        default: $menu = "layout.rep.basic";
            break;
    }
    return $menu;
  }

    public function Nuevo() {
      $menu=$this->menu();

        return view('tickets.index', compact('menu'));
    }

    public function NuevoTicket(Request $request) {
        $user = Session::all();

        $menu=$this->menu();

        //$nom_completo = valiAcento($request->nombre) . " " . valiAcento($request->paterno) . " " . valiAcento($request->materno);

        $tickets = new tickets;
        $tickets->titulo = $request->titulo;
        $tickets->descripcion = $request->descripcion;
        $tickets->quien_solicita = $user['user'];
        $tickets->estatus = 'Enviado';
        $tickets->divicion = $request->divicion;
        //$tickets->tipo_solicitud = $request->tipo_solicitud;
        //$tickets->grupo = $request->grupo;
        $tickets->save();

        return view('tickets.enviada', compact('menu'));
    }

    public function lista() {
        $noEmpleado = session('user');

        $menu=$this->menu();

        $valores = tickets::select(DB::raw('id,titulo, divicion, estatus, updated_at as hora_envio'))
                ->where('quien_solicita', [$noEmpleado])
                ->orderBy('id', 'desc')
                ->get();

        return view('tickets.ListaTicket', compact('valores', 'menu'));
    }

    public function ver($value = "") {

        $menu=$this->menu();

        $identificador = false;
        if (tickets::find($value)) {
            $valores = tickets::select(DB::raw("tickets.id, tickets.asignado,
                if(tickets.asignado is not null, (select can.nombre_completo from sistemas.tickets inner join pc.candidatos as can on asignado = can.id where tickets.id ='$value'),'Sin Asignacion') as nom_asignado,
                tickets.encargado,
                if(tickets.encargado is not null, (select ca.nombre_completo from sistemas.tickets inner join pc.candidatos as ca on encargado = ca.id where tickets.id ='$value'),'Sin Encargado') as nom_encargado,

                tickets.BoVoSistemas,
                tickets.BoVoSolicitante,titulo,descripcion,quien_solicita,estatus,divicion,tickets.updated_at as hora_envio, c.nombre_completo,c.area, c.puesto,c.campaign"))
                    ->join('pc.candidatos as c', 'quien_solicita', '=', 'c.id')
                    ->where('tickets.id', $value)
                    ->get();
            
            #concat(tiempo_dias,' días, ',tiempo_horas,' horas, ',tiempo_mins,' minutos ') as tiempo_estimado, -> linea va despues de nom_encargado, 7 lenas arriba baby

            $ticket_com = comentarios_tickets::select(DB::raw('id_comentario,comentario_tecnico,comentarios_solicitante'))
                    ->where('id_ticket', $value)
                    ->get();

            
            $ticket_histo = comentarios_tickets::select(DB::raw('c.nombre_completo,time(comentarios_tickets.created_at) as hora,date(comentarios_tickets.created_at) as dia,comentario_tecnico,comentarios_solicitante,estatus'))
                    ->join('pc.candidatos as c', 'quien_contesta', '=', 'c.id')
                    ->where('id_ticket', $value)
                    ->get();
            $user = Session::all();

            //dd($valores);
            //return view('tickets.verTicket', compact('valores', 'ticket_com', 'menu'));

            if (empty($ticket_com[0]) == True) {
                return view('tickets.verTicketSinC', compact('valores', 'menu'));
            }
            return view('tickets.verTicket', compact('ticket_com', 'ticket_histo', 'valores', 'menu'));
        } else {
            $valores = new tickets;
            $valores->id_ticket = $value;
            $valores->save();
            $identificador = true;
        }
    }

    /* area de desarrollo */

    public function listaSistemas() {
        $noEmpleado = session('user');
        $menu=$this->menu();


        switch (session('area')) {
            case 'Sistemas':
                $valores = tickets::select(DB::raw('tickets.id,titulo, divicion, estatus,descripcion, tickets.created_at as hora_envio,tickets.updated_at as hora_actua,c.nombre_completo as asignado,can.nombre_completo as encargado'))
                        ->LEFTjoin('pc.candidatos as c', 'asignado', '=', 'c.id')
                        ->LEFTjoin('pc.candidatos as can', 'encargado', '=', 'can.id')
                        ->where('asignado', [$noEmpleado])
                        ->orderBy('hora_envio', 'desc')
                        ->get();
                break;

            case 'Direccion General':
                $valores = tickets::select(DB::raw('tickets.id,titulo, divicion, estatus,descripcion, tickets.created_at as hora_envio,tickets.updated_at as hora_actua,c.nombre_completo as asignado,can.nombre_completo as encargado'))
                        ->LEFTjoin('pc.candidatos as c', 'asignado', '=', 'c.id')
                        ->LEFTjoin('pc.candidatos as can', 'encargado', '=', 'can.id')
                        ->orderBy('hora_envio', 'desc')
                        ->get();
                break;

            case 'Root':
                $valores = tickets::select(DB::raw('tickets.id,titulo, divicion, estatus,descripcion, tickets.created_at as hora_envio,tickets.updated_at as hora_actua,c.nombre_completo as asignado,can.nombre_completo as encargado'))
                        ->LEFTjoin('pc.candidatos as c', 'asignado', '=', 'c.id')
                        ->LEFTjoin('pc.candidatos as can', 'encargado', '=', 'can.id')
                        ->orderBy('hora_envio', 'desc')
                        ->get();
                break;
        }

        switch (session('user')) {
            case '1609260013':
                $valores = tickets::select(DB::raw('tickets.id,titulo, divicion, estatus,descripcion, tickets.created_at as hora_envio,tickets.updated_at as hora_actua,c.nombre_completo as asignado,can.nombre_completo as encargado'))
                        ->LEFTjoin('pc.candidatos as c', 'asignado', '=', 'c.id')
                        ->LEFTjoin('pc.candidatos as can', 'encargado', '=', 'can.id')
                        ->where(['can.id' => '1609260013'])
                        ->orWhere('encargado', null)
                        ->orderBy('hora_envio', 'desc')
                        ->get();
                break;
            case '1610040040':
                $valores = tickets::select(DB::raw('tickets.id,titulo, divicion, estatus,descripcion, tickets.created_at as hora_envio,tickets.updated_at as hora_actua,c.nombre_completo as asignado,can.nombre_completo as encargado'))
                        ->LEFTjoin('pc.candidatos as c', 'asignado', '=', 'c.id')
                        ->LEFTjoin('pc.candidatos as can', 'encargado', '=', 'can.id')
                        ->where(['can.id' => '1610040040'])
                        ->orWhere('encargado', null)
                        ->orderBy('hora_envio', 'desc')
                        ->get();
                break;
            case '1702090039':
                $valores = tickets::select(DB::raw('tickets.id,titulo, divicion, estatus,descripcion, tickets.created_at as hora_envio,tickets.updated_at as hora_actua,c.nombre_completo as asignado,can.nombre_completo as encargado'))
                        ->LEFTjoin('pc.candidatos as c', 'asignado', '=', 'c.id')
                        ->LEFTjoin('pc.candidatos as can', 'encargado', '=', 'can.id')
                        ->where(['can.id' => '1702090039'])
                        ->orWhere('encargado', null)
                        ->orderBy('hora_envio', 'desc')
                        ->get();
                break;
            /*
            case '1610040032':
                $valores = tickets::select(DB::raw('tickets.id,titulo, divicion, estatus,descripcion, tickets.created_at as hora_envio,tickets.updated_at as hora_actua,c.nombre_completo as asignado,can.nombre_completo as encargado'))
                        ->LEFTjoin('pc.candidatos as c', 'asignado', '=', 'c.id')
                        ->LEFTjoin('pc.candidatos as can', 'encargado', '=', 'can.id')
                        ->where(['can.id' => '1610040032'])
                        ->orWhere('encargado', null)
                        ->orderBy('hora_envio', 'desc')
                        ->get();
                break;
                */
        }
        //dd($valores);

        return view('tickets.listaSistema', compact('valores', 'menu'));
    }

    public function SistemasLista($value = "") {
        $puesto = session('puesto');
        $menu=$this->menu();

        $identificador = false;
        if (tickets::find($value)) {
            $valores = tickets::select(DB::raw('tickets.id, tickets.asignado,tickets.encargado,tickets.tiempo_estimado,tickets.BoVoSistemas,tickets.BoVoSolicitante,titulo,descripcion,quien_solicita,estatus,divicion, tickets.updated_at as hora_envio, c.nombre_completo,c.area, c.puesto,c.campaign'))
                    ->join('pc.candidatos as c', 'quien_solicita', '=', 'c.id')
                    ->where('tickets.id', $value)
                    ->get();
            /* $valores = tickets::select(DB::raw('tickets.id,titulo,descripcion,quien_solicita,estatus,divicion, tickets.updated_at as hora_envio, c.nombre_completo,c.area, c.puesto,c.campaign'))
              ->join('candidatos as c', 'quien_solicita', '=', 'c.id')
              ->where('tickets.id', $value)
              ->get(); */
            $ticket_com = comentarios_tickets::select(DB::raw('*'))
                    ->where('id_ticket', $value)
                    ->get();

            $sistemas = Empleado::select('candidatos.id', 'candidatos.nombre_completo')
                    ->join('pc.candidatos', 'candidatos.id', '=', 'empleados.id')
                    ->where(['area' => 'Sistemas', 'estatus' => 'Activo'])
                    ->orderBy('nombre_completo', 'asc')
                    ->pluck('nombre_completo', 'id');

            $encargado = Candidato::select('candidatos.id', 'candidatos.nombre_completo')
                    ->whereIn('id', [1609260013, 1610040040,1702090039])
                    #->join('pc.empleados', 'candidatos.id', '=', 'empleados.id')
                    #->where(['area' => 'Sistemas', 'estatus' => 'Activo'])
                    ->orderBy('nombre_completo', 'asc')
                    ->pluck('nombre_completo', 'id');


            $ticket_histo = comentarios_tickets::select(DB::raw('c.nombre_completo,time(comentarios_tickets.created_at) as hora,date(comentarios_tickets.created_at) as dia,comentario_tecnico,comentarios_solicitante,estatus'))
                    ->join('pc.candidatos as c', 'quien_contesta', '=', 'c.id')
                    ->where('id_ticket', $value)
                    ->get();

            //$user = Session::all();
            //dd($ticket_com[0]->comentario_tecnico);
            /* if(empty($ticket_com)== True){
              return view('tickets.verTicketSistema', compact( 'ticket_com','ticket_histo','valores','sistemas', 'menu'));
              }else  if(empty($ticket_com)== false){
              return view('tickets.verTicketSistemSinC', compact( 'valores','sistemas', 'menu'));
              }
             */
            if (empty($ticket_com[0]) == True) {
                return view('tickets.verTicketSistemSinC', compact('valores', 'sistemas', 'encargado', 'menu'));
            }
            return view('tickets.verTicketSistema', compact('ticket_com', 'ticket_histo', 'valores', 'sistemas', 'encargado', 'menu'));
        } else {
            $valores = new tickets;
            $valores->id_ticket = $value;
            $valores->save();
            $identificador = true;
        }
    }

    public function SistemaGuardaTicket(Request $request) {
        $user = Session::all();

        $puesto = session('puesto');
        $menu=$this->menu();

        //$nom_completo = valiAcento($request->nombre) . " " . valiAcento($request->paterno) . " " . valiAcento($request->materno);

        $tickets = new tickets;
        $tickets = tickets::find($request->id);
        $tickets->estatus = $request->estatus;
        $tickets->tiempo_estimado = $request->tiempo_estimado;
        $tickets->encargado = $request->encargado;
        $tickets->asignado = $request->asignado;
        $tickets->BoVoSistemas = $request->BoVoSistemas;
        $tickets->save();

        $comentickets = new comentarios_tickets;
        //$us = Usuario::find($request->id);
        $comentickets->id_ticket = $request->id;
        $comentickets->quien_contesta = $user['user'];
        $comentickets->comentario_tecnico = $request->comen_tecnico;
        $comentickets->comentarios_solicitante = $request->comen_solicita;
        $comentickets->estatus = $request->estatus;
        $comentickets->save();

        return view('tickets.contestadaSistema', compact('menu'));
    }

}
