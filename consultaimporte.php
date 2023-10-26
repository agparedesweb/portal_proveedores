<?php
session_start();
include("seguridad.php");
$id = $_SESSION['rfc'];
/*$conexion = mysql_connect("localhost", "root", "12345");
mysql_select_db("tspvcomm_proveedores", $conexion);*/
$conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
mysql_select_db("tspvcomm_proveedores", $conexion);
header("Content-Type: text/html; charset=utf-8");
$ordenCompra = $_GET['prmOrden'];
$query = mysql_query("SELECT sum(nimporte) as 'IMPORTE' FROM `records_xml` WHERE orden_compra='".$ordenCompra."'");
$totalRows = mysql_num_rows($query);
$row = mysql_fetch_assoc($query);
$resultado = (empty($row['IMPORTE'])) ? 0 : $row['IMPORTE'];
echo $resultado;
?>
