<?php
//ini_set('display_errors', 1);
session_start();
require_once("createxml.php");
require("phpmailer/PHPMailerAutoload.php");
require_once("lib/nusoap.php");
$cSucursal = @$_SESSION["sucursal"];
class Multiupload
{
   /**
    *sube archivos al servidor a través de un formulario
    *@access public
    *@param array $files estructura de array con todos los archivos a subir
    */

    public function upFiles($pdfs = array(),$files = array(),$purcho = array())
    {
        //establecemos la conexion a la BD
        /*$conexion = mysql_connect("localhost", "root", "12345");
        $date = date_create(); 
        mysql_select_db("tspvcomm_proveedores", $conexion);*/
        $conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
        $date = date_create(); 
        mysql_select_db("tspvcomm_proveedores", $conexion);
        //inicializamos un contador para recorrer los archivos
        global $cSucursal;
        $doc = new DOMDocument(); 
        $vcPago = new Multiupload;
        unset($_SESSION['nom_xml_inv']);
        unset($_SESSION['nom_xml_val']);
        $i = 0;
        $k = 0;
        $email_to = $_SESSION["correo"];
        $email_subject = "Agricola Paredes SAPI de CV";
        $rfcAgricola='APA9707035N4';
        $vcJs="<script type='text/javascript'>";

        $counts = array_count_values($purcho);  

        //var_dump($ocarray);
 
        //si no existe la carpeta files la creamos
        if(!is_dir("recibidos/")) 
            mkdir("recibidos/", 0777);
         
        //recorremos los input files del formulario
        foreach($pdfs as $pdf) 
        {   
            if($_FILES['pdf']['name'][$k])
            {    
                foreach ($files as $file) 
                {
                    if($_FILES['xml']['name'][$k])
                    {
                        if ($cSucursal=="003") {
                            move_uploaded_file($_FILES['pdf']['tmp_name'][$k],"cdguzman/pdfs/".$_FILES['pdf']['name'][$k]);
                            //movemos los xml a la carpeta local de recibidos
                            move_uploaded_file($_FILES['xml']['tmp_name'][$k],"cdguzman/recibidos/".$_FILES['xml']['name'][$k]);
                        }else{
                            //movemos los pdf a la carpeta local pdfs
                            move_uploaded_file($_FILES['pdf']['tmp_name'][$k],"pdfs/".$_FILES['pdf']['name'][$k]);
                            //movemos los xml a la carpeta local de recibidos
                            move_uploaded_file($_FILES['xml']['tmp_name'][$k],"recibidos/".$_FILES['xml']['name'][$k]);
                        }
                        $dom = new DOMDocument('1.0', 'UTF-8');
                        if ($cSucursal=="003") {
                            $dom->load("cdguzman/recibidos/".$_FILES['xml']['name'][$k]);
                        }else{
                            $dom->load("recibidos/".$_FILES['xml']['name'][$k]);
                        }
                        
                        $cd = $dom->getElementsByTagName('TimbreFiscalDigital');
                        $emp = $dom->getElementsByTagName('Receptor');
                        $dir = $dom->getElementsByTagName('Domicilio');
                        $fol = $dom->getElementsByTagName('Comprobante');
                        $emisor = $dom->getElementsByTagName('Emisor');
                        $opt=$purcho[$k];
                        if($opt != ""){
                            $com = $dom->getElementsByTagName('Comprobante')->item(0);
                            $addenda=$dom->createElement('cfdi:Addenda');
                            $or_buy=$dom->createElement('cfdi:OrdenCompra');
                            $oc_attr = $dom->createAttribute("OrdenCompra");
                            $or_buy->appendChild($oc_attr);
                            $oc_item_value = $dom->createTextNode($opt);
                            $oc_attr->appendChild($oc_item_value);
                            $addenda->appendChild($or_buy);
                            $com->appendChild($addenda);                            
                        }
                        $j=0;
                        //$errores=array();
                        foreach($cd as $element)
                        {
                            foreach ($fol as $folio){
                                $fols = $folio->getAttribute('folio'); 
                                $serie = $folio->getAttribute('serie');
                                $tipo = strtolower($folio->getAttribute('TipoDeComprobante'));
                                $tipo=($tipo=="e" ? 'egreso' : 'ingreso');
                                $versionxml=$folio->getAttribute('version');
                                $folio_int=$serie.$fols; 
                                $nImporteTotal = $folio->getAttribute('Total');
                                $orden = $purcho[$k];
                                $rfc = $_SESSION['rfc'];
                                $fecha = $_SESSION['fecha'];
                                $nombre = $_FILES["xml"]['name'][$k];
                                $nombrexml = basename($_FILES['xml']['name'][$k],".xml");
                                $nombre_pdf = basename($_FILES['pdf']['name'][$k],".pdf");
                                $cadena = str_replace(' ', '', $nombrexml);
                                $orden2=str_replace(' ', '', $orden); 
                                $uuid = $element->getAttribute('UUID');
                                //copy("pdfs/".trim($rfc)."%".$uuid.".".$ext_pdf,"respaldo/".trim($rfc)."|".$uuid.".".$ext_pdf);
                                $sql = "SELECT * FROM records_xml WHERE folio_uuid='".$uuid."'";
                                $resultado=mysql_query($sql, $conexion) or die (mysql_error());
                                $numRegistros=mysql_num_rows($resultado);
                                foreach($emisor as $em){
                                    if($versionxml=="3.2"){
                                        $rfc_xml=$em->getAttribute('rfc');
                                    }else{
                                        $rfc_xml=$em->getAttribute('Rfc');
                                    }                                    
                                    if(trim($rfc_xml) == trim($rfc))
                                    {
                                        foreach($emp as $rec){
                                            if($versionxml=="3.2"){
                                                $rfc_xml_agricola=$rec->getAttribute('rfc');
                                            }else{
                                                $rfc_xml_agricola=$rec->getAttribute('Rfc');
                                            }                                            
                                            if(trim($rfc_xml_agricola) == trim($rfcAgricola))
                                            {
                                                //var_dump($orden);
                                                if($orden=="" or $counts[$orden]==1){
                                                    if($numRegistros==0) 
                                                    {   
                                                      if ($tipo == 'egreso') {
                                                         //$actualizaoc=$vcPago->fgActualizaOcPortal("2",$opt,$cSucursal);
                                                         $vcJs.="fgActualizaOcPortal('2','".$opt."','".$cSucursal."');";
                                                         //$actualizaoc=$vcPago->fgActualizaOcPortal("2",$opt,$cSucursal);
                                                         //$upd = "UPDATE inv_ocpendientes SET CRELACIONADONC='S' WHERE CORDENCOMPRA='$opt' and cSucursal='" . $cSucursal . "'";
                                                      } else {
                                                         //echo "entro";
                                                         //$actualizaoc=$vcPago->fgActualizaOcPortal("1",$opt,$cSucursal);
                                                         $vcJs.="fgActualizaOcPortal('1','".$opt."','".$cSucursal."');";
                                                      //$actualizaoc=$vcPago->fgActualizaOcPortal("1",$opt,$cSucursal);
                                                      //$upd = "UPDATE inv_ocpendientes SET CRELACIONADO='S' WHERE CORDENCOMPRA='$opt' and cSucursal='" . $cSucursal . "'";
                                                      }                                                      
                                                        //mysql_query($upd); 
                                                        /*if(count($purcho)>0){
                                                            foreach ($purcho as $opt){        
                                                                $upd = "UPDATE inv_ocpendientes SET CRELACIONADO='S' WHERE CORDENCOMPRA='$opt'";
                                                                mysql_query($upd);             
                                                            }    
                                                        }*/
                                                        //aqui empezamos a consumir el webservice
                                                        //Crear un cliente apuntando al script del servidor (Creado con WSDL)
                                                        $serverURL = 'https://www.clickfactura.com.mx/webservice/yii/validador/';
                                                        $cliente = new nusoap_client("$serverURL?wsdl", 'wsdl');
                                                        $xml64=file_get_contents("recibidos/".$_FILES['xml']['name'][$k]);
                                                        $DOC = new DOMDocument('1.0', 'utf-8');
                                                        $DOC->loadXML($xml64);
                                                        $xml64 = base64_encode($xml64);
                                                        $result['resultado'] = true;
                                                        /*$result = $cliente->call(
                                                                    //aqui se valida el XML
                                                                    "validarXml", // Funcion a llamar
                                                                    array(
                                                                        'Usuario'=>"APA9707035N4",
                                                                        'Pass'=>'validacionFacturas',
                                                                        'xmlData'=>$xml64,
                                                                    ), // Parametros pasados a la funcion   
                                                                    "uri:$serverURL/$serverScript", // namespace
                                                                    "uri:$serverURL/$serverScript/$metodoALlamar"// SOAPAction
                                                            );*/

                                                        if($result['resultado'] =="true"){
                                                            $name_xml=trim($rfc).'_'.$uuid.'.xml';
                                                            $name_pdf=trim($rfc).'_'.$uuid.'.pdf';
                                                            //var_dump($name_xml);
                                                            //var_dump($name_pdf);
                                                            //asignamos el nombre del xml a los pdfs
                                                            if ($cSucursal=="003") {
                                                                rename("cdguzman/pdfs/".$_FILES['pdf']['name'][$k],"cdguzman/pdfs/".$name_pdf);
                                                                copy("cdguzman/pdfs/".$name_pdf,"respaldo/cdguzman/".$name_pdf);
                                                            }else{
                                                                rename("pdfs/".$_FILES['pdf']['name'][$k],"pdfs/".$name_pdf);
                                                                copy("pdfs/".$name_pdf,"respaldo/".$name_pdf);
                                                            }
                                                            $_record_xml = "INSERT INTO records_xml (rfc,fecha,nombre_xml,folio_uuid,folio_interno,orden_compra,cSucursal,valido,errores,nimporte) VALUES ('$rfc','$fecha','$nombre','$uuid','$folio_int','$orden2','".$cSucursal."','1','',".$nImporteTotal.")";
                                                            mysql_query($_record_xml);     
                                                            //AQUI SE INSERTA LA NOTA DE CREDITO QUE SE GUARDA EN OTRA TABLA ESPERANDO SER TRASLADADA A RECORDS_XML
                                                            $record_xml_nota = "INSERT INTO records_xml (rfc, fecha, nombre_xml, folio_uuid, folio_interno, orden_compra, cSucursal, valido, errores, nimporte) ";
                                                            $record_xml_nota .= "SELECT `rfc`, `fecha`, `nombre_xml`, `folio_uuid`, `folio_interno`, `orden_compra`, `cSucursal`, `valido`, `errores`, `nimporte` FROM `records_xml_notas` WHERE `uuid_relacionado`='".$uuid."'";                                        
                                                            mysql_query($record_xml_nota);    
                                                            if($tipo=='egreso'){
                                                                if ($cSucursal=="003") {
                                                                    $dom->save("cdguzman/notas_validas/".$name_xml);
                                                                    //rename("recibidos/".$_FILES['xml']['name'][$k],"notas_validas/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml");
                                                                    copy("cdguzman/notas_validas/".$name_xml,"respaldo/cdguzman/".$name_xml); 
                                                                }else{
                                                                    // guarda xml con addenda
                                                                    $dom->save("notas_validas/".$name_xml);
                                                                    //rename("recibidos/".$_FILES['xml']['name'][$k],"notas_validas/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml");
                                                                    copy("notas_validas/".$name_xml,"respaldo/".$name_xml);    
                                                                }
                                                                
                                                            }
                                                            else{
                                                                if ($cSucursal=="003") {
                                                                    // guarda xml con addenda
                                                                    $dom->save('cdguzman/validos/'.$name_xml);
                                                                    copy("cdguzman/validos/".$name_xml,"respaldo/cdguzman/".$name_xml);    
                                                                }else{
                                                                    // guarda xml con addenda
                                                                    $dom->save('validos/'.$name_xml);
                                                                    copy("validos/".$name_xml,"respaldo/".$name_xml);    
                                                                }
                                                                
                                                            }                                        
                                                            $nom_val_xml[]=$nombre;
                                                            $_SESSION["nom_xml_val"]=$nom_val_xml;//se va formando arrays de nombres de xml
                                                            $xml_validos[]= $k;
                                                            $_SESSION["validos"] = $xml_validos;//enviamos 0 y 1 para ver quienes son los validos
                                                            echo $vcJs."</script>";
                                                            header("Refresh: 3; url=index-normal.php");
                                                            $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                                        }
                                                        else{
                                                            if(count($result['errores'])> 0){
                                                                $errores_xml=array();
                                                                echo "El xml presenta Errores"."<br>";
                                                                //foreach para obtener todos los errores
                                                                foreach ($result['errores'] as $error){
                                                                    $errors=$error['comentario'];
                                                                    $errores_xml[]= $errors;
                                                                    $_SESSION["e_xml"] = $errores_xml;
                                                                    $posicion[]=$k;
                                                                    $_SESSION["posicion"]= $posicion;
                                                                    header("Refresh: 3; url=index-normal.php");
                                                                    

                                                                }
                                                                if ($cSucursal=="003") {
                                                                    rename("cdguzman/pdfs/".$nombre_pdf,"cdguzman/pdfs_mal/".$nombre_pdf);
                                                                }else{
                                                                    rename("pdfs/".$nombre_pdf,"pdfs_mal/".$nombre_pdf);
                                                                }
                                                                
                                                                //INSERTAMOS ALA BASE DE DATOS EL XML NO VALIDO JUNTO CON LOS ERRORES
                                                                $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                                                $nom_error_xml[]=$nombre;
                                                                $_SESSION["nom_xml_inv"]=$nom_error_xml;
                                                                $xml_mal=$_SESSION["e_xml"][0];
                                                                
                                                                $_record_xml = "INSERT INTO records_xml (rfc,fecha,nombre_xml,folio_uuid,folio_interno,orden_compra,cSucursal,valido,errores,nimporte) VALUES ('$rfc','$fecha','$nombre','$uuid','$folio_int','$orden2','0','$xml_mal',".$nImporteTotal.")";
                                                                mysql_query($_record_xml); 
                                                                if($tipo=='egreso'){
                                                                    if ($cSucursal=="003") {
                                                                        rename("cdguzman/recibidos/".$_FILES['xml']['name'][$k],"cdguzman/notas_invalidas/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml");
                                                                    }else{
                                                                        rename("recibidos/".$_FILES['xml']['name'][$k],"notas_invalidas/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml");    
                                                                    }
                                                                    
                                                                }
                                                                else{
                                                                    if ($cSucursal=="003") {
                                                                        rename("cdguzman/recibidos/".$_FILES['xml']['name'][$k],"cdguzman/invalidos/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml"); 
                                                                    }else{
                                                                        rename("recibidos/".$_FILES['xml']['name'][$k],"invalidos/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml");     
                                                                    }
                                                                    
                                                                }
                                                            }
                                                        }
                                                        /*Direccion aqui va el codigo*/
                                                    }
                                                    else
                                                    {
                                                        //Aqui cachamos todos los errores de duplicidad de UUID de los xml y los enviamos al index
                                                        $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                                        $errores_uuid[]= $k;
                                                        $_SESSION["e"] = $errores_uuid; 
                                                        $nom_error_uuid[]=$nombre;
                                                        $_SESSION["nom_uuid"]=$nom_error_uuid;
                                                        header("Refresh: 3; url=index-normal.php");
                                                        echo"Entro2";
                                                    }
                                                }else{
                                                    //aqui caen los errores cuando seleccionan una orden de compra mas de una vez
                                                    $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                                    $errores_ocduplic[]= $k;
                                                    $_SESSION["ocduplic"] = $errores_ocduplic; 
                                                    $nom_error_ocduplic[]=$nombre;
                                                    $_SESSION["nom_ocduplic"]=$nom_error_ocduplic;
                                                    header("Refresh: 3; url=index-normal.php");
                                                }
                                            } 
                                            else{
                                                //aqui caen los errores cuando el rfc del xml no concuerda con el rfc de la agricola
                                                $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                                $errores_rfcagricola[]= $k;
                                                $_SESSION["agricolarfc"] = $errores_rfcagricola; 
                                                $nom_error_rfcagricola[]=$nombre;
                                                $_SESSION["nom_agricola_erfc"]=$nom_error_rfcagricola;
                                                header("Refresh: 3; url=index-normal.php");
                                                echo "no es el rfc de la agricola";
                                            }   
                                        }    
                                    }
                                    else
                                    {
                                        //aqui obtenemos los errores cuando el rfc no concuerde con el xml a subir
                                        $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                        $errores_rfc[]= $k;
                                        $_SESSION["erfc"] = $errores_rfc; 
                                        $nom_error_rfc[]=$nombre;
                                        $_SESSION["nom_erfc"]=$nom_error_rfc;
                                        header("Refresh: 3; url=index-normal.php");
                                    }
                                } 
                            }$j++;
                        }
                    }
                    else
                    {
                        echo "sin xml";
                    }
                    //incrementamos k de pdfs para recorrer array
                    $k++;                   
                }
            }
            else
            {
                //echo "sin pdf"; 
            }
            //incrementamos i de xmls para recorrer array
            $i++;
        }
        //var_dump($_SESSION['nom_xml_inv']);
        //var_dump($_SESSION["e_xml"]);

            //configuración de la clase
            $mail = new PHPMailer();
            $mail -> Host = 'mail.aparedes.com.mx';
            $mail -> IsHTML (true);
            $mail -> IsSMTP();
            $mail -> Port = 25;
            $mail -> SMTPAuth = true;
            $mail -> CharSet = "UTF-8";
            $mail->Username = "noreply@aparedes.com.mx"; // Correo completo a utilizar
            $mail->Password = "N0R3sp0nd3r123:)"; // Contraseña
            $mail->From = "noreply@aparedes.com.mx"; // Desde donde enviamos (Para mostrar)
            $mail->FromName = "Agricola Paredes S.A.P.I. de C.V.";
            $mail -> Subject = "Hemos recibido tus archivos!";
            $mail -> AddAddress(" ". $_SESSION['correo'] ." ");
            //$mail -> AddBCC("usuario@copia.com");
            
            //cuerpo del correo
            $body="<span style='font-family:sans-serif;'>Confirmaci&oacute;n de recepci&oacute;n de archivos, gracias por utilizar nuestro portal.</span><br><br><table style='width: 100%;text-align: center; font-family:sans-serif;'>
            <tr><td>Nombre</td><td>Respuesta</td>";
            if(count(@$_SESSION['nom_xml_val'])>0){
                for($i=0; $i < count($_SESSION['nom_xml_val']); $i++){
                    $body.="<tr><td>".$_SESSION['nom_xml_val'][$i]."</td><td>XML V&aacute;lido</td></tr>";
                } 
            }        
            if(count(@$_SESSION['nom_xml_inv'])>0){
                for($p=0; $p < count($_SESSION['nom_xml_inv']); $p++){
                    $body.="<tr><td>".$_SESSION['nom_xml_inv'][$p]."</td><td>".$_SESSION["e_xml"][0]."</td></tr>";
                }
            }
            $body.="</table><br><div style='float:right;font-family:sans-serif; font-size:11px;'><span>PASEO NI&Ntilde;OS HEROES ORIENTE NUM. EXT. 520 NUM. INT. 302 COLONIA CENTRO, CULIACAN, SINALOA, MEXICO.<br>Tel.6677603540 - 6677603550</span><br><br><a href='http://www.aparedes.com.mx/'><img src='http://www.aparedes.com.mx/images/logo.png' width='14%'/></a></div>";
            
            $mail -> isHTML(true);
            $mail -> Body = $body;
            $mail -> Send(); 
        
        
    }
                                                   
                                                   
     public function upFilesNC($pdfs = array(),$files = array(),$purcho = array())
    {
       //establecemos la conexion a la BD
       /*$conexion = mysql_connect("localhost", "root", "12345");
       $date = date_create(); 
       mysql_select_db("system_validator", $conexion);*/
      $conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
      $date = date_create(); 
      mysql_select_db("tspvcomm_proveedores", $conexion);
      //inicializamos un contador para recorrer los archivos
      global $cSucursal;
      $doc = new DOMDocument(); 
      unset($_SESSION['nom_xml_inv']);
      unset($_SESSION['nom_xml_val']);
      $i = 0;
      $k = 0;
      $email_to = $_SESSION["correo"];
      $email_subject = "Agricola Paredes SAPI de CV";
      $rfcAgricola='APA9707035N4';
      $vcJs="<script type='text/javascript'>";
      $counts = array_count_values($purcho);  

       //var_dump($ocarray);

       //si no existe la carpeta files la creamos
       if(!is_dir("recibidos/")) 
       mkdir("recibidos/", 0777);

       //recorremos los input files del formulario
       foreach($pdfs as $pdf) 
       {   
       if($_FILES['pdf']['name'][$k])
       {    
           foreach ($files as $file) 
           {
               if($_FILES['xml']['name'][$k])
               {
                   if ($cSucursal=="003") {
                       move_uploaded_file($_FILES['pdf']['tmp_name'][$k],"cdguzman/pdfs/".$_FILES['pdf']['name'][$k]);
                       //movemos los xml a la carpeta local de recibidos
                       move_uploaded_file($_FILES['xml']['tmp_name'][$k],"cdguzman/recibidos/".$_FILES['xml']['name'][$k]);
                   }else{
                       //movemos los pdf a la carpeta local pdfs
                       move_uploaded_file($_FILES['pdf']['tmp_name'][$k],"pdfs/".$_FILES['pdf']['name'][$k]);
                       //movemos los xml a la carpeta local de recibidos
                       move_uploaded_file($_FILES['xml']['tmp_name'][$k],"recibidos/".$_FILES['xml']['name'][$k]);
                   }
                   $dom = new DOMDocument('1.0', 'UTF-8');
                   if ($cSucursal=="003") {
                       $dom->load("cdguzman/recibidos/".$_FILES['xml']['name'][$k]);
                   }else{
                       $dom->load("recibidos/".$_FILES['xml']['name'][$k]);
                   }
                   
                   $cd = $dom->getElementsByTagName('TimbreFiscalDigital');
                   $emp = $dom->getElementsByTagName('Receptor');
                   $dir = $dom->getElementsByTagName('Domicilio');
                   $fol = $dom->getElementsByTagName('Comprobante');
                   $emisor = $dom->getElementsByTagName('Emisor');
                   $opt=$purcho[$k];
                   if($opt != ""){
                       $com = $dom->getElementsByTagName('Comprobante')->item(0);
                       $addenda=$dom->createElement('cfdi:Addenda');
                       $or_buy=$dom->createElement('cfdi:OrdenCompra');
                       $oc_attr = $dom->createAttribute("OrdenCompra");
                       $or_buy->appendChild($oc_attr);
                       $oc_item_value = $dom->createTextNode($opt);
                       $oc_attr->appendChild($oc_item_value);
                       $addenda->appendChild($or_buy);
                       $com->appendChild($addenda);                            
                   }
                   $j=0;
                   //$errores=array();
                   foreach($cd as $element)
                   {
                       foreach ($fol as $folio){
                           $fols = $folio->getAttribute('folio'); 
                           $serie = $folio->getAttribute('serie');
                           $tipo = strtolower($folio->getAttribute('TipoDeComprobante'));
                           $tipo=($tipo=="e" ? 'egreso' : 'ingreso');
                           $versionxml=$folio->getAttribute('version');
                           $folio_int=$serie.$fols; 
                           $orden = $purcho[$k];
                           $rfc = $_SESSION['rfc'];
                           $fecha = $_SESSION['fecha'];
                           $nombre = $_FILES["xml"]['name'][$k];
                           $nombrexml = basename($_FILES['xml']['name'][$k],".xml");
                           $nombre_pdf = basename($_FILES['pdf']['name'][$k],".pdf");
                           $cadena = str_replace(' ', '', $nombrexml);
                           $orden2=str_replace(' ', '', $orden); 
                           $uuid = $element->getAttribute('UUID');
                           //copy("pdfs/".trim($rfc)."%".$uuid.".".$ext_pdf,"respaldo/".trim($rfc)."|".$uuid.".".$ext_pdf);
                           $sql = "SELECT * FROM records_xml WHERE folio_uuid='".$uuid."'";
                           $resultado=mysql_query($sql, $conexion) or die (mysql_error());
                           $numRegistros=mysql_num_rows($resultado);
                           foreach($emisor as $em){
                               if($versionxml=="3.2"){
                                   $rfc_xml=$em->getAttribute('rfc');    
                               }else{
                                   $rfc_xml=$em->getAttribute('Rfc');    
                               }                                    
                               if(trim($rfc_xml) == trim($rfc))
                               {
                                   foreach($emp as $rec){
                                       if($versionxml=="3.2"){
                                           $rfc_xml_agricola=$rec->getAttribute('rfc');    
                                       }else{
                                           $rfc_xml_agricola=$rec->getAttribute('Rfc');
                                       }                                            
                                       if(trim($rfc_xml_agricola) == trim($rfcAgricola))
                                       {
                                           //var_dump($orden);
                                           if($orden=="" or $counts[$orden]==1){
                                              if($numRegistros==0) 
                                              {   
                                                if($tipo=='egreso'){
                                                  $vcJs.="fgActualizaOcPortal('2','".$opt."','".$cSucursal."');";
                                                  //$upd = "UPDATE inv_ocpendientes SET CRELACIONADONC='S' WHERE CORDENCOMPRA='$opt' and cSucursal='".$cSucursal."'";    
                                                }else{
                                                  $vcJs.="fgActualizaOcPortal('1','".$opt."','".$cSucursal."');";
                                                  //$upd = "UPDATE inv_ocpendientes SET CRELACIONADO='S' WHERE CORDENCOMPRA='$opt' and cSucursal='".$cSucursal."'";    
                                                }                                                        
                                                //mysql_query($upd); 
                                                /*if(count($purcho)>0){
                                                foreach ($purcho as $opt){        
                                                $upd = "UPDATE inv_ocpendientes SET CRELACIONADO='S' WHERE CORDENCOMPRA='$opt'";
                                                mysql_query($upd);             
                                                }    
                                                }*/
                                                   //aqui empezamos a consumir el webservice
                                                   //Crear un cliente apuntando al script del servidor (Creado con WSDL)
                                                   $serverURL = 'https://www.clickfactura.com.mx/webservice/yii/validador/';
                                                   $cliente = new nusoap_client("$serverURL?wsdl", 'wsdl');
                                                   $xml64=file_get_contents("recibidos/".$_FILES['xml']['name'][$k]);
                                                   $DOC = new DOMDocument('1.0', 'utf-8');
                                                   $DOC->loadXML($xml64);
                                                   $xml64 = base64_encode($xml64);
                                                   $result['resultado'] = true;
                                                   /*$result = $cliente->call(
                                                               //aqui se valida el XML
                                                               "validarXml", // Funcion a llamar
                                                               array(
                                                                   'Usuario'=>"APA9707035N4",
                                                                   'Pass'=>'validacionFacturas',
                                                                   'xmlData'=>$xml64,
                                                               ), // Parametros pasados a la funcion   
                                                               "uri:$serverURL/$serverScript", // namespace
                                                               "uri:$serverURL/$serverScript/$metodoALlamar"// SOAPAction
                                                       );*/

                                                   if($result['resultado'] =="true"){
                                                       $name_xml=trim($rfc).'_'.$uuid.'.xml';
                                                       $name_pdf=trim($rfc).'_'.$uuid.'.pdf';
                                                       //var_dump($name_xml);
                                                       //var_dump($name_pdf);
                                                       //asignamos el nombre del xml a los pdfs
                                                       if ($cSucursal=="003") {
                                                           rename("cdguzman/pdfs/".$_FILES['pdf']['name'][$k],"cdguzman/pdfs/".$name_pdf);
                                                           copy("cdguzman/pdfs/".$name_pdf,"respaldo/cdguzman/".$name_pdf);
                                                       }else{
                                                           rename("pdfs/".$_FILES['pdf']['name'][$k],"pdfs/".$name_pdf);
                                                           copy("pdfs/".$name_pdf,"respaldo/".$name_pdf);
                                                       }
                                                       $_record_xml = "INSERT INTO records_xml (rfc,fecha,nombre_xml,folio_uuid,folio_interno,orden_compra,cSucursal,valido,errores) VALUES ('$rfc','$fecha','$nombre','$uuid','$folio_int','$orden2','".$cSucursal."','1','')";
                                                       mysql_query($_record_xml);                                             
                                                       if($tipo=='egreso'){
                                                           if ($cSucursal=="003") {
                                                               $dom->save("cdguzman/notas_validas/".$name_xml);
                                                               //rename("recibidos/".$_FILES['xml']['name'][$k],"notas_validas/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml");
                                                               copy("cdguzman/notas_validas/".$name_xml,"respaldo/cdguzman/".$name_xml); 
                                                           }else{
                                                               // guarda xml con addenda
                                                               $dom->save("notas_validas/".$name_xml);
                                                               //rename("recibidos/".$_FILES['xml']['name'][$k],"notas_validas/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml");
                                                               copy("notas_validas/".$name_xml,"respaldo/".$name_xml);    
                                                           }
                                                           
                                                       }
                                                       else{
                                                           if ($cSucursal=="003") {
                                                               // guarda xml con addenda
                                                               $dom->save('cdguzman/validos/'.$name_xml);
                                                               copy("cdguzman/validos/".$name_xml,"respaldo/cdguzman/".$name_xml);    
                                                           }else{
                                                               // guarda xml con addenda
                                                               $dom->save('validos/'.$name_xml);
                                                               copy("validos/".$name_xml,"respaldo/".$name_xml);    
                                                           }
                                                           
                                                       }                                        
                                                       $nom_val_xml[]=$nombre;
                                                       $_SESSION["nom_xml_val"]=$nom_val_xml;//se va formando arrays de nombres de xml
                                                       $xml_validos[]= $k;
                                                       $_SESSION["validos"] = $xml_validos;//enviamos 0 y 1 para ver quienes son los validos
                                                       echo $vcJs."</script>";
                                                       header("Refresh: 3; url=notas.php");
                                                       $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                                   }
                                                   else{
                                                       if(count($result['errores'])> 0){
                                                           $errores_xml=array();
                                                           echo "El xml presenta Errores"."<br>";
                                                           //foreach para obtener todos los errores
                                                           foreach ($result['errores'] as $error){
                                                               $errors=$error['comentario'];
                                                               $errores_xml[]= $errors;
                                                               $_SESSION["e_xml"] = $errores_xml;
                                                               $posicion[]=$k;
                                                               $_SESSION["posicion"]= $posicion;
                                                               header("Refresh: 3; url=notas.php");
                                                               

                                                           }
                                                           if ($cSucursal=="003") {
                                                               rename("cdguzman/pdfs/".$nombre_pdf,"cdguzman/pdfs_mal/".$nombre_pdf);
                                                           }else{
                                                               rename("pdfs/".$nombre_pdf,"pdfs_mal/".$nombre_pdf);
                                                           }
                                                           
                                                           //INSERTAMOS ALA BASE DE DATOS EL XML NO VALIDO JUNTO CON LOS ERRORES
                                                           $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                                           $nom_error_xml[]=$nombre;
                                                           $_SESSION["nom_xml_inv"]=$nom_error_xml;
                                                           $xml_mal=$_SESSION["e_xml"][0];
                                                           
                                                           $_record_xml = "INSERT INTO records_xml (rfc,fecha,nombre_xml,folio_uuid,folio_interno,orden_compra,cSucursal,valido,errores) VALUES ('$rfc','$fecha','$nombre','$uuid','$folio_int','$orden2','0','$xml_mal')";
                                                           mysql_query($_record_xml); 
                                                           if($tipo=='egreso'){
                                                               if ($cSucursal=="003") {
                                                                   rename("cdguzman/recibidos/".$_FILES['xml']['name'][$k],"cdguzman/notas_invalidas/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml");
                                                               }else{
                                                                   rename("recibidos/".$_FILES['xml']['name'][$k],"notas_invalidas/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml");    
                                                               }
                                                               
                                                           }
                                                           else{
                                                               if ($cSucursal=="003") {
                                                                   rename("cdguzman/recibidos/".$_FILES['xml']['name'][$k],"cdguzman/invalidos/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml"); 
                                                               }else{
                                                                   rename("recibidos/".$_FILES['xml']['name'][$k],"invalidos/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml");     
                                                               }
                                                               
                                                           }
                                                       }
                                                   }
                                                   /*Direccion aqui va el codigo*/
                                               }
                                               else
                                               {
                                                   //Aqui cachamos todos los errores de duplicidad de UUID de los xml y los enviamos al index
                                                   $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                                   $errores_uuid[]= $k;
                                                   $_SESSION["e"] = $errores_uuid; 
                                                   $nom_error_uuid[]=$nombre;
                                                   $_SESSION["nom_uuid"]=$nom_error_uuid;
                                                   header("Refresh: 3; url=notas.php");
                                               }
                                           }else{
                                               //aqui caen los errores cuando seleccionan una orden de compra mas de una vez
                                               $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                               $errores_ocduplic[]= $k;
                                               $_SESSION["ocduplic"] = $errores_ocduplic; 
                                               $nom_error_ocduplic[]=$nombre;
                                               $_SESSION["nom_ocduplic"]=$nom_error_ocduplic;
                                               header("Refresh: 3; url=notas.php");
                                           }
                                       } 
                                       else{
                                           //aqui caen los errores cuando el rfc del xml no concuerda con el rfc de la agricola
                                           $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                           $errores_rfcagricola[]= $k;
                                           $_SESSION["agricolarfc"] = $errores_rfcagricola; 
                                           $nom_error_rfcagricola[]=$nombre;
                                           $_SESSION["nom_agricola_erfc"]=$nom_error_rfcagricola;
                                           header("Refresh: 3; url=notas.php");
                                           echo "no es el rfc de la agricola";
                                       }   
                                   }    
                               }
                               else
                               {
                                   //aqui obtenemos los errores cuando el rfc no concuerde con el xml a subir
                                   $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                   $errores_rfc[]= $k;
                                   $_SESSION["erfc"] = $errores_rfc; 
                                   $nom_error_rfc[]=$nombre;
                                   $_SESSION["nom_erfc"]=$nom_error_rfc;
                                   header("Refresh: 3; url=notas.php");
                               }
                           } 
                       }$j++;
                   }
               }
               else
               {
                   echo "sin xml";
               }
               //incrementamos k de pdfs para recorrer array
               $k++;                   
           }
       }
       else
       {
           //echo "sin pdf"; 
       }
       //incrementamos i de xmls para recorrer array
       $i++;
       }
       //var_dump($_SESSION['nom_xml_inv']);
       //var_dump($_SESSION["e_xml"]);

       //configuración de la clase
       $mail = new PHPMailer();
       $mail -> Host = 'mail.aparedes.com.mx';
       $mail -> IsHTML (true);
       $mail -> IsSMTP();
       $mail -> Port = 25;
       $mail -> SMTPAuth = true;
       $mail -> CharSet = "UTF-8";
       $mail->Username = "noreply@aparedes.com.mx"; // Correo completo a utilizar
       $mail->Password = "N0R3sp0nd3r"; // Contraseña
       $mail->From = "noreply@aparedes.com.mx"; // Desde donde enviamos (Para mostrar)
       $mail->FromName = "Agricola Paredes S.A.P.I. de C.V.";
       $mail -> Subject = "Hemos recibido tus archivos!";
       $mail -> AddAddress(" ". $_SESSION['correo'] ." ");
       //$mail -> AddBCC("usuario@copia.com");

       //cuerpo del correo
       $body="<span style='font-family:sans-serif;'>Confirmaci&oacute;n de recepci&oacute;n de archivos, gracias por utilizar nuestro portal.</span><br><br><table style='width: 100%;text-align: center; font-family:sans-serif;'>
       <tr><td>Nombre</td><td>Respuesta</td>";
       if(count(@$_SESSION['nom_xml_val'])>0){
           for($i=0; $i < count($_SESSION['nom_xml_val']); $i++){
               $body.="<tr><td>".$_SESSION['nom_xml_val'][$i]."</td><td>XML V&aacute;lido</td></tr>";
           } 
       }        
       if(count(@$_SESSION['nom_xml_inv'])>0){
           for($p=0; $p < count($_SESSION['nom_xml_inv']); $p++){
               $body.="<tr><td>".$_SESSION['nom_xml_inv'][$p]."</td><td>".$_SESSION["e_xml"][0]."</td></tr>";
           }
       }
       $body.="</table><br><div style='float:right;font-family:sans-serif; font-size:11px;'><span>PASEO NI&Ntilde;OS HEROES ORIENTE NUM. EXT. 520 NUM. INT. 302 COLONIA CENTRO, CULIACAN, SINALOA, MEXICO.<br>Tel.6677603540 - 6677603550</span><br><br><a href='http://www.aparedes.com.mx/'><img src='http://www.aparedes.com.mx/images/logo.png' width='14%'/></a></div>";

       $mail -> isHTML(true);
       $mail -> Body = $body;
       $mail -> Send(); 
     
     
   }

   /**
    *funcion privada que devuelve true o false dependiendo de la extension
    *@access private
    *@param string 
    *@return boolean - si esta o no permitido el tipo de archivo
    */

   public function fgTraeValoresPago($prmOrden, $prmValor){
      $data = json_decode( file_get_contents('http://192.168.1.22:8000/api/traevalorespagooc'), true );
      var_dump($data);
   }

   /*public function fgTraeValoresPago($prmOrden, $prmValor)
   {
      $vcFntext="";
      if ($this->v8 !== null) {
         return;
      }
      $vcFntext.="function fgTraeValoresPago(prmOrden,prmValor){";
      $vcFntext.=".ajax({";    
      $vcFntext.="url: 'http://192.168.1.22:8000/api/traevalorespagooc',";
      $vcFntext.="type: 'GET',";
      $vcFntext.="contentType: 'application/json; charset=utf-8',";
      $vcFntext.="dataType: 'json',";
      $vcFntext.="json: true, ";
      $vcFntext.="cache:false,";
      $vcFntext.="data: 'prmOrden='+".$prmOrden.",";
      $vcFntext.="success: function (data, textStatus, xhr) {  ";
      $vcFntext.="return data[prmValor];";
      $vcFntext.="},";
      $vcFntext.="error: function(jq,status,message) {";
      $vcFntext.="console.log('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);";
      $vcFntext.="}";
      $vcFntext.="});";
      $vcFntext.="}";
        
        $this->v8 = new V8Js();
        $this->v8->executeString($vcFntext);
   }

   
   public function fgTraeValoresPago($prmOrden, $prmValor)
   {
      $data = array("prmOrden" => $prmOrden);
      //url contra la que atacamos
      //$ch = curl_init("http://177.244.36.158:7373/api/traevalorespagooc");
      $ch = curl_init("http://192.168.1.22:8000/api/traevalorespagooc");
      //a true, obtendremos una respuesta de la url, en otro caso, 
      //true si es correcto, false si no lo es
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //establecemos el verbo http que queremos utilizar para la petición
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      //enviamos el array data
      curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
      //obtenemos la respuesta
      $response = curl_exec($ch);
      // Se cierra el recurso CURL y se liberan los recursos del sistema
      curl_close($ch);
      if(!$response) {
         return "";
      }else{
         $resultado = str_replace("[", "", $response);
         $resultado = str_replace("]", "", $resultado);
         $resultado = str_replace('"', "", $resultado);
         $resultado =explode(",", $resultado);
         return $resultado[$prmValor];   
      }
   }*/

   public function fgActualizaOcPortal($prmTipo,$prmOrden, $prmSucursal)
   {
      $data = array("prmTipo" => $prmTipo,"prmOrden" => $prmOrden,"prmSucursal" => $prmSucursal);
      //url contra la que atacamos

      $ch = curl_init("http://177.244.36.158:7373/api/actualizaocportal");
      //$ch = curl_init("http://192.168.1.22:8000/api/actualizaocportal");
      //a true, obtendremos una respuesta de la url, en otro caso, 
      //true si es correcto, false si no lo es
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //establecemos el verbo http que queremos utilizar para la petición
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      //enviamos el array data
      curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
      //obtenemos la respuesta
      $response = curl_exec($ch);
      // Se cierra el recurso CURL y se liberan los recursos del sistema
      curl_close($ch);
      if(!$response) {
         return "";
      }else{
         $resultado = str_replace('"', "", $response);
         return $resultado;   
      }
   }
  

   /*public function fgTraeValoresPago($prmOrden, $prmValor)
   {
      /*$conexion = mysql_connect("localhost", "root", "12345");
      $date     = date_create();
      mysql_select_db("system_validator", $conexion);
      $conexion = mysql_connect("localhost", "tspvcomm", "ParedeS@123:)");
      $date = date_create(); 
      mysql_select_db("tspvcomm_proveedores", $conexion);
      
      $sql = "SELECT CMETODOPAGOCFDI,CFORMAPAGOCFDI,CUSOCFDI FROM `inv_ocpendientes`";
      $sql .= "WHERE CORDENCOMPRA='" . $prmOrden . "'";
      $res = mysql_query($sql);
      $resultado = mysql_result($res, 0, $prmValor);
      return $resultado;
   }*/
  
   private function checkExtension($extension)
   {
      //aqui podemos añadir las extensiones que deseemos permitir
      $extensiones = array(
         "xml"
      );
      if (in_array(strtolower($extension), $extensiones)) {
         return TRUE;
      } else {
         return FALSE;
      }
   }
  
   /**
    *funcion que comprueba si el archivo existe, si es asi, iteramos en un loop 
    *y conseguimos un nuevo nombre para el, finalmente lo retornamos
    *@access private
    *@param array 
    *@return array - archivo con el nuevo nombre
    */
   private function checkExists($file)
   {
      //asignamos de nuevo el nombre al archivo
      $archivo = $file[0] . '.' . end($file);
      $i       = 0;
      //mientras el archivo exista entramos
      while (file_exists('recibidos/' . $archivo)) {
         $i++;
         $archivo = $file[0] . "(" . $i . ")" . "." . end($file);
      }
      //devolvemos el nuevo nombre de la imagen, si es que ha 
      //entrado alguna vez en el loop, en otro caso devolvemos el que
      //ya tenia
      return $archivo;
   }
  
   function contar_repeticiones($array)
   {
      $repetidos     = 0;
      $ya_duplicados = array();
      foreach ($array as $item) {
         for ($u = 0; $u < sizeof($array); $u++) {
            if ($item == $array[$u] && !in_array($item, $ya_duplicados)) {
               ++$cont;
            }
         }
        
         if ($cont >= 2) {
            array_push($ya_duplicados, $item);
            $repetidos++;
         }
        
         $cont = 0;
      }
      return $repetidos;
   }
  
  
}
?>
<script src="js/sweet-alert.min.js"></script> 
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="js/sweet-alert.css">
<link href="css/tooltip.css" rel="stylesheet" type="text/css" media="all"/>
<script type="text/javascript">
   function fgActualizaOcPortal(prmTipo,prmOrden,prmSucursal){
   //alert(prmProveedor+" "+prmSucursal);
      $.ajax({    
         //url: 'http://192.168.1.22:8000/api/actualizaocportal',
         url: 'http://api.aparedes.com.mx:8000/api/actualizaocportal', 
         //url: 'http://177.244.36.158:7373/api/actualizaocportal',
         type: "GET",
         contentType: "application/json; charset=utf-8",
         dataType: 'json',
         json: true, 
         cache:false,
         data: "prmTipo="+prmTipo+"&prmOrden="+prmOrden+"&prmSucursal="+prmSucursal,
         success: function (data, textStatus, xhr) {  
            console.log(data);
         },  
         error: function(jq,status,message) {
            console.log('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
         }
      });
   }

  
</script>
