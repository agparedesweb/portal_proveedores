<?php
session_start();
include("security.php");
@$id=$_GET["id"];
@$msg=$_GET["msg"];
//$conexion = mysql_connect("127.0.0.1", "root", "12345");
$conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
$date = date_create();
//var_dump($_POST['oc']);
$i=0;

mysql_select_db("tspvcomm_proveedores", $conexion);
/*$conexion = mysql_connect("127.0.0.1", "root", "");
$date = date_create(); 
mysql_select_db("system_validator", $conexion);*/
$row= array();
$row['CORDENCOMPRA']="";
$row['CRELACIONADO']="";


if($msg==1){
    $msg1="No hay ordenes de compra para mostrar";
}
elseif($msg==2){
    $msg1="Reactivación realizada con Éxito";
}
elseif($msg==3){
    $msg1="Debe escribir al menos un parametro";
}



?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<title>Agricola Paredes :: Validaci&oacute;n de XML</title>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/nav.css" rel="stylesheet" type="text/css" media="all"/>
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
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
        var flag=document.getElementById("oc");
        if (flag.checked == true){
            document.getElementById("orden").style.display = "inline-block";    
        }
        else{
            document.getElementById("orden").style.display = "none";       
        }
        
    }
</script>
<script type="text/javascript">
    function traeOrdenes(prmProveedor,prmOrden){
        var prmGuzman=0;
        var prmNota=0;
        if( $('#ocguzman').prop('checked') ) {
            //alert("seleccionado");
            prmGuzman=1;
        }
        if( $('#notac').prop('checked') ) {
            //alert("seleccionado");
            prmNota=1;
        }
        
        $.ajax({
            url: 'traeordenes.php',
            type: "POST",
            data: "prmProveedor="+prmProveedor+"&prmOrden="+prmOrden+"&prmGuzman="+prmGuzman+"&prmNota="+prmNota,
            success: function(datos){
                $("#restable").html(datos);
            },
            error: function(jq,status,message) {
                console.log('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
            }
        });
    }

    function updRegistro(prmOrden,prmRenglon) {
            var prmNota=0;
            if( $('#notac').prop('checked') ) {
                //alert("seleccionado");
                prmNota=1;
            }
                           
            if(confirm("¿Desea activar esta orden de compra?")){
                $.ajax({
                    url: 'updOrden.php',
                    type: "POST",
                    data: "prmOrden="+prmOrden+"&prmNota="+prmNota,
                    success: function(datos){
                        //alert(datos);
                        if (datos==1) {
                            alert("Orden de compra activada");
                            //alert(datos);
                            var tr = $('#'+prmRenglon).closest('tr');
                            tr.fadeOut(400, function(){
                                tr.remove();
                            });    
                        }
                        
                        //return false;*/
                    },
                    error: function(jq,status,message) {
                        console.log('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
                    }
                }); 
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
    			
                    <table border="1">
                        <tr>
                            <td class="searchright"><h2>Clave Proveedor</h2></td>
                            <td class="searchright"><input type="checkbox" id="oc" name="oc" value="oc" onclick="displayIn()" ><label>Orden de compra</label></td>
                            <td class="searchright"><input type="checkbox" id="ocguzman" name="ocguzman" value="ocguzman" ><label>Cd. Guzm&aacute;n</label></td>
                            <td class="searchright"><input type="checkbox" id="notac" name="notac" value="nota"><label>Nota de cr&eacute;dito</label></td>
                        </tr>
                        <tr>
                            <td class="searchright"><input id="rfc" class="inpreactiva" name="cProveedor" value="<?php echo @$_POST['cProveedor']; ?>" type="text"></input></td>
                            <td colspan="2" class="searchright"><input id="orden" class="inpreactiva" name="orden" value="<?php echo @$_POST['orden']; ?>" type="text"></input><button class="buscar" onclick="traeOrdenes($('#rfc').val(),$('#orden').val())">Buscar</button></td>

                        </tr>
                    </table>
                    
    				
    			<br>
                <table id="consulta" border="1" bordercolor="#666666" style="border-collapse:collapse;">
                    <tr style="font-weight:bold;">
                        <th>Orden de Compra</th>
                        <th>Estatus</th>
                        <th>Activar</th>
                    </tr>
                    <tbody id="restable"></tbody>
                </table>
                
                
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
        <center><a href="http://www.aparedes.com.mx" target="blank"><img style="width:32%" src="img/chiles.gif" alt="Agricola Paredes SA DE CV"/></a></center>
	</div>
	<div class="copy-right">
		<p><a href="http://www.aparedes.com.mx">&copy; 2014 Agricola Paredes SA de CV</a> </p>
 	</div>   
    
</body>
</html>