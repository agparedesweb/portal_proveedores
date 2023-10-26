<?php
session_start();
include("seguridad.php");
if (@$_SESSION["sucursal"]=="") {
	$_SESSION["sucursal"]=@$_GET['prmSucursal'];	
}


?>
<html>
<head>
<title>Agricola Paredes :: Validacion de XML</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/nav.css" rel="stylesheet" type="text/css" media="all"/>
<link href='https://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function() {
	var now = moment().format("DD-MMM-YYYY, h:MM A");
	//$('#date').append(now);
});
</script>
</head>
<body>			       
    <div class="wrap">	 
        <div class="header">
      		<img id="logo" src="img/logo2.png">
      		<div id="prueb">      			
      			<span id="date">Hola, <?php  echo $_SESSION['user']; ?></span>
      			<?php if(@$_SESSION["bScursal"]==1){ ?>
      				<a id="cerrar" href="seleccionasucursal.php">Regresar</a>
      			<?php }?>
				<a id="cerrar" href="logout.php">Cerrar sesi&oacute;n</a>
				<div class="clear"></div>	
      		</div>
		</div>	  					     
	</div>
	    <div class="main">  
	    	<div class="wrap"> 
	    	
		  	    <div class="column_left2">
	        		<table style="width: 100%;text-align: center;float:right;">
						<tr>
							<td><span><a href="index-normal.php"><div id="chile"></div></a></span><div class="clear"></div></td>
							<td><span><a href="notas.php"><div id="nota"></div></a></span><div class="clear"></div></td>
							<td><span><a href="consulta.php"><div id="tomate"></div></a></span><div class="clear"></div></td>
						</tr>
						<tr>
							<td><span><a id="carga" href="index-normal.php">Carga de Comprobantes</a></span><div class="clear"></div></td>
							<td><span><a id="carga" href="notas.php">Notas de cr&eacute;dito</a></span><div class="clear"></div></td>
							<td><span><a id="carga" href="consulta.php">Consulta de Comprobantes</a></span><div class="clear"></div></td>
						</tr>
					</table>
	  			</div> 
		  		<div id="popup">
					<a href="#" id="close"><img src="img/error.png" /></a>
					<div id="cpopup"></div>
				</div>            
	    		<div class="clear"></div>
 			</div>
    	</div>
    	<!--<div>
    		<center><img style="width:70%" src="img/chiles.gif"/></center>
    	</div>-->

  		<div class="copyright text-center">
  			<p>&#191;Tienes alg&uacute;n problema&#63; envianos un correo a la siguiente direcci&oacute;n: <a href="mailto:soporte@aparedes.com.mx">soporte@aparedes.com.mx</a><br>Tel&eacute;fono de asistencia: (667) 760 35 40 Ext.28</p>
			<p><a href="https://www.aparedes.com.mx">&copy; 2014 Agricola Paredes S.A.P.I. de C.V.</a> </p>
	 	</div>
 	<script type="text/javascript">
 		window.onload = function(){
 			var cCorreo="";
 			Swal.fire({
			  	title: "Información",
			  	html: "Estimados proveedores es necesario que envien sus complementos de pago al correo de <u>complementosdepago@aparedes.com.mx</u>, de antemano muchas gracias.",
			  	icon: "info",
			  	button: "Aceptar",
			});
 			
 		}
 	</script>   
</body>
</html>
