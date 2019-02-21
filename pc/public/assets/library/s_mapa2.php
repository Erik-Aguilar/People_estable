<?php
include 'cx.php';

//print_r($_POST);

foreach($_POST as $key=>$val){
    if(strlen($key)==6){
       
        $maquina=$rest = substr($key,-3);
        $fila= substr($key, -4,1);
        $sql_1="update mapa set pc='$val' where fila='$fila' and maquina='$maquina'";
        mysql_query($sql_1) or die (mysql_error());
        
       // echo $sql_1."<br>";
        
    }
    
    if(strlen($key)==9){
    
        $maquina=$rest = substr($key, -3);
        $fila= substr($key, -4,1);
        $sql_1="update mapa set llama='$val' where fila='$fila' and maquina='$maquina'";
        mysql_query($sql_1) or die (mysql_error());
        
      //  echo $sql_1."<br>";
        
    }
    
    
   if(strlen($key)==11){
        $tipo=$rest = substr($key, 0,-4);
        
        if($tipo=="elastix"){
        $maquina=$rest = substr($key,-3);
        $fila= substr($key, -4,1);
        $sql_1="update mapa set elastix='$val' where fila='$fila' and maquina='$maquina'";
      //  echo $sql_1."<br>";
        mysql_query($sql_1) or die (mysql_error());
        }

        if($tipo=="diadema"){
        $maquina=$rest = substr($key, -3);
        $fila= substr($key, -4,1);
        $sql_1="update mapa set diadema='$val' where fila='$fila' and maquina='$maquina'";
     //   echo $sql_1."<br>";
        mysql_query($sql_1) or die (mysql_error());    
        }
   }
       /*-----------------------------------*/
       if(strlen($key)==7){
       
        $maquina=$rest = substr($key,-3);
        $fila= substr($key, -5,2);
        $sql_1="update mapa set pc='$val' where fila='$fila' and maquina='$maquina'";
        mysql_query($sql_1) or die (mysql_error());
        
      //  echo $sql_1."<br>";
        
    }
    
    if(strlen($key)==10){
    
        $maquina=$rest = substr($key, -3);
        $fila= substr($key, -5,2);
        $sql_1="update mapa set llama='$val' where fila='$fila' and maquina='$maquina'";
        mysql_query($sql_1) or die (mysql_error());
        
      // echo $sql_1."<br>";
        
    }
    
    
   if(strlen($key)==12){
        $tipo=$rest = substr($key, 0,-5);
        
        if($tipo=="elastix"){
        $maquina=$rest = substr($key,-3);
        $fila= substr($key, -5,2);
        $sql_1="update mapa set elastix='$val' where fila='$fila' and maquina='$maquina'";
     //   echo $sql_1."<br>";
        mysql_query($sql_1) or die (mysql_error());
        }

        if($tipo=="diadema"){
        $maquina=$rest = substr($key, -3);
        $fila= substr($key, -5,2);
        $sql_1="update mapa set diadema='$val' where fila='$fila' and maquina='$maquina'";
    //    echo $sql_1."<br>";
        mysql_query($sql_1) or die (mysql_error());    
        }
    }
}

$sql="SELECT * FROM mapa
WHERE pc ='red' OR llama ='red' OR diadema ='red' OR elastix ='red' order by cuando desc";
$datos=mysql_query($sql,$l);
$num_rojos = mysql_num_rows($datos);


$sql2 = "INSERT INTO notificacion (num_maquinas) VALUES ('$num_rojos')";
mysql_query($sql2,$l);

//header('Location: ../forms/mapa2.php');
echo "<script>
location.href='../zona2.php';
</script>";
?>
