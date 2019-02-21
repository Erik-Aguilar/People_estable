<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\TmPreVenta;
use App\Model\TmPosVenta;
use App\Model\ActiveUser;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MyEventsController extends Controller {

    public function VentasPre() {
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $count = TmPreVenta::where('active', 1)->count();

        $response->setCallback(
                function() {
            echo "retry: 100\n\n"; // no retry would default to 3 seconds.
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            $time = date('r');
            $count = TmPreVenta::where('active', 1)->get()->toArray();
            ;
            /* echo "data: The server time is: {$count}\n\n"; */
            echo 'data: ' . json_encode($count) . "\n\n";
            flush();
        });
        $response->send();
    }

    public function VentasPos() {
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $count = TmPosVenta::where('active', 1)->count();

        $response->setCallback(
                function() {
            echo "retry: 100\n\n"; // no retry would default to 3 seconds.
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            $time = date('r');
            $count = TmPosVenta::where('active', 1)->get()->toArray();
            ;
            /* echo "data: The server time is: {$count}\n\n"; */
            echo 'data: ' . json_encode($count) . "\n\n";
            flush();
        });
        $response->send();
    }

    public function ValPreOnline() {
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $count = TmPreVenta::where('active', 1)->count();

        $response->setCallback(
                function() {
            echo "retry: 100\n\n"; // no retry would default to 3 seconds.
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            $match = ['puesto' => 'Validador', 'area' => 'TM Prepago'];
            $count = ActiveUser::where($match)->count();
            echo 'data: ' . $count . "\n\n";
            flush();
        });
        $response->send();
    }

    public function ValPosOnline() {
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $count = TmPreVenta::where('active', 1)->count();

        $response->setCallback(
                function() {
            echo "retry: 100\n\n"; // no retry would default to 3 seconds.
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            $match = ['puesto' => 'Validador', 'area' => 'TM Pospago'];
            $count = ActiveUser::where($match)->count();
            echo 'data: ' . $count . "\n\n";
            flush();
        });
        $response->send();
    }

    public function Val9() {

        // $response = new StreamedResponse();
        // $response->headers->set('Content-Type', 'text/event-stream');
        // $response->headers->set('Cache-Control', 'no-cache');
        //
        // $response->setCallback(
        //         function() {
        //     echo "retry: 1000\n\n"; // no retry would default to 3 seconds.
        //     header('Content-Type: text/event-stream');
        //     header('Cache-Control: no-cache');
        //     #$data = file_get_contents('http://192.168.10.9/agente/agent.php');
        //     // $data = "<note><to>Tove</to><from>Jani</from><heading>Reminder</heading><body>Don't forget me this weekend!</body></note>";
        //     $data = "";
        //     $xml = simplexml_load_string($data);
        //     $json = json_encode($xml);
        //     echo 'data: ' . "" . "\n\n";
        //     flush();
        // });
        // $response->send();
        return 'ok';
    }

    public function PcDialLlamadas() {

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');

        $response->setCallback(
                function() {

            # echo "retry: 100\n\n"; // no retry would default to 3 seconds.
            #$data = file_get_contents("http://192.168.10.1/tables.php");
            $data = "<note><to>Tove</to><from>Jani</from><heading>Reminder</heading><body>Don't forget me this weekend!</body></note>";
            $info1 = [];
            $datos = explode("|", $data);
            foreach ($datos as $info) {
                $num = explode(",", $info);
                if (array_key_exists(1, $num)) {
                    $info1[(int) $num[1]] = (string) $num[0];
                }
            }
            //$info1 [210] = "5577554441";
            //$info1 [212] = "5577554477";
            $json = json_encode($info1);
            if (true) {
                echo "retry: 100". PHP_EOL;
                echo 'data: ' . $json . PHP_EOL;
                echo PHP_EOL;
            }
            ob_end_flush();
            flush();
        });
        $response->send();
    }

    /*
      public function PcDialIps() {
      $data = file_get_contents('http://192.168.10.1/agente/direccion.php');
      $listas = explode(" ms)", $data);
      $reg=[];
      foreach ($listas as $lista) {
      $text= preg_replace('/[0-9][.][0-9]+/',"", $lista);
      $text = explode(" ", $text);
      $ip = str_replace(" ",'',str_replace($text, "", $lista));
      $ext = (int)preg_replace("/\/(.*)+/","",$lista);
      $ext != 0 ? $reg[$ext]=$ip : NULL ;
      }
      print_r($reg);
      /*
      $response = new StreamedResponse();
      $response->headers->set('Content-Type', 'text/event-stream');
      $response->headers->set('Cache-Control', 'no-cache');

      $response->setCallback(
      function() {
      echo "retry: 100\n\n"; // no retry would default to 3 seconds.
      header('Content-Type: text/event-stream');
      header('Cache-Control: no-cache');
      $data = file_get_contents('http://192.168.10.3/agente/direccion.php');
      $llamadas = explode("@from-internal/", $data);
      $info = [];
      $i=0;
      foreach ($llamadas as $llamada) {
      $x = explode("Dial(Local/", $llamada);
      if (array_key_exists(1, $x)) {
      $num = (float) (substr(str_replace('Local/', "", $x[0]), 0, 11) );
      $info [$x[1]]= (string)$num;
      $i++;
      }
      }
      //$info [1002]= '5576756450';
      $json=  json_encode($info);
      echo 'data: ' . $json . "\n\n";
      flush();
      });
      $response->send();

      } */

    public function ValPre() {

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');

        $response->setCallback(
                function() {
            echo "retry: 100\n\n"; // no retry would default to 3 seconds.
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');

            #$data1 = file_get_contents('http://192.168.10.1/agente/agent.php');
            $data1 = "<note><to>Tove</to><from>Jani</from><heading>Reminder</heading><body>Don't forget me this weekend!</body></note>";
            $xml1 = simplexml_load_string($data1);
            #$data2 = file_get_contents('http://192.168.10.2/agente/agent.php');
            $data2 = "<note><to>Tove</to><from>Jani</from><heading>Reminder</heading><body>Don't forget me this weekend!</body></note>";
            $xml2 = simplexml_load_string($data2);
            /*$data3 = file_get_contents('http://192.168.10.3/agente/agent.php');
            $xml3 = simplexml_load_string($data3);*/
            #$data4 = file_get_contents('http://192.168.10.4/agente/agent.php');
            $data = "<note><to>Tove</to><from>Jani</from><heading>Reminder</heading><body>Don't forget me this weekend!</body></note>";
            $xml4 = simplexml_load_string($data4);
            $arr['svr1'] = (int) $xml1->validacion;
            $arr['svr2'] = (int) $xml2->validacion;
            //$arr['svr3'] = (int) $xml3->validacion;
            $arr['svr4'] = (int) $xml4->validacion;
            $tot = array_sum($arr);

            //$json = json_encode($xml);
            echo 'data: ' . $tot . "\n\n";
            flush();
        });
        $response->send();
    }

    public function LoginCall($value = '') {
        $timeout = 5;
        $socket = fsockopen("13.85.24.249", "5038", $errno, $errstr, $timeout);
        fputs($socket, "Action: Login\r\n");
        fputs($socket, "UserName: rules\r\n");
        fputs($socket, "Secret: S1st3m4sr3l04D\r\n\r\n");
        return $socket;
    }

    public function LoginCallPrepago($value = '') {
        $timeout = 5;
        $socket = fsockopen("52.183.36.191", "5038", $errno, $errstr, $timeout);
        fputs($socket, "Action: Login\r\n");
        fputs($socket, "UserName: rules\r\n");
        fputs($socket, "Secret: S1st3m4sr3l04D\r\n\r\n");
        return $socket;
    }

    public function MonitorPrepago() {

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');

        $response->setCallback(
                function() {

                  $wrets = '';
                  $channel = '';
                  $socket = $this->LoginCallPrepago();
                  $text='';

                  fputs($socket, "Action: COMMAND\r\n");
                  fputs($socket, "command: queue show Temm\r\n\r\n");
                  fputs($socket, "Action: Logoff\r\n\r\n");
                  while (!feof($socket)) {
                      $wrets .= fread($socket, 500);
                  }
                  fclose($socket);

                  $data = explode("\r\n\r\n", $wrets);
                  $data = explode("\r\n", $data[2]);
                  $data = explode("\n", $data[2]);
                  foreach ($data as $key => $value) {
                    if(strpos($value, 'Unavailable')===false ){
                      if (strpos($value, 'Invalid')===false) {
                        if (strpos($value, 'wrandom')===false) {
                        $text.="<tr><td>".$value."</td></tr>";
                        }
                      }
                    }
                  }
                  #dd($text);
                  #$json = json_encode($data);

            echo "retry: 10000\n\n"; // no retry would default to 3 seconds.
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            echo 'data: ' . $text . "\n\n";
            ob_flush();
            flush();
        });
        $response->send();
    }

    public function MonitorInbursa() {

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');

        $response->setCallback(
                function() {

                  $wrets = '';
                  $channel = '';
                  $socket = $this->LoginCall();
                  $text='';

                  fputs($socket, "Action: COMMAND\r\n");
                  fputs($socket, "command: queue show Inbursa\r\n\r\n");
                  fputs($socket, "Action: Logoff\r\n\r\n");
                  while (!feof($socket)) {
                      $wrets .= fread($socket, 500);
                  }
                  fclose($socket);

                  $data = explode("\r\n\r\n", $wrets);
                  $data = explode("\r\n", $data[2]);
                  $data = explode("\n", $data[2]);
                  foreach ($data as $key => $value) {
                    if(strpos($value, 'Unavailable')===false ){
                      if (strpos($value, 'Invalid')===false) {
                        if (strpos($value, 'wrandom')===false) {
                        $text.="<tr><td>".$value."</td></tr>";
                        }
                      }
                    }
                  }
                  #dd($text);
                  #$json = json_encode($data);

            echo "retry: 10000\n\n"; // no retry would default to 3 seconds.
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            echo 'data: ' . $text . "\n\n";
            ob_flush();
            flush();
        });
        $response->send();
    }

}
