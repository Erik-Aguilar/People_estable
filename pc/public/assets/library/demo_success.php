<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$data1 = file_get_contents('http://192.168.10.1/agente/success.php');
$data2 = file_get_contents('http://192.168.10.2/agente/success.php');
$data3 = file_get_contents('http://192.168.10.3/agente/success.php');
$data4 = file_get_contents('http://192.168.10.4/agente/success.php');
$data5 = file_get_contents('http://192.168.10.5/agente/success.php');
$data7 = file_get_contents('http://192.168.10.7/agente/success.php');
$xml1 = simplexml_load_string($data1);
$xml2 = simplexml_load_string($data2);
$xml3 = simplexml_load_string($data3);
$xml4 = simplexml_load_string($data4);
$xml5 = simplexml_load_string($data5);
$xml7 = simplexml_load_string($data7);
$exp=[];
$array=(array)$xml1;
$success1=(int)$array['successtot'];
$successmay1=(int)$array['successmay'];
$agentot1=(int)$array['agentot'];
$exp['succ1']=$success1;
$exp['succmay1']=$successmay1;
$exp['agent1']=$agentot1;

$array=(array)$xml2;
$success2=(int)$array['successtot'];
$successmay2=(int)$array['successmay'];
$agentot2=(int)$array['agentot'];
$exp['succ2']=$success2;
$exp['succmay2']=$successmay2;
$exp['agent2']=$agentot2;

$array=(array)$xml3;
$success3=(int)$array['successtot'];
$successmay3=(int)$array['successmay'];
$agentot3=(int)$array['agentot'];
$exp['succ3']=$success3;
$exp['succmay3']=$successmay3;
$exp['agent3']=$agentot3;

$array=(array)$xml4;
$success4=(int)$array['successtot'];
$successmay4=(int)$array['successmay'];
$agentot4=(int)$array['agentot'];
$exp['succ4']=$success4;
$exp['succmay4']=$successmay4;
$exp['agent4']=$agentot4;

$array=(array)$xml5;
$success5=(int)$array['successtot'];
$successmay5=(int)$array['successmay'];
$agentot5=(int)$array['agentot'];
$exp['succ5']=$success5;
$exp['succmay5']=$successmay5;
$exp['agent5']=$agentot5;


$array=(array)$xml7;
$success7=(int)$array['successtot'];
$successmay7=(int)$array['successmay'];
$agentot7=(int)$array['agentot'];
$exp['succ7']=$success7;
$exp['succmay7']=$successmay7;
$exp['agent7']=$agentot7;


$sumsuccess = $success1+$success2+$success3+$success4+$success5+$success7;
$sumseccessmay = $successmay1+$successmay2+$successmay3+$successmay4+$successmay5+$successmay7;
$sumagentot = $agentot1+$agentot2+$agentot3+$agentot4+$agentot5+$agentot7;
// $exp['sumsuccess']=$sumsuccess;
// $exp['sumseccessmay']=$sumseccessmay;
// $exp['sumagentot']=$sumagentot;


echo $sumsuccess;

?>
