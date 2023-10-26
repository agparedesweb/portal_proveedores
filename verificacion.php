<?php
session_start();
$errors=array();
$errors[0]="";
$errors[1]="";
$errors[2]="";
$errors[3]="";
$errors[4]="";
$errors[5]="";
$errors[6]="";
$errors[7]="";
$errors[8]="";
$errors[9]="";
$validos=array();
$validos[0]="";
$validos[1]="";
$validos[2]="";
$validos[3]="";
$validos[4]="";
$validos[5]="";
$validos[6]="";
$validos[7]="";
$validos[8]="";
$validos[9]="";
$nombre=array();
$nombre[0]="";
$nombre[1]="";
$nombre[2]="";
$nombre[3]="";
$nombre[4]="";
$nombre[5]="";
$nombre[6]="";
$nombre[7]="";
$nombre[8]="";
$nombre[9]="";
//palomeamos los xml validos
if(isset($_SESSION['validos']))
{
	$xml_validos=$_SESSION['validos'];
	$xml_v=$_SESSION["nom_xml_val"];
	for($i=0;$i<=count($xml_validos)-1;$i++) 
	{
		$nom=$xml_v[$i];
		$valor=$xml_validos[$i];
		$validos[$valor]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/ok.png' alt=''/><span>XML V&aacute;lido</span></a></li></ul></div>";
		$nombre[$valor]=$nom;
	}
	unset($_SESSION['validos']);	
}
//comprobamos que no existan UUID duplicados, esto con el fin de evitar una doble validacion del XML
if(isset($_SESSION['e']))
{
	$error_uuid=$_SESSION['e'];
	$xml_uuid=$_SESSION["nom_uuid"];
	for($i=0;$i<=count($error_uuid)-1;$i++) 
	{
		$nom=$xml_uuid[$i];
		$valor=$error_uuid[$i];
		$errors[$valor]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/warning.png' alt=''/><span>UUID ya existente</span></a></li></ul></div>";
		$nombre[$valor]=$nom;
	}
	unset($_SESSION['e']);	
}
//comprobamos que el xml corresponda de acuerdo al rfc logueado
if(isset($_SESSION['erfc']))
{
	$error_rfc=$_SESSION['erfc'];
	$xml_rfc=$_SESSION["nom_erfc"];
	for($i=0;$i<=count($error_rfc)-1;$i++) 
	{
		$nom=$xml_rfc[$i];
		$valor=$error_rfc[$i];
		$errors[$valor]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/warning.png' alt=''/><span>Tu RFC no corresponde al XML enviado</span></a></li></ul></div>";
		$nombre[$valor]=$nom;
	}
	unset($_SESSION['erfc']);	
}
//comprobamos que el xml corresponda al rfc de la agricola
if(isset($_SESSION['agricolarfc']))
{
	$error_rfc=$_SESSION['agricolarfc'];
	$xml_rfc=$_SESSION["nom_agricola_erfc"];
	for($i=0;$i<=count($error_rfc)-1;$i++) 
	{
		$nom=$xml_rfc[$i];
		$valor=$error_rfc[$i];
		$errors[$valor]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/warning.png' alt=''/><span>Nuestro RFC no corresponde al que contiene su XML cargado</span></a></li></ul></div>";
		$nombre[$valor]=$nom;
	}
	unset($_SESSION['agricolarfc']);	
}
//comprobamos que sea solo una orden de compra seleccionada
if(isset($_SESSION['ocduplic']))
{
	$error_ocduplic=$_SESSION['ocduplic'];
	$xml_ocduplic=$_SESSION["nom_ocduplic"];
	for($i=0;$i<=count($error_ocduplic)-1;$i++) 
	{
		$nom=$xml_ocduplic[$i];
		$valor=$error_ocduplic[$i];
		$errors[$valor]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/warning.png' alt=''/><span>Haz seleccionado la misma orden de compra para esta factura, favor de verificar.</span></a></li></ul></div>";
		$nombre[$valor]=$nom;
	}
	unset($_SESSION['ocduplic']);	
}

//comprobamos que existan errores de direccion de receptor del XML
if(isset($_SESSION['e_dir']))
{
	$error_dir=$_SESSION['e_dir'];
	$xml_dir=$_SESSION["nom_dir"];
	for($i=0;$i<=count($error_dir)-1;$i++) 
	{
		$nom=$xml_dir[$i];
		$valor=$error_dir[$i];
		$errors[$valor]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/warning.png' alt=''/><span>Verifica nuestros datos de recepci&oacute;n fiscales del archivo</span></a></li></ul></div>";
		$nombre[$valor]=$nom;
	}
	unset($_SESSION['e_dir']);
}
//Comprobamos que existan errores del XML validado ante el SAT
if(isset($_SESSION['e_xml']))
{
	$error_xml=$_SESSION['e_xml'];
	$posicion=$_SESSION['posicion'];
	$xml_i=$_SESSION["nom_xml_inv"];
	for($i=0;$i<=count($xml_i)-1;$i++) 
	{
		$nom=$xml_i[$i];
		$pos=$posicion[$i];
		$valor=$error_xml[0];
		$errors[$pos]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/warning.png' alt=''/><span>".$valor."</span></a></li></ul></div>";
		$nombre[$pos]=$nom;
	}
	unset($_SESSION['e_xml']);
}
//comprobamos que la forma de pago del CFDI corresponda con la orden de compra
if(isset($_SESSION['eformaPago']))
{
	$error_formaPago=$_SESSION['eformaPago'];
	$xml_formaPago=$_SESSION["nom_eformaPago"];
	for($i=0;$i<=count($error_formaPago)-1;$i++) 
	{
		$nom=$xml_formaPago[$i];
		$valor=$error_formaPago[$i];
		$errors[$valor]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/warning.png' alt=''/><span>La forma de pago de tu CFDI no coincide con la de la orden de compra seleccionada</span></a></li></ul></div>";
		$nombre[$valor]=$nom;
	}
	unset($_SESSION['eformaPago']);	
}
//comprobamos que el metodo de pago del CFDI corresponda con la orden de compra
if(isset($_SESSION['emetPago']))
{
	$error_metodoPago=$_SESSION['emetPago'];
	$xml_metodoPago=$_SESSION["nom_emetPago"];
	for($i=0;$i<=count($error_metodoPago)-1;$i++) 
	{
		$nom=$xml_metodoPago[$i];
		$valor=$error_metodoPago[$i];
		$errors[$valor]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/warning.png' alt=''/><span>El metodo de pago de tu CFDI no coincide con el de la orden de compra seleccionada</span></a></li></ul></div>";
		$nombre[$valor]=$nom;
	}
	unset($_SESSION['emetPago']);	
}

//comprobamos que el uso del CFDI corresponda con la orden de compra
if(isset($_SESSION['eusoCfdi']))
{
	$error_usoCfdi=$_SESSION['eusoCfdi'];
	$xml_usoCfdi=$_SESSION["nom_eusoCfdi"];
	for($i=0;$i<=count($error_usoCfdi)-1;$i++) 
	{
		$nom=$xml_usoCfdi[$i];
		$valor=$error_usoCfdi[$i];
		$errors[$valor]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/warning.png' alt=''/><span>El uso del CFDI no coincide con el de la orden de compra seleccionada</span></a></li></ul></div>";
		$nombre[$valor]=$nom;
	}
	unset($_SESSION['eusoCfdi']);	
}

//Verificamos que carguen archivos de acuerdo asu extension .XML
/*if(isset($_SESSION['empty_xml']))
{
	$empty_xml=$_SESSION['empty_xml'];
	$sin_xml=$_SESSION["nombre_sin_xml"];
	for($i=0;$i<=count($empty_xml)-1;$i++) 
	{
		$nom=$sin_xml[$i];
		if(!$nom==""){
			$valor=$empty_xml[$i];
			$validos[$valor]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/warning.png' alt=''/><span>No es un archivo XML</span></a></li></ul></div>";
			$nombre[$valor]=$nom;			
		}
		
	}
	unset($_SESSION['empty_xml']);	
}
//Verificamos que carguen archivos de acuerdo asu extension .PDF
if(isset($_SESSION['error_pdf']) && isset($_SESSION['empty_xml']))
{
	$error_pdf=$_SESSION['error_pdf'];
	$sin_pdf=$_SESSION["nombre_sin_pdf"];
	$sin_xml=$_SESSION["nombre_sin_xml"];
	for($i=0;$i<=count($error_pdf)-1;$i++) 
	{
		$nom_pdf=$sin_pdf[$i];
		$nom_xml=$sin_xml[$i];
		echo $nom_pdf."<br>".$nom_xml;
		if($nom_pdf!="" && $nom_xml=="" || $nom_pdf=="" && $nom_xml!="" ) {
			$valor=$error_pdf[$i];
			$validos[$valor]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/warning.png' alt=''/><span>Falta Archivo</span></a></li></ul></div>";
			$nombre[$valor]="Existe un error en uno de tus archivos";
		}
		elseif ($nom_pdf=="" && $nom_xml==""){
			echo "1";
		}else{
			$valor=$error_pdf[$i];
			$validos[$valor]="<div class='tool_tip'><ul class='tt-wrapper'><li><a class='tt-sample' href='#''><img src='img/warning.png' alt=''/><span>Error de Archivo</span></a></li></ul></div>";
			$nombre[$valor]="Existe un error en uno de tus archivos";
		}		
	}
	unset($_SESSION['error_pdf']);	
}*/
?>
<div style="float:right;"><img src="img/logo2.png" width="14%"/></div>
<table style="width: 100%;text-align: center;">
<tr>
	<td><span>Nombre</span><div class="clear"></div></td>
	<td><span>Verificaci&oacute;n</span><div class="clear"></div></td>
</tr>
<tr>
	<td><span><?php echo $nombre[0]?></span><div class="clear"></div></td>
	<td><span><?php echo $errors[0];?><?php echo $validos[0];?></span><div class="clear"></div></td>
</tr>	
<tr>
	<td><span><?php echo $nombre[1]?></span><div class="clear"></div></td>
	<td><span><?php echo $errors[1];?><?php echo $validos[1];?></span><div class="clear"></div></td>
</tr>	
<tr>
	<td><span><?php echo $nombre[2]?></span><div class="clear"></div></td>
	<td><span><?php echo $errors[2];?><?php echo $validos[2];?></span><div class="clear"></div></td>
</tr>	
<tr>
	<td><span><?php echo $nombre[3]?></span><div class="clear"></div></td>
	<td><span><?php echo $errors[3];?><?php echo $validos[3];?></span><div class="clear"></div></td>
</tr>	
<tr>
	<td><span><?php echo $nombre[4]?></span><div class="clear"></div></td>
	<td><span><?php echo $errors[4];?><?php echo $validos[4];?></span><div class="clear"></div></td>
</tr>	
<tr>
	<td><span><?php echo $nombre[5]?></span><div class="clear"></div></td>
	<td><span><?php echo $errors[5];?><?php echo $validos[5];?></span><div class="clear"></div></td>
</tr>	
<tr>
	<td><span><?php echo $nombre[6]?></span><div class="clear"></div></td>
	<td><span><?php echo $errors[6];?><?php echo $validos[6];?></span><div class="clear"></div></td>
</tr>	
<tr>
	<td><span><?php echo $nombre[7]?></span><div class="clear"></div></td>
	<td><span><?php echo $errors[7];?><?php echo $validos[7];?></span><div class="clear"></div></td>
</tr>	
<tr>
	<td><span><?php echo $nombre[8]?></span><div class="clear"></div></td>
	<td><span><?php echo $errors[8];?><?php echo $validos[8];?></span><div class="clear"></div></td>
</tr>	
<tr>
	<td><span><?php echo $nombre[9]?></span><div class="clear"></div></td>
	<td><span><?php echo $errors[9];?><?php echo $validos[9];?></span><div class="clear"></div></td>
</tr>							
</table>
