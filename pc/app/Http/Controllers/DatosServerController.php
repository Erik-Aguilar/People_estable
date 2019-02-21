<?php

namespace App\Http\Controllers;

use Illuminate\Http\request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class DatosServerController extends Controller
{

	public function DatosServidor1()
	{
		$responde = new StreamedResponse();
		$responde->headers->set('Content-Type','text/event-stream');
		$responde->headers->set('Cache-Control', 'no-cache');

		$responde->setCallback(
			function(){
				header('Content-Type: text/event-stream');
				header('Cache-Control: no-cache');

				$servidor = file_get_contents('http://192.168.10.1/agente/agent.php');
				#$servidor = file_get_contents('http://localhost:80/xml/prueba1.xml');
				
				$conectados = file_get_contents('http://192.168.10.1/agente/direccion.php');
				#$conectados = file_get_contents('http://localhost:80/xml/agen1.html');

				$Agentes=explode("\n",$conectados);
				$ContadorAgentes=count($Agentes);
				for($i=0;$i<$ContadorAgentes;$i++)
				{
					$AgentesFiltrados[$i]=substr($Agentes[$i],0,3);
				}
				array_unshift($AgentesFiltrados, "\n<total>");
				array_push($AgentesFiltrados, "</total>");
				$conectadosFiltrado=implode(",",$AgentesFiltrados);
				$filtrado=substr_replace($servidor,$conectadosFiltrado, 12,0);
				$caracteres=array("\n","\t"," ","");
				$filtrado2=str_replace($caracteres,"",$filtrado);
				$filtrado3=str_replace("-","_",$filtrado2);
				$xml=simplexml_load_string($filtrado3);
				$json=json_encode($xml);
				echo "data:{$json}\n\n";
				flush();
			});
		$responde->send();
	}
	public function DatosServidor2()
	{
		$responde = new StreamedResponse();
		$responde->headers->set('Content-Type','text/event-stream');
		$responde->headers->set('Cache-Control', 'no-cache');

		$responde->setCallback(
			function(){
				header('Content-Type: text/event-stream');
				header('Cache-Control: no-cache');

				$servidor = file_get_contents('http://192.168.10.2/agente/agent.php');
				#$servidor = file_get_contents('http://localhost:8080/xml/prueba2.xml');
				
				$conectados = file_get_contents('http://192.168.10.2/agente/direccion.php');
				#$conectados = file_get_contents('http://localhost:8080/xml/agen2.html');

				$Agentes=explode("\n",$conectados);
				$ContadorAgentes=count($Agentes);
				for($i=0;$i<$ContadorAgentes;$i++)
				{
					$AgentesFiltrados[$i]=substr($Agentes[$i],0,3);
				}
				array_unshift($AgentesFiltrados, "\n<total>");
				array_push($AgentesFiltrados, "</total>");
				$conectadosFiltrado=implode(",",$AgentesFiltrados);
				$filtrado=substr_replace($servidor,$conectadosFiltrado, 12,0);
				$caracteres=array("\n","\t"," ","");
				$filtrado2=str_replace($caracteres,"",$filtrado);
				$filtrado3=str_replace("-","_",$filtrado2);
				$xml=simplexml_load_string($filtrado3);
				$json=json_encode($xml);
				echo "data:{$json}\n\n";
				flush();
			});
		$responde->send();
	}

public function DatosServidor3()
	{
		$responde = new StreamedResponse();
		$responde->headers->set('Content-Type','text/event-stream');
		$responde->headers->set('Cache-Control', 'no-cache');

		$responde->setCallback(
			function(){
				header('Content-Type: text/event-stream');
				header('Cache-Control: no-cache');

				$servidor = file_get_contents('http://192.168.10.3/agente/agent.php');
				#$servidor = file_get_contents('http://localhost:8080/xml/prueba2.xml');
				
				$conectados = file_get_contents('http://192.168.10.3/agente/direccion.php');
				#$conectados = file_get_contents('http://localhost:8080/xml/agen2.html');

				$Agentes=explode("\n",$conectados);
				$ContadorAgentes=count($Agentes);
				for($i=0;$i<$ContadorAgentes;$i++)
				{
					$AgentesFiltrados[$i]=substr($Agentes[$i],0,3);
				}
				array_unshift($AgentesFiltrados, "\n<total>");
				array_push($AgentesFiltrados, "</total>");
				$conectadosFiltrado=implode(",",$AgentesFiltrados);
				$filtrado=substr_replace($servidor,$conectadosFiltrado, 12,0);
				$caracteres=array("\n","\t"," ","");
				$filtrado2=str_replace($caracteres,"",$filtrado);
				$filtrado3=str_replace("-","_",$filtrado2);
				$xml=simplexml_load_string($filtrado3);
				$json=json_encode($xml);
				echo "data:{$json}\n\n";
				flush();
			});
		$responde->send();
	}
	public function DatosServidor4()
	{
		$responde = new StreamedResponse();
		$responde->headers->set('Content-Type','text/event-stream');
		$responde->headers->set('Cache-Control', 'no-cache');

		$responde->setCallback(
			function(){
				header('Content-Type: text/event-stream');
				header('Cache-Control: no-cache');

				$servidor = file_get_contents('http://192.168.10.4/agente/agent.php');
				#$servidor = file_get_contents('http://localhost:8080/xml/prueba2.xml');
				
				$conectados = file_get_contents('http://192.168.10.4/agente/direccion.php');
				#$conectados = file_get_contents('http://localhost:8080/xml/agen2.html');

				$Agentes=explode("\n",$conectados);
				$ContadorAgentes=count($Agentes);
				for($i=0;$i<$ContadorAgentes;$i++)
				{
					$AgentesFiltrados[$i]=substr($Agentes[$i],0,3);
				}
				array_unshift($AgentesFiltrados, "\n<total>");
				array_push($AgentesFiltrados, "</total>");
				$conectadosFiltrado=implode(",",$AgentesFiltrados);
				$filtrado=substr_replace($servidor,$conectadosFiltrado, 12,0);
				$caracteres=array("\n","\t"," ","");
				$filtrado2=str_replace($caracteres,"",$filtrado);
				$filtrado3=str_replace("-","_",$filtrado2);
				$xml=simplexml_load_string($filtrado3);
				$json=json_encode($xml);
				echo "data:{$json}\n\n";
				flush();
			});
		$responde->send();
	}
	

	public function vista($numeroServidor){
		return view('template.main',['servidor'=>$numeroServidor]);
	}


    
}
