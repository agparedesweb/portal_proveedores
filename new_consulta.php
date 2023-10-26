<?php
session_start();
$id=$_SESSION['rfc'];
$conexion = mysql_connect("localhost", "tspvcomm", "ParedeS@123:)");
$date = date_create(); 
mysql_select_db("tspvcomm_proveedores", $conexion);
	$desde=$_POST['desde'];
	$hasta=$_POST['hasta'];	
	$query=mysql_query("SELECT reg.folio_uuid, reg.nombre_xml, reg.fecha, reg.valido,reg.errores FROM records_xml as reg inner join users as usu on reg.rfc ='".$id."'  WHERE fecha BETWEEN '".$desde."' AND '".$hasta."'");
	$totalRows = mysql_num_rows($query);
	echo $totalRows,"<br>";
	$row = mysql_fetch_row($query);
	var_dump($row);
	if($_POST['buscar']) 
        {
        	echo "string";
        }
        else{
        	echo "2";
        }
?>