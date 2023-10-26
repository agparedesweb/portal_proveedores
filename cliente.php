<?php
require_once("lib/nusoap.php");
// Crear un cliente apuntando al script del servidor (Creado con WSDL)
$serverURL = 'https://www.clickfactura.com.mx/webservice/yii/validador/';
$cliente = new nusoap_client("$serverURL?wsdl", 'wsdl');
$xml = file_get_contents('recibidos/TOM850506EL9L6151029102014.xml');
$DOC = new DOMDocument('1.0', 'utf-8');
$DOC->loadXML($xml);
$xml = base64_encode($xml);
//echo $xml;

$result = $cliente->call(
                "validarXml", // Funcion a llamar
                array(
                    'Usuario'=>"APA9707035N4",
                    'Pass'=>'pruebaValidador',
                    'xmlData'=>$xml,
                ), // Parametros pasados a la funcion   
                "uri:$serverURL/$serverScript", // namespace
                "uri:$serverURL/$serverScript/$metodoALlamar"       // SOAPAction
        );

if($result['resultado'] =="true"){
    echo "Validacion correcta del xml"."<br>";
    echo "Estado del documento: ".$result['estadoSAT']."<br>";
    echo "El SAT reporta: ".$result['codigoEstatusSAT']."<br>";
}
else{
    if(count($result['errores'])> 0){
        echo "El xml presenta Errores"."<br>";
        foreach ($result['errores'] as $error){
            echo $error['tipo_error']." Etiqueta:".$error['etiqueta']." Atributo:".$error['atributo']." Valor:".$error['valor']." Comentario:".$error['comentario']."<br>";
        }
    }
        
    
}
?>