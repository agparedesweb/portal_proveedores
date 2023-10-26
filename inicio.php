<?php
session_start();
include("seguridad.php");?>
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
<script src="js/sweet-alert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="js/sweet-alert.css">
<script type="text/javascript" src="js/moment.js"></script>
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
      		<a href="https://www.aparedes.com.mx" target="_blank"><img id="logo" src="img/logo2.png"></a>
      		<span id="date">Hola, <?php  echo $_SESSION['user']; ?></span>
      		<ul>
				<li class="logout" id="cerrar"><a href="logout.php">Cerrar sesi&oacute;n</a></li>
				<div class="clear"></div>		
			</ul>         				
		</div>	  					     
	</div>
	    <div class="main">  
	    	<div class="wrap"> 
	    		<div id="datos_xml">
		      			<h2>Nuestros datos fiscales</h2>
		  	    		<table style="width:100%">
	  	    				<tr>
								<td><span>RFC:</span><div class="clear"></div></td>
								<td><span>APA9707035N4</span><div class="clear"></div></td>
							</tr>
							<tr>
								<td id="linea"><span>Raz&oacute;n Social:</span><div class="clear"></div></td>
								<td id="linea"><span>AGRICOLA PAREDES S.A.P.I. DE C.V.</span><div class="clear"></div></td>
							</tr>
							<tr>
								<td><span>Calle:</span><div class="clear"></div></td>
								<td><span>PASEO NI&Ntilde;OS HEROES ORIENTE</span><div class="clear"></div></td>
							</tr>
							<tr>
								<td id="linea"><span>N&uacute;mero Exterior:</span><div class="clear"></div></td>
								<td id="linea"><span>520</span><div class="clear"></div></td>
							</tr>
							<tr>
								<td><span>N&uacute;mero Interior:</span><div class="clear"></div></td>
								<td><span>302</span><div class="clear"></div></td>
							</tr>					
							<tr>
								<td id="linea"><span>Colonia:</span><div class="clear"></div></td>
								<td id="linea"><span>CENTRO</span><div class="clear"></div></td>
							</tr>
							<tr>
								<td><span>Municipio:</span><div class="clear"></div></td>
								<td><span>CULIACAN</span><div class="clear"></div></td>
							</tr>
							<tr>
								<td id="linea"><span>Estado:</span><div class="clear"></div></td>
								<td id="linea"><span>SINALOA</span><div class="clear"></div></td>
							</tr>
							<tr>
								<td><span>Pa&iacute;s:</span><div class="clear"></div></td>
								<td><span>MEXICO</span><div class="clear"></div></td>
							</tr>
							<tr>
								<td id="linea"><span>C&oacute;digo Postal:</span><div class="clear"></div></td>
								<td id="linea"><span>80000</span><div class="clear"></div></td>
							</tr>
						</table>
						<div style="width: 100%;background: #fff;">
							<span id="msg_xml">*El XML debe de ser creado con los datos fiscales exactamente como se muestran en la tabla anterior, de lo contrario ser&aacute;n rechazados autom&aacute;ticamente por el validador.</span>
						</div>
						
		  	    	</div>
		  	    <div class="column_left2">
	        		<table style="width: 69%;text-align: center;float:right;">
						<tr>
							<td><span><a href="index.php"><div id="chile"></div></a></span><div class="clear"></div></td>
							<td><span><a href="consulta_trans.php"><div id="tomate"></div></a></span><div class="clear"></div></td>
						</tr>
						<tr>
							<td><span><a id="carga" href="index.php">Carga de Comprobantes<p style="font-size: 17px;">(Facturas, notas de cr&eacute;dito)</p></a></span><div class="clear"></div></td>
							<td><span><a id="carga" href="consulta_trans.php">Consulta de Comprobantes</a></span><div class="clear"></div></td>
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
</body>
</html>

