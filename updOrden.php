<?php
@session_start();
/*Incluimos el fichero de la clase*/
	$conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
	//$conexion = mysql_connect("127.0.0.1", "root", "12345");
	$date = date_create(); 
	mysql_select_db("tspvcomm_proveedores", $conexion);
	$prmOrden=$_POST['prmOrden'];
	$prmNota=$_POST['prmNota'];
	$cadena="";
	//echo $prmOrdenes;
    
	$crelacionado=($prmNota==1 ? "CRELACIONADONC" : "CRELACIONADO");
	
    $consulta = "UPDATE inv_ocpendientes SET ".$crelacionado."='N' WHERE CORDENCOMPRA='".$prmOrden."'";
    
    mysql_query($consulta)or die ("Error");
    echo 1;
       
        /*if($totalRows==0){
            header("location: reactivaoc.php?msg=1");
        }    
    }
    else{
        header("location: reactivaoc.php?msg=3");
    }*/
	

	
	


?>