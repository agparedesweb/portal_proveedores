<?php
	date_default_timezone_set('America/Chihuahua');
    $conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
    $date = date_create(); 
    mysql_select_db("tspvcomm_proveedores", $conexion);
        header("Content-Type: text/html; charset=utf-8");

    	$id=trim($_POST['rfc']);
        $password=md5(trim($_POST['password']));
        $correo=trim($_POST['email']);
        $fecha_ultsol=date_format($date, 'Y-m-d');
        $nombre=trim($_POST['nombre']);
        $cve_proveedor=str_pad(trim($_POST['cve']), 6,'0',STR_PAD_LEFT);

        $_record_xml = "INSERT INTO users (id,password,correo,fecha_ultsol,nombre,cve_proveedor,fletero,COBLIGAOC) VALUES ('".$id."','".$password."','".$correo."','".$fecha_ultsol."','".$nombre."','".$cve_proveedor."',0,'N')";
        mysql_query($_record_xml);
        if(isset($_POST['email'])) 
        {

            // Debes editar las próximas dos líneas de código de acuerdo con tus preferencias
            $email_to = $_POST['email'];
            $email_subject = "Agricola Paredes S.A.P.I. de C.V.";

            // Aquí se deberían validar los datos ingresados por el usuario
            if(!isset($_POST['rfc']) ||
            !isset($_POST['nombre']) ||
            !isset($_POST['password']) ||
            !isset($_POST['email']) ||
            !isset($_POST['cve'])) {

            echo "<b>Ocurrió un error y el formulario no ha sido enviado. </b><br />";
            echo "Por favor, vuelva atrás y verifique la informacion ingresada<br />";
            die();
            }

            //$email_message = "Te hemos registrado en nuestro nuevo portal para la validación de los XML de tus facturas.\n\nTu usuario: " . $_POST['rfc'] . "\nTu contraseña: " . $_POST['password'] . "\n\nPor su atención.\nGracias";
            $email_message ="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
            $email_message .="<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'/><meta name='viewport' content='width=device-width, initial-scale=1.0'/><title>Agricola ";
            $email_message .="Paredes</title><style type='text/css'>body {margin: 10px 0; padding: 0 10px; background: #F9F2E7; font-size: 13px;}table {border-collapse: collapse;}td {font-family: arial, ";
            $email_message .="sans-serif; color: #333333;}@media only screen and (max-width: 480px) {body,table,td,p,a,li,blockquote {-webkit-text-size-adjust:none !important; }table {width: 100% !important;}.responsive-image img {height: auto !important; max-width: 50% !important; width: 100% !important; }}</style>";
            $email_message .="<link rel='stylesheet' type='text/css' href='http://www.aparedes.com.mx/style.css'></head><body><table align='center' border='0' cellpadding='0' cellspacing='0' width='100%'";
            $email_message .="class='m_4937552155386437015templateContainer' style='border-collapse:collapse;border:0;max-width:640px!important'><tbody><tr><td><table border='0' cellpadding='0' ";
            $email_message .="cellspacing='0' bgcolor='#FFFFFF'><tbody><tr><td bgcolor='#52bf90' style='font-size:0;line-height:0;padding:0 10px' height='140' align='center' class='";
            $email_message .="m_4937552155386437015responsive-image'><img src='http://www.aparedes.com.mx/paredes.png' alt='Agricola Paredes' class='CToWUd'></td></tr><tr><td style='font-size:0;line-";
            $email_message .="height:0' height='30'>&nbsp;</td></tr><tr><td style='padding:10px 10px 20px 10px'><div style='font-size:20px'>Agricola Paredes</div><br><div><p>Estimado proveedor hemos ";
            $email_message .="dado de alta tu cuenta en nuestro portal con la cual podras cargar tus facturas para iniciar con el proceso de revision y pagos.<br><br><b>Usuario: ".$_POST['rfc'] ."</b><br><b>Contrase&ntilde";
            $email_message .=";a: ".$_POST['password']."</b><br><br>Adjunto una liga con la cual podras descargar una guia de apoyo para cargar los archivos en el portal.<br><a href='http://www.aparedes.com.";
            $email_message .="mx/proveedores/documents/Manual%20de%20Usuario%20para%20Portal%20de%20XML%20de%20Agricola%20Paredes%20SA%20de%20CV%20v2.0.pdf' download>Guia de Apoyo</a><br><br>Saludos  </p";
            $email_message .="></div></td></tr><tr><td style='font-size:0;line-height:0' height='1' bgcolor='#F9F9F9'>&nbsp;</td></tr><tr><td style='font-size:0;line-height:0' height='30'>&nbsp;</td>";
            $email_message .="</tr><tr><td bgcolor='#52bf90'><table border='0' cellpadding='0' cellspacing='0' width='100%'><tbody><tr><td style='font-size:0;line-height:0' height='15'>&nbsp;</td>";
            $email_message .="</tr><tr><td style='padding:0 10px;color:black;font-weight:bold'>Agricola Paredes S.A.P.I. De C.V.</td></tr><tr><td style='font-size:0;line-height:0' height='15'>&nbsp;</td>";
            $email_message .="</tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></body></html>";
            // Ahora se envía el e-mail usando la función mail() de PHP
            $email_from="noreply@aparedes.com.mx";
            $headers = 'From: '.$email_from."\r\n".
            'Reply-To: '.$email_from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            @mail($email_to, $email_subject, $email_message, $headers);

            //echo "El formulario se ha enviado con &eacute;xito!";
           header("location: proveedor.php?msg=1");
   
        }

?>

