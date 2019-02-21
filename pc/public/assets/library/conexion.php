<?php 
$h="localhost";
$u="root";
$p="S1st3m4sP3c0new";
$l=mysql_connect($h,$u,$p) or die ("Error ".mysql_error());
$bd="people_mapa";
mysql_select_db($bd,$l) or die ("BD");
?>