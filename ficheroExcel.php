<?php
header("Content-type: application/vnd.ms-excel;");
header("Content-Disposition: filename=facturas.xls");
header("Pragma: no-cache");
header('Cache-Control: max-age=0');
header("Expires: 0");

echo $_POST['datos_a_enviar'];
?>