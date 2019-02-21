<?php 
$h="localhost";
$u="root";
$p="";
$l=mysql_connect($h,$u,$p) or die ("Error ".mysql_error());
$bd="people";
mysql_select_db($bd,$l) or die ("BD");
?>