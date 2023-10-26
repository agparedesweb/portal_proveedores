<script src="js/sweet-alert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="js/sweet-alert.css">
<link href="css/tooltip.css" rel="stylesheet" type="text/css" media="all"/>

<?php
session_start();
require_once("createxml.php");
require ("phpmailer/PHPMailerAutoload.php");
require_once("lib/nusoap.php");
class Multiupload
{
    /**
    *sube archivos al servidor a través de un formulario
    *@access public
    *@param array $files estructura de array con todos los archivos a subir
    */
    public function upFiles($pdfs = array(),$files = array(),$manif = array())
    {
        //establecemos la conexion a la BD
        /*$conexion = mysql_connect("localhost", "root", "");
        $date = date_create(); 
        mysql_select_db("system_validator", $conexion);*/
        $conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
        $date = date_create(); 
        mysql_select_db("tspvcomm_proveedores", $conexion);
        //inicializamos un contador para recorrer los archivos
        
        $doc = new DOMDocument(); 
        unset($_SESSION['nom_xml_inv']);
        unset($_SESSION['nom_xml_val']);
        $i = 0;
        $k = 0;
        $email_to = $_SESSION["correo"];
        $email_subject = "Agricola Paredes SA de CV";
 
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
                        //movemos los pdf a la carpeta local pdfs
                        move_uploaded_file($_FILES['pdf']['tmp_name'][$k],"pdfs/".$_FILES['pdf']['name'][$k]);
                        //movemos los xml a la carpeta local de recibidos
                        move_uploaded_file($_FILES['xml']['tmp_name'][$k],"recibidos/".$_FILES['xml']['name'][$k]);
                        $dom = new DOMDocument('1.0', 'UTF-8');
                        $dom->load("recibidos/".$_FILES['xml']['name'][$k]);
                        $cd = $dom->getElementsByTagName('TimbreFiscalDigital');
                        $emp = $dom->getElementsByTagName('Receptor');
                        $dir = $dom->getElementsByTagName('Domicilio');
                        $fol = $dom->getElementsByTagName('Comprobante');
                        $emisor = $dom->getElementsByTagName('Emisor');
                        $com = $dom->getElementsByTagName('Comprobante')->item(0);
                        $addenda=$dom->createElement('cfdi:Addenda');
                        $j=0;
                        //$errores=array();
                        foreach($cd as $element)
                        {   
                            foreach ($fol as $folio){
                                $fols = $folio->getAttribute('folio'); 
                                $serie = $folio->getAttribute('serie');
                                $tipo = $folio->getAttribute('tipoDeComprobante');
                                $folio_int=$serie.$fols;
                                $mansel=array_column($manif, $k);
                                $mfto=implode(',', $manif[$k]);
                                $orden = $mfto;
                                $mftos = $manif[$k];
                                for ($n=0; $n <= count($mftos)-1; $n++) { 
                                    //echo "Valor de N: ".$n."<br>";
                                    $sel=$mftos[$n];
                                    //echo "\n<br>".$sel; 
                                    $query=mysql_query("SELECT CMERCADO FROM eye_maniffacturados WHERE CRELACIONADO='N' AND CFOLIO_REMIS='".$sel."'");
                                    $mercado=mysql_result($query,0);
                                    $querym=mysql_query("SELECT CFOLIO_MANIF FROM eye_maniffacturados WHERE CRELACIONADO='N' AND CFOLIO_REMIS='".$sel."'");
                                    $cfoliom=mysql_result($querym,0);
                                    //ACTUALIZAMOS EL VALOR CRELACIONADO DESPUES DE HABER SELECCIONADO EL MANIFIESTO
                                    $upd = "UPDATE eye_maniffacturados SET CRELACIONADO='S' WHERE CFOLIO_REMIS='".$sel."'";
                                    mysql_query($upd);
                                    //Asignamos los manifiestos ala addenda
                                    $or_buy=$dom->createElement('cfdi:Manifiesto');
                                    $oc_attr = $dom->createAttribute("Manifiesto");
                                    $oc_mercado = $dom->createAttribute("Mercado");
                                    $oc_manif = $dom->createAttribute("CFOLIO_MANIF");
                                    $or_buy->appendChild($oc_manif);
                                    $or_buy->appendChild($oc_mercado);
                                    $or_buy->appendChild($oc_attr);
                                    $oc_item_value = $dom->createTextNode($sel);
                                    $oc_item_mercado = $dom->createTextNode($mercado);
                                    $oc_item_cfoliom=$dom->createTextNode($cfoliom);
                                    $oc_attr->appendChild($oc_item_value);
                                    $oc_mercado->appendChild($oc_item_mercado);
                                    $oc_manif->appendChild($oc_item_cfoliom);
                                    $com->appendChild($addenda);
                                    $addenda->appendChild($or_buy);
                                }                                   
                                $rfc = $_SESSION['rfc'];
                                $fecha = $_SESSION['fecha'];
                                $nombre = $_FILES["xml"]['name'][$k];
                                $nombrexml = basename($_FILES['xml']['name'][$k],".xml");
                                $nombre_pdf = $_FILES['pdf']['name'][$k];
                                $ext_pdf = pathinfo($_FILES['pdf']['name'][$k], PATHINFO_EXTENSION);
                                $cadena = str_replace(' ', '', $nombrexml);
                                $orden2=str_replace(' ', '', $orden); 
                                $uuid = $element->getAttribute('UUID'); 
                                $sql = "SELECT * FROM records_xml WHERE folio_uuid='".$uuid."'";
                                $resultado=mysql_query($sql, $conexion) or die (mysql_error());
                                $numRegistros=mysql_num_rows($resultado);
                                foreach($emisor as $em)
                                {
                                    $rfc_xml=$em->getAttribute('rfc');
                                    if(trim($rfc_xml) == trim($rfc))
                                    { 
                                        if($numRegistros==0) 
                                        {
                                            /*foreach ($manif as $selectedOption){        
                                                foreach ($selectedOption as $opt){
                                                    $upd = "UPDATE eye_maniffacturados SET CRELACIONADO='S' WHERE CFOLIO_REMIS='$opt'";
                                                    mysql_query($upd); 
                                                }
                                            } */  
                                            //aqui empezamos a consumir el webservice
                                            //Crear un cliente apuntando al script del servidor (Creado con WSDL)
                                            $serverURL = 'https://www.clickfactura.com.mx/webservice/yii/validador/';
                                            $cliente = new nusoap_client("$serverURL?wsdl", 'wsdl');
                                            $xml64=file_get_contents("recibidos/".$_FILES['xml']['name'][$k]);
                                            $DOC = new DOMDocument('1.0', 'utf-8');
                                            $DOC->loadXML($xml64);
                                            $xml64 = base64_encode($xml64);
                                            //$result['resultado']=true;
                                            $result = $cliente->call(
                                                //aqui se valida el XML
                                                "validarXml", // Funcion a llamar
                                                array(
                                                    'Usuario'=>"APA9707035N4",
                                                    'Pass'=>'validacionFacturas',
                                                    'xmlData'=>$xml64,
                                                ), // Parametros pasados a la funcion   
                                                "uri:$serverURL/$serverScript", // namespace
                                                "uri:$serverURL/$serverScript/$metodoALlamar"// SOAPAction
                                            );
                                            if($result['resultado']=="true"){
                                                $name_xml=trim($rfc).'_'.$uuid.'.xml';
                                                $name_pdf=trim($rfc)."_".$uuid.'.pdf';
                                                //asignamos el nombre del xml a los pdfs
                                                rename("pdfs/".$nombre_pdf,"pdfs/".$name_pdf);
                                                copy("pdfs/".$name_pdf,"respaldo/".$name_pdf);
                                                $_record_xml = "INSERT INTO records_xml (rfc,fecha,nombre_xml,folio_uuid,folio_interno,orden_compra,valido,errores) VALUES ('$rfc','$fecha','$nombre','$uuid','$folio_int','$orden2','1','')";
                                                mysql_query($_record_xml);                                             
                                                if($tipo=='egreso'){
                                                    // guarda xml con addenda
                                                    $dom->save("notas_validas/".$name_xml);
                                                    //rename("recibidos/".$_FILES['xml']['name'][$k],"notas_validas/"."OC".$orden2."_".trim($rfc)."|".$uuid.".xml");
                                                    copy("notas_validas/".$name_xml,"respaldo/".$name_xml);
                                                }
                                                else{
                                                    // guarda xml con addenda
                                                    $dom->save('validos/'.$name_xml);
                                                    copy("validos/".$name_xml,"respaldo/".$name_xml);
                                                }                                        
                                                $nom_val_xml[]=$nombre;
                                                $_SESSION["nom_xml_val"]=$nom_val_xml;//se va formando arrays de nombres de xml
                                                $xml_validos[]= $k;
                                                $_SESSION["validos"] = $xml_validos;//enviamos 0 y 1 para ver quienes son los validos
                                                header("location:index.php");
                                                $_SESSION["flag"]=1;//bandera para desplegar popup en index.php
                                            }
                                            else{
                                                if(count($result['errores'])> 0){
                                                    $errores_xml=array();
                                                    //foreach para obtener todos los errores
                                                    foreach ($result['errores'] as $error){
                                                        $errors=$error['comentario'];
                                                        $errores_xml[]= $errors;
                                                        $_SESSION["e_xml"] = $errores_xml;
                                                        $posicion[]=$k;
                                                        $_SESSION["posicion"]= $posicion;
                                                        header("location:index.php");
                                                        

                                                    }
                                                    //guardamos pdf de xml invalido
                                                    rename("pdfs/".$nombre_pdf,"pdfs_mal/".$nombre_pdf);
                                                    //INSERTAMOS ALA BASE DE DATOS EL XML NO VALIDO JUNTO CON LOS ERRORES
                                                    $_SESSION["flag"]=1;
                                                    $nom_error_xml[]=$nombre;
                                                    $_SESSION["nom_xml_inv"]=$nom_error_xml;
                                                    $xml_mal=$_SESSION["e_xml"][0];
                                                    $_record_xml = "INSERT INTO records_xml (rfc,fecha,nombre_xml,folio_uuid,folio_interno,orden_compra,valido,errores) VALUES ('$rfc','$fecha','$nombre','$uuid','$folio_int','$orden2','0','$xml_mal')";
                                                    mysql_query($_record_xml); 
                                                    if($tipo=='egreso'){
                                                        rename("recibidos/".$_FILES['xml']['name'][$k],"notas_invalidas/"."OC".$orden2."_".trim($rfc)."_".$uuid.".xml");
                                                    }
                                                    else{
                                                        rename("recibidos/".$_FILES['xml']['name'][$k],"invalidos/"."OC".$orden2."_".trim($rfc)."_".$uuid.".xml"); 
                                                    }
                                                }
                                            }
                                            /*Direccion aqui va el codigo*/
                                        }
                                        else
                                        {
                                            //Aqui cachamos todos los errores de duplicidad de UUID de los xml y los enviamos al index
                                            $_SESSION["flag"]=1;
                                            $errores_uuid[]= $k;
                                            $_SESSION["e"] = $errores_uuid; 
                                            $nom_error_uuid[]=$nombre;
                                            $_SESSION["nom_uuid"]=$nom_error_uuid;
                                            header("Location:index.php");
                                        }
                                    }
                                }    
                            }$j++;
                        }
                    }
                    else
                    {
                        $_SESSION["sin_xml"]=1;
                    }
                    //incrementamos k de pdfs para recorrer array
                    $k++;                   
                }
            }
            else
            {
                $_SESSION["sin_pdf"]=1;
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
        $mail->Password = "paredes123"; // Contraseña
        $mail->From = "noreply@aparedes.com.mx"; // Desde donde enviamos (Para mostrar)
        $mail->FromName = "Agricola Paredes SA de CV";
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
   
    private function checkExtension($extension)
    {
        //aqui podemos añadir las extensiones que deseemos permitir
        $extensiones = array("xml");
        if(in_array(strtolower($extension), $extensiones))
        {
            return TRUE;
        }else{
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
        $i = 0;
        //mientras el archivo exista entramos
        while(file_exists('recibidos/'.$archivo))
        {
            $i++;
            $archivo = $file[0]."(".$i.")".".".end($file);       
        }
        //devolvemos el nuevo nombre de la imagen, si es que ha 
        //entrado alguna vez en el loop, en otro caso devolvemos el que
        //ya tenia
        return $archivo;
    }

 
}
?>