<?php
session_start();
include("seguridad.php");
?>
<html>
<head>
<title>Agricola Paredes :: Validación de XML</title>
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
      		<span id="date">Hola, <?php  echo $_SESSION['user']; ?></span>
      		<div style="width:6%;float:right;margin: 27px -274px;"><a href="inicio.php"><img src="img/volver.png"/></a></div>
			<ul>
				<li class="logout" id="cerrar"><a href="logout.php">Cerrar sesi&oacute;n</a></li>
				<div class="clear"></div>		
			</ul>         				
		</div>
		<div class="main">  
    		<div class="wrap"> 
    			<div class="column_left">
    				<center>
    					<h1>Secci&oacute;n en construcci&oacute;n</h1>
    					<img src="img/progress.gif"/>
    				</center>
    			</div>
    		</div>
    	</div>  					     
	</div>
</body>
</html>