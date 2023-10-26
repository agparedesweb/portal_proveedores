<?php
//ini_set('display_errors', 1);
session_start();
require_once("createxml.php");
require("phpmailer/PHPMailerAutoload.php");
require_once("lib/nusoap.php");
$cSucursal = @$_SESSION["sucursal"];
class Multiupload
{
    
    public function upFilesNC($pdfs = array(), $files = array(), $purcho = array())
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
        unset($_SESSION['nom_xml_inv']);
        unset($_SESSION['nom_xml_val']);
        $i = 0;
        $k = 0;
        $email_to = $_SESSION["correo"];
        $email_subject = "Agricola Paredes SAPI de CV";
        $rfcAgricola = 'APA9707035N4';
        $counts = array_count_values($purcho);
        $response = array(
            "status" => "",
            "message" => ""
        );
        
        //si no existe la carpeta files la creamos
        if (!is_dir("recibidos/"))
            mkdir("recibidos/", 0777);

        //recorremos los input files del formulario
        foreach ($pdfs as $pdf) {
            if ($_FILES['pdf']['name'][$k]) {
                foreach ($files as $file) {
                    if ($_FILES['xml']['name'][$k]) {
                        if ($cSucursal == "003") {
                            move_uploaded_file($_FILES['pdf']['tmp_name'][$k], "cdguzman/pdfs/" . $_FILES['pdf']['name'][$k]);
                            //movemos los xml a la carpeta local de recibidos
                            move_uploaded_file($_FILES['xml']['tmp_name'][$k], "cdguzman/recibidos/" . $_FILES['xml']['name'][$k]);
                        } else {
                            //movemos los pdf a la carpeta local pdfs
                            move_uploaded_file($_FILES['pdf']['tmp_name'][$k], "pdfs/" . $_FILES['pdf']['name'][$k]);
                            //movemos los xml a la carpeta local de recibidos
                            move_uploaded_file($_FILES['xml']['tmp_name'][$k], "recibidos/" . $_FILES['xml']['name'][$k]);
                        }
                        $dom = new DOMDocument('1.0', 'UTF-8');
                        if ($cSucursal == "003") {
                            $dom->load("cdguzman/recibidos/" . $_FILES['xml']['name'][$k]);
                        } else {
                            $dom->load("recibidos/" . $_FILES['xml']['name'][$k]);
                        }

                        $cd = $dom->getElementsByTagName('TimbreFiscalDigital');
                        $emp = $dom->getElementsByTagName('Receptor');
                        $dir = $dom->getElementsByTagName('Domicilio');
                        $fol = $dom->getElementsByTagName('Comprobante');
                        $emisor = $dom->getElementsByTagName('Emisor');
                        $cfdi_relacionado = $dom->getElementsByTagName('CfdiRelacionado')[0];
                        $uuid_relacionado = $cfdi_relacionado->getAttribute('UUID');
                        $opt = $purcho[0];
                        if ($opt != "") {
                            $com = $dom->getElementsByTagName('Comprobante')->item(0);
                            $addenda = $dom->createElement('cfdi:Addenda');
                            $or_buy = $dom->createElement('cfdi:OrdenCompra');
                            $oc_attr = $dom->createAttribute("OrdenCompra");
                            $or_buy->appendChild($oc_attr);
                            $oc_item_value = $dom->createTextNode($opt);
                            $oc_attr->appendChild($oc_item_value);
                            $addenda->appendChild($or_buy);
                            $com->appendChild($addenda);
                        }
                        $j = 0;
                        foreach ($cd as $element) {
                            foreach ($fol as $folio) {
                                $fols = $folio->getAttribute('folio');
                                $serie = $folio->getAttribute('serie');
                                $tipo = strtolower($folio->getAttribute('TipoDeComprobante'));
                                $tipo = ($tipo == "e" ? 'egreso' : 'ingreso');
                                $versionxml = $folio->getAttribute('version');
                                $folio_int = $serie . $fols;
                                $nImporteTotal = $folio->getAttribute('Total');
                                $orden = $purcho[0];
                                $rfc = $_SESSION['rfc'];
                                $fecha = $_SESSION['fecha'];
                                $nombre = $_FILES["xml"]['name'][$k];
                                $nombrexml = basename($_FILES['xml']['name'][$k], ".xml");
                                $nombre_pdf = basename($_FILES['pdf']['name'][$k], ".pdf");
                                $cadena = str_replace(' ', '', $nombrexml);
                                $orden2 = str_replace(' ', '', $orden);
                                $uuid = $element->getAttribute('UUID');
                                //copy("pdfs/".trim($rfc)."%".$uuid.".".$ext_pdf,"respaldo/".trim($rfc)."|".$uuid.".".$ext_pdf);
                                $sql = "SELECT * FROM records_xml_notas WHERE folio_uuid='" . $uuid . "'";
                                $resultado = mysql_query($sql, $conexion) or die(mysql_error());
                                $numRegistros = mysql_num_rows($resultado);
                                foreach ($emisor as $em) {
                                    if ($versionxml == "3.2") {
                                        $rfc_xml = $em->getAttribute('rfc');
                                    } else {
                                        $rfc_xml = $em->getAttribute('Rfc');
                                    }
                                    if (trim($rfc_xml) == trim($rfc)) {
                                        foreach ($emp as $rec) {
                                            if ($versionxml == "3.2") {
                                                $rfc_xml_agricola = $rec->getAttribute('rfc');
                                            } else {
                                                $rfc_xml_agricola = $rec->getAttribute('Rfc');
                                            }
                                            if (trim($rfc_xml_agricola) == trim($rfcAgricola)) {
                                                if ($orden == "" or $counts[$orden] == 1) {
                                                    if ($numRegistros == 0) {
                                                        $result['resultado'] = true;
                                                        if ($result['resultado'] == "true") {
                                                            $name_xml = trim($rfc) . '_' . $uuid . '.xml';
                                                            $name_pdf = trim($rfc) . '_' . $uuid . '.pdf';
                                                            //asignamos el nombre del xml a los pdfs
                                                            if ($cSucursal == "003") {
                                                                rename("cdguzman/pdfs/" . $_FILES['pdf']['name'][$k], "cdguzman/pdfs/" . $name_pdf);
                                                                copy("cdguzman/pdfs/" . $name_pdf, "respaldo/cdguzman/" . $name_pdf);
                                                            } else {
                                                                rename("pdfs/" . $_FILES['pdf']['name'][$k], "pdfs/" . $name_pdf);
                                                                copy("pdfs/" . $name_pdf, "respaldo/" . $name_pdf);
                                                            }
                                                            $_record_xml = "INSERT INTO records_xml_notas (rfc,fecha,nombre_xml,folio_uuid,folio_interno,orden_compra,cSucursal,valido,errores,nimporte,uuid_relacionado) VALUES ('$rfc','$fecha','$nombre','$uuid','$folio_int','$orden2','".$cSucursal."','1','',".$nImporteTotal.",'".$uuid_relacionado."')";
                                                            mysql_query($_record_xml);
                                                            if ($tipo == 'egreso') {
                                                                if ($cSucursal == "003") {
                                                                    $dom->save("cdguzman/notas_validas/" . $name_xml);
                                                                    copy("cdguzman/notas_validas/" . $name_xml, "respaldo/cdguzman/" . $name_xml);
                                                                }else {
                                                                    // guarda xml con addenda
                                                                    $dom->save("notas_validas/" . $name_xml);
                                                                    copy("notas_validas/" . $name_xml, "respaldo/" . $name_xml);
                                                                }
                                                            } else {
                                                                if ($cSucursal == "003") {
                                                                    // guarda xml con addenda
                                                                    $dom->save('cdguzman/validos/' . $name_xml);
                                                                    copy("cdguzman/validos/" . $name_xml, "respaldo/cdguzman/" . $name_xml);
                                                                } else {
                                                                    // guarda xml con addenda
                                                                    $dom->save('validos/' . $name_xml);
                                                                    copy("validos/" . $name_xml, "respaldo/" . $name_xml);
                                                                }
                                                            } 
                                                            $response["status"] = "success";
                                                            $response["message"] = "El documento CFDI fue guardado correctamente."; 
                                                        }                                                             
                                                    }else{
                                                        $response["status"] = "error";
                                                        $response["message"] = "Documento con folio UUID ya existente.";
                                                    }
                                                } 
                                            }else{
                                                $response["status"] = "error";
                                                $response["message"] = "No concuerda el RFC.";
                                            } 
                                        }
                                    } 
                                }
                            }
                            $j++;
                        }
                    } 
                    //incrementamos k de pdfs para recorrer array
                    $k++;
                }
            } 
            //incrementamos i de xmls para recorrer array
            $i++;
        }    
        echo json_encode($response);       
        //echo "valor de ".$uuid_relacionado;
    }    
}
?>
