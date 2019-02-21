<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use FTP;
use SSH;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Model\Pbx\Ethics;
use App\Model\MapfreNumerosMarcados;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use DB;

class EthicsController extends Controller {

    public function inicio() {

        $empresas = DB::table('ethics.entrevistas')
                ->select('empresa')
                ->groupBy('empresa')
                ->pluck('empresa', 'empresa');
        $puesto[''] = '';

        return view('Ethics.inicio', compact('empresas', 'puesto'));
    }

    public function guarda(Request $param) {
        $fecha = date('Y-m-d H:i:s');

        DB::table('ethics.tipificaciones')->insert(
            ['nombre' => $param->nombre,
            'empresa' => $param->Empresa,
            'puesto' => $param->Puesto,
            'estatus' => $param->estatus,
            'created_at' => $fecha,
            'updated_at' => $fecha,
            'fecha' => date('Y-m-d'),
            'usuario' => session('user'),
            'audio' => $param->audio,
            'nombre_ejecutivo' => session('nombre_completo')]
        );

        return redirect('inicioEthics');
    }

    public function puestos($param) {
        $puesto = DB::table('ethics.entrevistas')
                ->select('puesto')
                ->where('empresa', '=', $param )
                ->get();

        return $puesto;
    }

    public function obtieneScript($empresa, $puesto) {

        $fp = fopen("C:/xampp/htdocs/erik/pc/public/ethics/loreal/TRAFICO-CUSTOMER SERVICES.txt", "r");

        $a = 0;
        $scrip='';

        while (!feof($fp)){
            $scrip.= fgets($fp);
            $a++;
        }
        $scrip= utf8_encode($scrip);

        return $scrip;
    }


    public function Audio($value='') {
      // $inbursa=Ethics::where([
      //   'agent'=>'Agent/'.session('extension'),
      //   'event'=>'Connect'
      // ])
      // ->orderBy('time','desc')
      // ->limit('1')
      // ->get();

      $eth=Ethics::where([
        'destino'=>'Agent/'.session('extension'),
      ])
      ->orderBy('fecha', 'desc')
      ->limit('1')
      ->get();

        return response($eth[0]);
    }
    public function Reporte($value='')
    {
      # code...
      return view('Ethics.reporte');
    }

    public function ReporteDatos($fecha='')
    {
      $datos=DB::table('ethics.tipificaciones')
      ->where('fecha',$fecha)
      ->get();
      return response($datos);

    }

    public function DescargaAudios($fecha,$audio) {
        #Bancomer_5518721295_2017-07-24_095116_AsteriskRules 2017/07/24
        #Bancomer1_2224266363_2017-07-21_090701_AsteriskRules 2017/07/21
        #Bancomer_4454578981_2017-08-08_205305_Asterisk 2017/08/08

        try {

          $fecha=str_replace("-", "/", $fecha);
          $url = "http://201.168.130.213:256/Ethics/".$fecha."/".$audio;
          $filename = $audio;
          $tempImage = tempnam(sys_get_temp_dir(), $filename);
          copy($url, $tempImage);

          return response()->download($tempImage, $filename);

        } catch (\Exception $e) {
          return response('Audio no encontrado', 404)
                  ->header('Content-Type', 'text/plain');
          #return response()->view('errors.404', compact('e'), 404);
        }

        #localhost:81/descargaBancomer/Bancomer_5518721295_2017-07-24_095116_AsteriskRules/2017/07/24
        #return view('Bancomer.edicion.fechaAudio');

    }

}
