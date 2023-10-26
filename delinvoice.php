<?php
session_start();
include("security.php");
@$id=$_GET["id"];
@$msg=$_GET["msg"];
$conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
$date = date_create(); 
mysql_select_db("tspvcomm_proveedores", $conexion);
/*$conexion = mysql_connect("127.0.0.1", "root", "");
$date = date_create(); 
mysql_select_db("system_validator", $conexion);*/
$row= array();
$row['nombre']="";
$row['folio_uuid']="";
$row['folio_interno']="";
if(isset($_POST['eliminar'])){
    if(!empty($_POST['check_list'])) 
    {
        foreach($_POST['check_list'] as $uuid) 
        {
            $consulta = "DELETE FROM `records_xml` WHERE valido=0 AND folio_uuid='".$uuid."'";
            mysql_query($consulta)or die ("Error");
            header("location: delinvoice.php?msg=2");
        }
    }    
}

if($msg==1){
    $msg1="No hay resultados que mostrar";
}
elseif($msg==2){
    $msg1="Eliminación realizada con Éxito";
}
elseif($msg==3){
    $msg1="Debe escribir al menos un parametro";
}
//$query="";
if(isset($_POST['buscar'])){
    if(isset($_POST['cProveedor'])!="" Or isset($_POST['uuid'])!=""){
        
        $query="SELECT u.nombre,r.folio_uuid,r.folio_interno FROM records_xml as r join users as u on u.id=r.rfc WHERE r.valido=0";
        if($_POST['cProveedor']!=""){
            $cProveedor=$_POST['cProveedor'];
            $query=$query . " and u.cve_proveedor='".str_pad($cProveedor,  6, "0",STR_PAD_LEFT)."'";    
        }
        if($_POST['uuid']!=""){
            $cUuid=$_POST['uuid'];
            $query=$query . " and r.folio_uuid like'%".$cUuid."%'";   
        }
        $res=mysql_query($query)or die ("Error");;
        $totalRows = mysql_num_rows($res);
        $row = mysql_fetch_assoc($res);
        $filas=0;
        if($totalRows==0){
            header("location: delinvoice.php?msg=1");
        }    
    }
    else{
        header("location: delinvoice.php?msg=3");
    }
    
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
<script>
function displayIn() {
    var flag=document.getElementById("displayinput");
    if (flag.checked == true){
        document.getElementById("uuid").style.display = "inline-block";    
    }
    else{
        document.getElementById("uuid").style.display = "none";       
    }
    
}
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
                <li class="logout" id="cerrar" style="margin-top: 0.5em;"><a href="consulta_int.php">Regresar</a></li>
                <div class="clear"></div>       
            </ul>     				
		</div>	  					     
	</div>
    <div class="main">  
    	<div class="wrap"> 
    		<div class="column_left">
    			<form id="busqueda2" action="delinvoice.php" method="post">
    				<h2>Clave Proveedor</h2>
    				<input id="rfc" name="cProveedor" value="<?php echo @$_POST['cProveedor']; ?>" type="text"></input>
                    <input type="checkbox" id="displayinput" name="displayinput" value="<?php echo @$_POST['displayinput']; ?>" onclick="displayIn()" ><label>Filtrar por UUID</label>
                    <input id="uuid" name="uuid" value="<?php echo @$_POST['uuid']; ?>" type="text"></input>          
                    <input type="submit" class="buscar" name="buscar" value="Buscar"></input>
    			</form><br>
                <form action="delinvoice.php" method="post">
    			<table id="consulta" border="1" bordercolor="#666666" style="border-collapse:collapse;">
    				<tr style="font-weight:bold;">
                        <td>Proveedor</td>
                        <td>Folio UUID</td>
    					<td>Folio Interno</td>
    					<td>Acción</td>
    				</tr>
    				<?php do{?>
    				<?php $fila=@$filas/2;?>
    				<?php if (is_int($fila)) { $estilo = 'bg1'; } else { $estilo = 'bg2'; }?>
    				<tr class="<?php echo $estilo;?>">
                        <td><?php echo @$row['nombre']?></td>
                        <td><?php echo @$row['folio_uuid']?></td>
    					<td><?php echo @$row['folio_interno']?></td>
                        <td><input type="checkbox" name="check_list[]" value="<?php echo @$row['folio_uuid'];?>"><td> 
    				</tr>
    				<?php @$filas++; }while (@$row = mysql_fetch_assoc($res));?>
    				
	    		</table>
                <input type="submit" id="btnval" name="eliminar" value="Eliminar">
                
                </form>
                <p style="text-align: center;padding: 2em;font-size: 1.5em;"><?php echo @$msg1;?></p>
        	</div> 
	  		<div id="popup">
				<a href="#" id="close"><img src="img/error.png" /></a>
				<div id="cpopup"></div>
			</div>            
    		<div class="clear"></div>
			</div>
	</div>
	<div>
        <center><a href="http://www.aparedes.com.mx" target="blank"><img style="width:32%" src="img/chiles.gif" alt="Agricola Paredes SAPI DE CV"/></a></center>
	</div>
	<div class="copy-right">
		<p><a href="http://www.aparedes.com.mx">&copy; 2014 Agricola Paredes SAPI de CV</a> </p>
 	</div>   
</body>
</html>