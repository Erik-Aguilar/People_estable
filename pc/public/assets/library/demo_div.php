<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$data = file_get_contents('http://192.168.10.1/agente/agent.php');
$xml = simplexml_load_string($data);
$exp=[];
$array=(array)$xml;
$dis=(int)$array['numdisponibles'];
$exp['Disponibles']=$dis;

$llama=(int)$array['numllamada'];
$exp['Llamada']=$llama;


$div = ($dis/$llama)*100;
$exp['divicion']=$div;
$json=json_encode($exp);

echo "retry: 1"."\n\n";
echo "data:".$json ."\n\n";
flush();
?>
