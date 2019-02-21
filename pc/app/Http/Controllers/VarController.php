<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

use App\Http\Requests;

class VarController extends Controller
{
    //
    public function __construct() {
        
        $data = file_get_contents('http://192.168.10.3/agente/direccion.php');
        $listas = explode(" ms)", $data);
        $reg=[];
        foreach ($listas as $lista) {
            $text= preg_replace('/[0-9][.][0-9]+/',"", $lista);
            $text = explode(" ", $text);
            $ip = str_replace(" ",'',str_replace($text, "", $lista));
            $ext = (int)preg_replace("/\/(.*)+/","",$lista);
            $ext != 0 ? $reg[$ext]=$ip : NULL ;
        }
        
        View::share ( 'ip', $reg );        
        
    }
}
