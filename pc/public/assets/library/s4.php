<?php
include '../mapalib/cx.php';

$hora_inicio = $_POST['hora_inicio'];
$hora_final = $_POST['hora_final'];
$num_server = $_POST['num_server'];
$causa = $_POST['causa'];

 //print_r($_POST);

$q = "INSERT INTO `caidas`(`hora_inicio`, `hora_final`, `num_server`, `causa`) VALUES ('$hora_inicio','$hora_final','$num_server','$causa')";
$q2=mysql_query($q) or die (mysql_error());

echo "<script>  location.href = '../servidor4.php'; </script>";

?>



