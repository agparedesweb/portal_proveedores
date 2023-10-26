<?php
session_start();
include("security.php");
$id=$_SESSION['rfc'];
$conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
//$conexion = mysql_connect("127.0.0.1", "root", "12345");
$date = date_create(); 
mysql_select_db("tspvcomm_proveedores", $conexion);
/*$conexion = mysql_connect("127.0.0.1", "root", "");
$date = date_create(); 
mysql_select_db("system_validator", $conexion);*/

$row= array();
$row['folio_interno']="";
$row['folio_uuid']="";
$row['nombre_xml']="";
$row['date(reg.fecha)']="";
$row['valido']="";
$row['errores']="";
$query="";
if(isset($_POST['buscar'])){
	$rfc=$_POST['rfc'];
	$desde=$_POST['desde'];
	$hasta=$_POST['hasta'];	
	$query=mysql_query("SELECT reg.folio_interno,reg.folio_uuid, reg.nombre_xml, date(reg.fecha), reg.valido,reg.errores FROM records_xml as reg inner join users as usu on reg.rfc =usu.id WHERE date(reg.fecha) BETWEEN '".$desde."' AND '".$hasta."' AND reg.rfc='".$rfc."'");
	$totalRows = mysql_num_rows($query);
	$row = mysql_fetch_assoc($query);
	$filas=0;
} 

?>
<html>
<head>
<title>Agricola Paredes :: Validaci&oacute;n de XML</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/nav.css" rel="stylesheet" type="text/css" media="all"/>
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<script type="text/javascript" src="js/Chart.js"></script>
<script type="text/javascript" src="js/jquery.easing.js"></script>
<script type="text/javascript" src="js/jquery.ulslide.js"></script>
<script type="text/javascript" src="js/bootstrap-filestyle.js"> </script>
<!----Calender -------->
<script src="js/underscore-min.js"></script>
<script src= "js/moment-2.2.1.js"></script>
<script src="js/clndr.js"></script>
<script src="js/site.js"></script>
<!----End Calender -------->
<script>
	$(":file").filestyle({buttonBefore: true});
</script>
<script src="js/sweet-alert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="js/sweet-alert.css">
<script type="text/javascript" src="js/moment.js"></script>
<script language="javascript">
$(document).ready(function() {
    $(".botonExcel").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#consulta").eq(0).clone()).html());
        $("#FormularioExportacion").submit();
});
});
</script>
<style type="text/css">
.bg1{
	background: #dedede;
}
.bg2{
	background: #7B7A7A;
}
#FormularioExportacion{
    width: 90%;
    margin: 0 auto;
    padding: 8px;
}
.botonExcel{
    cursor:pointer;
}
</style>
</head>
<body>			       
    <div class="wrap">	 
        <div class="header">
      		<a href="http://www.aparedes.com.mx" target="_blank"><img id="logo" src="img/logo2.png"></a>
      		<span id="date">Hola, <?php  echo $_SESSION['user']; ?></span>
      		<ul>
				<li class="logout" id="cerrar"><a href="logout.php">Cerrar sesi&oacute;n</a></li>
                <div class="clear"></div>		
			</ul>
            <ul>
                <li class="logout" id="cerrar" style="margin-top: 0.5em;"><a href="reactivaoc.php">Reactivar Ordenes de Compra</a></li>
                <div class="clear"></div>       
            </ul> 
            <ul>
                <li class="logout" id="cerrar" style="margin-top: 0.5em;"><a href="delinvoice.php">Eliminar Facturas</a></li>
                <div class="clear"></div>       
            </ul>               				
		</div>	  					     
	</div>
    <div class="main">  
    	<div class="wrap"> 
    		<div class="column_left">
    			<form action="consulta_int.php" method="post">
    				<h2>Buscador</h2>
    				<input id="rfc" name="rfc" type="text"></input>
    				<input id="desde" name="desde" value="<?php echo date_format($date,'Y-m-d') ?>" type="date"></input>
    				<input id="hasta" name="hasta" value="<?php echo date_format($date,'Y-m-d') ?>" type="date"></input>
    				<input type="submit" class="buscar" name="buscar" value="Buscar" onclick="mostrar()"></input>
    			</form><br>
    			<table id="consulta" border="1" bordercolor="#666666" style="border-collapse:collapse;">
    				<tr style="font-weight:bold;">
                        <td>Factura</td>
    					<td>Folio UUID</td>
    					<td>Nombre</td>
    					<td>Fecha</td>
    					<td>Respuesta</td>
    				</tr>
    				<?php do{?>
    				<?php $fila=@$filas/2;?>
    				<?php if (is_int($fila)) { $estilo = 'bg1'; } else { $estilo = 'bg2'; }?>
    				<tr class="<?php echo $estilo;?>">
                        <td><?php echo @$row['folio_interno']?></td>
    					<td style="width: 31%;"><?php echo $row['folio_uuid']?></td>
    					<td><?php echo $row['nombre_xml']?></td>
    					<td><?php echo $row['date(reg.fecha)']?></td> 
    					<?php if ($row['valido']==1){?>
    						<td>XML V&aacute;lido</td>
    					<?php }else{ ?>
    						<td style="width: 27%;"><?php echo $row['errores']?></td>	
    					<?php } ?>				
    				</tr>
    				<?php @$filas++; }while (@$row = mysql_fetch_assoc($query));?>
    				
	    		</table>
                <form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
                    <img src="img/excel.png" style="width:5%;" class="botonExcel" />
                <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                </form>
        	</div> 
	  		<div id="popup">
				<a href="#" id="close"><img src="img/error.png" /></a>
				<div id="cpopup"></div>
			</div>            
    		<div class="clear"></div>
			</div>
	</div>
	<div>
        <center><a href="http://www.aparedes.com.mx" target="blank"><img style="width:32%" src="img/chiles.gif" alt="Agricola Paredes SA DE CV"/></a></center>
	</div>
	<div class="copy-right">
		<p><a href="http://www.aparedes.com.mx">&copy; 2014 Agricola Paredes SAPI de CV</a> </p>
 	</div>   
</body>
</html>