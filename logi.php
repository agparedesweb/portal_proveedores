<?php
date_default_timezone_set('America/Chihuahua');
$datetime = date_create()->format('Y-m-d H:i:s');
//$conexion = mysql_connect("127.0.0.1", "root", "12345");
$conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
$date = date_create(); 
mysql_select_db("tspvcomm_proveedores", $conexion);
/*
$date = date_create(); 
mysql_select_db("tspvcomm_proveedores", $conexion);*/
$dia=date("l");

require_once("lib/nusoap.php");

if($_POST['user'] && $_POST['pass']) {
	
     $sql="SELECT nombre FROM users WHERE id='".$_POST['user']."' AND password='".md5($_POST['pass'])."'";
     $rfc="SELECT id FROM users WHERE id='".$_POST['user']."' AND password='".md5($_POST['pass'])."'";
     $correo="SELECT correo FROM users WHERE id='".$_POST['user']."' AND password='".md5($_POST['pass'])."'";
     $fletero="SELECT id,cve_proveedor FROM users WHERE id='".$_POST['user']."' AND password='".md5($_POST['pass'])."' AND fletero=1";
     
     $cve_prov="SELECT id,cve_proveedor FROM users WHERE id='".$_POST['user']."' AND password='".md5($_POST['pass'])."'";
     $oc_update="UPDATE users a JOIN tmpusers b ON a.id = b.id SET a.COBLIGAOC = b.COBLIGAOC WHERE trim(a.id)='".trim($_POST['user'])."'";
     $oc_obligatorio="SELECT COBLIGAOC FROM users WHERE trim(id)='".trim($_POST['user'])."'";
     $vcCuliacan="SELECT U.id FROM `users` U JOIN `inv_ocpendientes` O ON O.CCVE_PROVEEDOR=U.cve_proveedor WHERE O.cSucursal='001' AND trim(U.id)='".trim($_POST['user'])."' LIMIT 1";
     $vcCdguzman="SELECT U.id FROM `users` U JOIN `inv_ocpendientes` O ON O.CCVE_PROVEEDOR=U.cve_proveedor WHERE O.cSucursal='003' AND trim(U.id)='".trim($_POST['user'])."' LIMIT 1";
     $res_oc=mysql_query($oc_update,$conexion) or die ("Error actualizando oc");     
     $resultado=mysql_query($sql, $conexion) or die ("Error");
     $res=mysql_query($rfc, $conexion) or die ("Error con el rfc");
     
     $res_mail=mysql_query($correo, $conexion) or die ("Error con el correo");
     $flet=mysql_query($fletero, $conexion) or die ("Error con el fletero");
     $oco=mysql_query($oc_obligatorio, $conexion) or die ("Error con el usuario con orden de compra obligatoria");
     $prov=mysql_query($cve_prov, $conexion) or die ("Error con el proveedor");
     $vResCuliacan=mysql_query($vcCuliacan, $conexion) or die ("Error con el usuario Culiacan");
     $vResCdguzman=mysql_query($vcCdguzman, $conexion) or die ("Error con el usuario Cd. Guzman");
     $trailero=mysql_result($flet,0,0);
     $oc_required=mysql_result($oco,0,0);
     $trans=mysql_result($flet,0,1);
     $cve=mysql_result($prov,0,1);
     $numRegistros=mysql_num_rows($resultado);
     $vnRegculiacan=mysql_num_rows($vResCuliacan);
     $vnRegcdguzman=mysql_num_rows($vResCdguzman);
     if($numRegistros==0) {
        header("location: log.php?error=1");
    } else {
        session_start();
        $_SESSION["autentica"] = "OK"; 
        $_SESSION["user"] = mysql_result($resultado,0,0); 
        $_SESSION["rfc"] = mysql_result($res,0,0); 
        
        $_SESSION["correo"] = mysql_result($res_mail,0,0); 
        $_SESSION["fecha"] = date("Y/m/d H:i:s");
        $_SESSION["trans"] = $trans;//variable de sesion de clave de proveedor de transportista
        $_SESSION["cve_pro"] = $cve;
        $_SESSION["oc_r"]= $oc_required;
        $_record_xml = "INSERT INTO logs (id,fecha) VALUES ('".trim($_SESSION["rfc"])."','".trim($_SESSION["fecha"])."')";
        mysql_query($_record_xml);
        if(trim($_POST['user'])=='kareli'){
            $_SESSION["security"] = "OK";
            header("location: consulta_int.php");
        }
        elseif(trim($_POST['user'])=='arturopp'){
            $_SESSION["security"] = "OK";
            header("location: consulta_intfact.php");
        }
        elseif(trim($_POST['user'])==trim($trailero)) {
            header("location: inicio.php");
        }
        else{
            if($oc_required=='S'){
                if($dia=="Saturday" or $dia=="Friday"){
                //if($dia=="Monday"){
                    header("location: http://www.aparedes.com.mx/proveedores/standby/"); 
                    $_SESSION["autentica"] = "NO";                   
                }
                else{
                    if ($vnRegculiacan>0 and $vnRegcdguzman>0) {
                        $_SESSION["sucursal"]="";
                        $_SESSION["bScursal"]=1;
                        header("location: seleccionasucursal.php");      
                    }else{
                        if($vnRegculiacan>0){
                            $_SESSION["sucursal"]="001";
                        }elseif ($vnRegcdguzman>0) {
                            $_SESSION["sucursal"]="003";
                        }
                        else{
                            $_SESSION["sucursal"]="001";
                        }

                        $temp="SELECT CCVE_TEMPORADA FROM CTL_TEMPORADAS WHERE NACTIVO=1 AND CSUCURSAL='".$_SESSION["sucursal"]."'";
                        $restemp=mysql_query($temp, $conexion) or die ("Error con la temporada");
                        $_SESSION["temporada"] = mysql_result($restemp,0,0); 

                        header("location: seleccionasucursal.php");      
                    }
                }
            }else{
                if ($vnRegculiacan>0 and $vnRegcdguzman>0) {
                    $_SESSION["sucursal"]="";
                    $_SESSION["bScursal"]=1;
                    header("location: seleccionasucursal.php");      
                }else{
                    if($vnRegculiacan>0){
                        $_SESSION["sucursal"]="001";
                    }elseif ($vnRegcdguzman>0) {
                        $_SESSION["sucursal"]="003";
                    }
                    else{
                        $_SESSION["sucursal"]="001";
                    }

                    $temp="SELECT CCVE_TEMPORADA FROM CTL_TEMPORADAS WHERE NACTIVO=1 AND CSUCURSAL='".$_SESSION["sucursal"]."'";
                    $restemp=mysql_query($temp, $conexion) or die ("Error con la temporada");
                    $_SESSION["temporada"] = mysql_result($restemp,0,0); 

                    header("location: seleccionasucursal.php");
                }        
            }    
        }
    }
}
else{
    header("location: log.php?error=2");
}
?>