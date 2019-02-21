<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$data1 = file_get_contents('http://192.168.10.1/agente/agent.php');
$data2 = file_get_contents('http://192.168.10.2/agente/agent.php');
$data3 = file_get_contents('http://192.168.10.3/agente/agent.php');
$data4 = file_get_contents('http://192.168.10.4/agente/agent.php');
$data5 = file_get_contents('http://192.168.10.5/agente/agent.php');
$data7 = file_get_contents('http://192.168.10.7/agente/agent.php');
$xml1 = simplexml_load_string($data1);
$xml2 = simplexml_load_string($data2);
$xml3 = simplexml_load_string($data3);
$xml4 = simplexml_load_string($data4);
$xml5 = simplexml_load_string($data5);
$xml7 = simplexml_load_string($data7);
$exp=[];
$array=(array)$xml1;
$ch1=(int)$array['channels'];
$exp['sv1']=$ch1;

$array=(array)$xml2;
$ch2=(int)$array['channels'];
$exp['sv2']=$ch2;

$array=(array)$xml3;
$ch3=(int)$array['channels'];
$exp['sv3']=$ch3;

$array=(array)$xml4;
$ch4=(int)$array['channels'];
$exp['sv4']=$ch4;

$array=(array)$xml5;
$ch5=(int)$array['channels'];
$exp['sv5']=$ch5;

$array=(array)$xml7;
$ch7=(int)$array['channels'];
$exp['sv7']=$ch7;

$sum = $ch1+$ch2+$ch3+$ch4+$ch5+$ch7;
$exp['sum']=$sum;
$json=json_encode($exp);

echo "retry: 1"."\n\n";
echo "data:".$json ."\n\n";
flush();
?>
