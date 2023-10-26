<?php 

Class Crearxml
{
	/**
    *sube archivos al servidor a través de un formulario
    *@access public
    *@param array $files estructura de array con todos los archivos a subir
    */
	public function createxml($xml64)
	{
		$xml = new DomDocument('1.0', 'ISO-8859-1'); 
		$xml2 = file_get_contents($xml64);
		$DOC = new DOMDocument('1.0', 'utf-8');
		$DOC->loadXML($xml2);
		$base = base64_encode($xml2);


		$root = $xml->createElement('SOAP-ENV:Envelope');
		$root = $xml->appendChild($root); 

		$atr1 = $xml->createAttribute('SOAP-ENV:encodingStyle');
		$atr2 = $xml->createAttribute('xmlns:SOAP-ENV');
		$atr3 = $xml->createAttribute('xmlns:xsd');
		$atr4 = $xml->createAttribute('xmlns:xsi');
		$atr5 = $xml->createAttribute('xmlns:SOAP-ENC');
		$atr6 = $xml->createAttribute('xmlns:tns');
		// Se lo acoplo al elemento "contactos"
		$root->appendChild($atr6); 
		$root->appendChild($atr5);  
		$root->appendChild($atr4);
		$root->appendChild($atr3); 
		$root->appendChild($atr2);
		$root->appendChild($atr1);
		// Creo el texto
		$atr1v = $xml->createTextNode('http://schemas.xmlsoap.org/soap/encoding/');
		$atr2v = $xml->createTextNode('http://schemas.xmlsoap.org/soap/envelope/');
		$atr3v = $xml->createTextNode('http://www.w3.org/2001/XMLSchema');
		$atr4v = $xml->createTextNode('http://www.w3.org/2001/XMLSchema-instance');
		$atr5v = $xml->createTextNode('http://schemas.xmlsoap.org/soap/encoding/');
		$atr6v = $xml->createTextNode('urn:respuestaValidacion');

		// Se lo asigno al atributo
		$atr1->appendChild($atr1v);
		$atr2->appendChild($atr2v);
		$atr3->appendChild($atr3v);
		$atr4->appendChild($atr4v);
		$atr5->appendChild($atr5v);
		$atr6->appendChild($atr6v);

		$body=$xml->createElement('SOAP-ENV:Body'); 
		$body =$root->appendChild($body); 


		$vcfdi=$xml->createElement('tns:validarCFDI'); 
		$vcfdi =$body->appendChild($vcfdi); 

		$atr_tns = $xml->createAttribute('xmlns:tns');
		$vcfdi->appendChild($atr_tns); 
		$atrv_tns = $xml->createTextNode('urn:respuestaValidacion');
		$atr_tns->appendChild($atrv_tns);

		$susrfc=$xml->createElement('suscriptorRFC','APA9707035N4'); 
		$susrfc =$vcfdi->appendChild($susrfc); 

		$atr_rfc = $xml->createAttribute('xsi:type');
		$susrfc->appendChild($atr_rfc); 
		$atrv_rfc = $xml->createTextNode('xsd:string');
		$atr_rfc->appendChild($atrv_rfc);

		$ag_ti=$xml->createElement('agenteTI','APA9707035N4'); 
		$ag_ti =$vcfdi->appendChild($ag_ti); 

		$atr_agti = $xml->createAttribute('xsi:type');
		$ag_ti->appendChild($atr_agti); 
		$atrv_agti = $xml->createTextNode('xsd:string');
		$atr_agti->appendChild($atrv_agti);

		$doc_xml=$xml->createElement('documentoXML',$base); 
		$doc_xml =$vcfdi->appendChild($doc_xml); 

		$atr_dxml = $xml->createAttribute('xsi:type');
		$doc_xml->appendChild($atr_dxml); 
		$atrv_dxml = $xml->createTextNode('xsd:string');
		$atr_dxml->appendChild($atrv_dxml);
		return $xml; 

	}


}
	
/*$xml->formatOutput = true; 

          
    
            $strings_xml = $xml->saveXML(); 

            $xml->save('XML/prueba.xml'); 



echo 'Enhorabuena se  creo el XML exitosamente'; 
*/
?> 