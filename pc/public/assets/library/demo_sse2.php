<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$data = file_get_contents('http://192.168.10.2/agente/agent.php');
$xml = simplexml_load_string($data);
$json=json_encode($xml);
echo "data:".$json ."\n\n";
flush();
?>