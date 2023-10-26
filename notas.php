<?php 
session_start();
include("seguridad.php");
date_default_timezone_set('America/Chihuahua');
/*$conexion = mysql_connect("localhost", "root", "12345");
$date = date_create(); 
mysql_select_db("system_validator", $conexion);*/
$conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
$date = date_create(); 
mysql_select_db("tspvcomm_proveedores", $conexion);
$cSucursal=@$_SESSION["sucursal"];
$prov = @$_SESSION["cve_pro"]; 
$vqtemp="SELECT CCVE_TEMPORADA FROM CTL_TEMPORADAS WHERE NACTIVO=1 AND CSUCURSAL='".$cSucursal."'";
$restemp=mysql_query($vqtemp, $conexion) or die ("Error con la temporada");
$vcTemporada = mysql_result($restemp,0,0); 
$rqrd="";

function consulta(){
	global $prov;
	global $rqrd;
	global $cSucursal;
	$data = array("cProveedor" => $prov,"cSucursal" => $cSucursal);
    //url contra la que atacamos

    //$ch = curl_init("http://177.244.36.158:7373/api/traeocproveedornotas");
    $ch = curl_init("https://192.168.1.22:9000/api/traeocproveedornotas");
    //a true, obtendremos una respuesta de la url, en otro caso, 
    //true si es correcto, false si no lo es
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //establecemos el verbo http que queremos utilizar para la peticiÃ³n
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    //enviamos el array data
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
    //obtenemos la respuesta
    $response = curl_exec($ch);
    // Se cierra el recurso CURL y se liberan los recursos del sistema
    curl_close($ch);
    if(!$response) {
        $rqrd="false";
    }else{
        $resultado = str_replace("[", "", $response);
        $resultado = str_replace("]", "", $resultado);
        $resultado = str_replace('"', "", $resultado);
        $resultado =explode(",", $resultado);
        foreach($resultado as $oc){
     		echo "<option value=".$oc.">".$oc."</option>";
	    }
    }
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script type="text/javascript" src="js/moment.js"></script>
<script>
$(function() {
	var now = moment().format("DD-MMM-YYYY, h:MM A");
	//$('#date').append(now);
});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		x="<?php echo $_SESSION['flag'];?>";
		if (x==1) {
			setTimeout(function(){
			var url = "verificacion.php";
				$.ajax({
					url: url,
					type: "GET",
					success: function(datos){
						$("#cpopup").html(datos);
						$("#popup").fadeIn();
						x="<?php unset($_SESSION['flag']);?>";
					}
				});
				return false;
			});
		
			$("#close").click(function(){
			$("#popup").fadeOut();
			});	
		};
				
	});
</script>
<script type="text/javascript">
function ocs(p) {
	var x = "<?php echo $rqrd?>";
	if (x == "true"){
		document.getElementById('valores' + p).setAttribute("required", "true");	
 	}
} 

//Funcion para validar XML y leerlo  --20-10-2023
function validaXML(index){
    //valida cada input del formulario por separado
    var inputXML = document.getElementById(index);
    
    if (inputXML.files.length != 0) {
        var archivoXML = inputXML.files[0];
     
        // Crea un objeto FileReader para leer el contenido del archivo XML
        var reader = new FileReader();
        reader.onload = function(e) {
        var contenidoXML = e.target.result;
        
       // console.log(contenidoXML);
       
        // Llama a una funci¨®n para procesar el contenido del archivo XML
        procesarXML(contenidoXML);
     };
        // Lee el archivo XML como texto
         reader.readAsText(archivoXML);
    }else{
        console.log("### No se ha seleccionado ning¨²n archivo XML.");
    }
    
    
}
//Procesa y convierte la respuesta del XML para recorrerlo
function procesarXML(xmlString) {
    
  var rfcParedes ="APA9707035N4";
  var regimenFiscalParedes="622";
    
  var parser = new DOMParser();
  var xmlDoc = parser.parseFromString(xmlString, 'text/xml');

  // se accede a los elementos del archivo XML y procesarlos
  var receptor = xmlDoc.getElementsByTagName('cfdi:Receptor')[0];

  // Acceder a atributos espec¨ªficos del xml
  var receptorRfc = receptor.getAttribute('Rfc');
  var regimenFis = receptor.getAttribute('RegimenFiscalReceptor');
    //valida RFC y Regimen sean correctos
  if(regimenFiscalParedes==regimenFis && rfcParedes==receptorRfc){
      console.log('## Los datos del XML son correctos ##');
  }else if(regimenFis=='' || regimenFis==null){
           //Mensaje Informativo
            Swal.fire({
                      icon: 'warning',
                      title: 'Datos incorrectos',
                      text: 'valida el XML ya que el Regimen Fiscal no corresponde al de la empresa o no esta incluido en el archivo.',
                      footer: 'Nuestros Datos: RFC: '+ rfcParedes +' | Regimen Fiscal: '+ regimenFiscalParedes +' '    
                    })    
  }else if(receptorRfc=='' || receptorRfc==null){
          //Mensaje Informativo
            Swal.fire({
                      icon: 'warning',
                      title: 'Datos incorrectos',
                      text: 'valida el XML ya que el RFC no corresponde al de la empresa o no esta incluido en el archivo',
                      footer: 'Nuestros Datos: RFC: '+ rfcParedes +' | Regimen Fiscal: '+ regimenFiscalParedes +' '    
                    })     
  }else{
            //Mensaje Informativo
            Swal.fire({
                      icon: 'warning',
                      title: 'Datos incorrectos',
                      text: 'valida el XML ya que no corresponde el RFC y Regimen fiscal con el de la empresa o no estan incluidos en el archivo. ',
                      footer: 'Nuestros Datos: RFC: '+ rfcParedes +' | Regimen Fiscal: '+ regimenFiscalParedes +' '    
                    })        
    }
}



function changename(v,p)
{
	v = v.split('\\');
 	var nom = v[v.length-1];
	var pdfs = document.getElementsByName('pdf[]');
	var lbls = document.getElementById('lbl['+p+']');
	lbls.innerHTML = nom;
}
function ocobliga(p){
	var oc ="<?php echo $_SESSION['oc_r'];?>";
	if (oc == 'S'){
		document.getElementById('valores' + p).setAttribute("required", "true");
		document.getElementById('loading').style.display = 'none';	
 	}
}

function loadOcsNotas(prmProveedor,prmSucursal,prmTemporada){
	//alert(prmProveedor+" "+prmSucursal);
    $.ajax({        
        //url: 'http://192.168.1.22:8000/api/traeocproveedornotas',
        url: 'https://api.aparedes.com.mx:9000/api/traeocproveedornotas',
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        json: true, 
        cache:false,
        //processData: false,
        //data: JSON.stringify(param),
        data: "cProveedor="+prmProveedor+"&cSucursal="+prmSucursal+"&cTemporada="+prmTemporada,
        success: function (data, textStatus, xhr) {  
            for (var i = data.length - 1; i >= 0; i--) {
                $('.ocpendiente').append(`<option value="${data[i]}">${data[i]}</option>`);
            }
        },  
        error: function(jq,status,message) {
            console.log('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
        }
    });
}




function validando()
{
	var suma = 0;
	var f = document.frm_index;
	var pdfs = document.getElementsByName('pdf[]');
	var xmls = document.getElementsByName('xml[]');
	var flag = false;
	var ext_xml="";
	var ext_pdf="";
	var s=0;
	var pdf_actual="";
	var xml_actual="";
	var no_hay=false;
	var m_pdfs=[];
	var m_xmls=[];
	var results=[];	
	for (var i = 0, j = pdfs.length; i < j; i++) 
 	{
 		results[i]="";
 		pdf_actual=pdfs[i].value;
 		xml_actual=xmls[i].value;
 		ext_pdf=(pdf_actual.substring(pdf_actual.lastIndexOf("."))).toLowerCase();
 		ext_xml=(xml_actual.substring(xml_actual.lastIndexOf("."))).toLowerCase();
 		if(pdf_actual != '' & xml_actual != '')
    	{
    		if(ext_pdf == ".pdf" && ext_xml == ".xml"){
    			s=1;
    			flag=false;
    		}
    		else{
    			alert("Hay un problema con tus archivos favor de verificar");
    			document.getElementById('loading').style.display = 'none';
    			return false;
    		}
    	}
    	else if(pdf_actual != '' & xml_actual == '')
    	{
    		s=1;
    		//si pdf es diferente de nulo y xml es igual a nulo    		
    		if(ext_pdf == ".pdf"){
	    		results[i]+='Falta el XML del archivo '+pdf_actual;
	 			document.getElementById('loading').style.display = 'none';
	 			flag=true;
	 		}
	 		else{
    			results[i]+='El documento '+pdf_actual+' no es un archivo PDF favor de verificar';
    			document.getElementById('loading').style.display = 'none';
    			flag=true;
    		}
     	}
     	else if(pdf_actual == '' && xml_actual != '')
    	{
    		s=1;
    		//si pdf es igual a nulo y si xml es diferente de nulo    		
    		if(ext_xml == ".xml"){
    			results[i]+='Falta el PDF del archivo '+xml_actual;
 				document.getElementById('loading').style.display = 'none';
 				flag=true;
 			}
    		else{
    			results[i]+='El documento '+xml_actual+' no es un archivo XML favor de verificar';
    			document.getElementById('loading').style.display = 'none';
    			flag=true;
    		}
    	}
    	else 
    	{
    		if(s>0){
    			continue;	
			}
			else{
				results[i]+='No has capturado ningun archivo';
				document.getElementById('loading').style.display = 'none';	
				flag=true;
			}
       	}
   	}
   	if(flag==true){
   		alert(results.join("\n"));	
   		return false;
   	}
   	else{
   		return true;
   	}
 }
 
</script>
</head>
<body onload="loadOcsNotas(<?php echo "'".$prov."'"; ?>,<?php echo "'".$cSucursal."'"; ?>,<?php echo "'".$vcTemporada."'"; ?>);">			       
	<div class="wrap">
		<div class="header">
			<div id="prueb">
				<span id="date"><?php echo date_format($date, 'd-M-Y H:i:s');?></span>
				<a id="cerrar" href="inicio-normal.php">Regresar</a>
				<a id="cerrar" href="logout.php">Cerrar sesi&oacute;n</a>
			</div>
		<a href="https://www.aparedes.com.mx" target="_blank"><img id="logo" src="img/logo2.png"></a>	
		</div>	    					     
	</div>
	  <div class="main">  
	    <div class="wrap">  		 
	       <div class="column_left">
	    		 <div class="menu_box">
	    		 	 <h3>Recepci&oacute;n Notas de Cr&eacute;dito</h3>
	    		 	 <p id="xml"></p>
	    		 	   <div class="menu_box_list">
							<form name="frm_index" action="uploadnc.php" enctype="multipart/form-data" method="post" onsubmit="javascript:return validando();">
								<table id="lineas" style="width: 100%;text-align: center;">
									<tr>
										<td><span>Selecciona tus PDF</span><div class="clear"></div></td>
										<td><span>Selecciona tus XML</span><div class="clear"></div></td>
										<td><span>Selecciona la orden de compra</span><div class="clear"></div></td> 								    
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="changename(this.value,0);ocobliga(0);">
												<label id="lbl[0]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<!--changename(this.value,1);-->
												<input type="file" id="1" name="xml[]" accept=".xml" onchange="changename(this.value,1);loadData(this,1);validaXML(1);">
												<label id="lbl[1]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores0" name="oc[]" class="ocpendiente">
												<option></option>
											</select>
										</td> 								    
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="changename(this.value,2);ocobliga(1);">
												<label id="lbl[2]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file"> 
												<input type="file" id="3" name="xml[]" accept=".xml" onchange="changename(this.value,3);loadData(this,3);validaXML(3);">
												<label id="lbl[3]" for="file">Selecciona tu XML</label>
											</p>
											
										</td> 
										<td>
											<select id="valores1" name="oc[]" class="ocpendiente">
												<option></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="changename(this.value,4);ocobliga(2);">
												<label id="lbl[4]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="5" name="xml[]" accept=".xml" onchange="changename(this.value,5);loadData(this,5);validaXML(5);">
												<label id="lbl[5]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores2" name="oc[]" class="ocpendiente">
												<option></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf"onchange="changename(this.value,6);ocobliga(3);">
												<label id="lbl[6]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="7" name="xml[]" accept=".xml" onchange="changename(this.value,7);loadData(this,7);validaXML(7);">
												<label id="lbl[7]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores3" name="oc[]" class="ocpendiente">
												<option></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="changename(this.value,8);ocobliga(4);">
												<label id="lbl[8]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="9" name="xml[]" accept=".xml" onchange="changename(this.value,9);loadData(this,9);validaXML(9);">
												<label id="lbl[9]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores4" name="oc[]" class="ocpendiente">
												<option></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="changename(this.value,10);ocobliga(5);">
												<label id="lbl[10]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="11" name="xml[]" accept=".xml" onchange="changename(this.value,11);loadData(this,11);validaXML(11);">
												<label id="lbl[11]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores5" name="oc[]" class="ocpendiente">
												<option></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="changename(this.value,12);ocobliga(6);">
												<label id="lbl[12]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="13" name="xml[]" accept=".xml" onchange="changename(this.value,13);loadData(this,13);validaXML(13);">
												<label id="lbl[13]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores6" name="oc[]" class="ocpendiente">
												<option></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="changename(this.value,14);ocobliga(7);">
												<label id="lbl[14]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="15" name="xml[]" accept=".xml" onchange="changename(this.value,15);loadData(this,15);validaXML(15);">
												<label id="lbl[15]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores7" name="oc[]" class="ocpendiente">
												<option></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="changename(this.value,16);ocobliga(8);">
												<label id="lbl[16]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="17" name="xml[]" accept=".xml" onchange="changename(this.value,17);loadData(this,17);validaXML(17);">
												<label id="lbl[17]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores8" name="oc[]" class="ocpendiente">
												<option></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="changename(this.value,18);ocobliga(9);">
												<label id="lbl[18]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="19" name="xml[]" accept=".xml" onchange="changename(this.value,19);loadData(this,19);validaXML(19);">
												<label id="lbl[19]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores9" name="oc[]" class="ocpendiente">
												<option></option>
											</select>
										</td>
									</tr>							
								</table>
								<input type="hidden" name="action" value="upload">
								<input type="submit" id="btnval" value="Enviar" onclick="$('#loading').show();">
							</form>
					</div>
					<div id="loading" style="display:none; float: right; padding: 0.8em;"><img src="img/load.gif" alt="" />Validando...</div>

	    		 </div>
	    		 
	  		</div> 
	  		<div id="popup">
				<a href="#" id="close"><img src="img/error.png" /></a>
				<div id="cpopup"></div>
			</div>            
    	<div class="clear"></div>
    	<script>
			function loadData(fileInput,id) {
				var file = fileInput.files[0];
				var cFile= fileInput.files[0].name;
				var fileURL = URL.createObjectURL(file);
				var req = new XMLHttpRequest();
				req.open('GET', fileURL);
				req.onload = function() {
					URL.revokeObjectURL(fileURL);
					populateData(fileInput.form[id], this.responseXML,cFile,id);
				};
				req.onerror = function() {
					URL.revokeObjectURL(fileURL);
					console.log('Error loading XML file.');
				};
				req.send();
			}

			function populateData(form, xmlDoc,namexml,id) {
				var root = xmlDoc.documentElement;
				var msg="";
				var res = "";
				var ret="";
				var lbls = document.getElementById('lbl['+id+']');
				for (var i = 0; i < root.attributes.length; i++) {					
					msg=root.attributes[i].name;
					res=msg.toLowerCase();
					if ('tipodecomprobante'==res) {
						ret=root.attributes[i];
						cTipo=ret.nodeValue;
						cTipo=cTipo.toLowerCase();
						if (cTipo=="ingreso" || cTipo=="i" || cTipo=="I") {
							//alert("El archivo "+namexml+" no corresponde a una nota de credito");
							Swal.fire({
							  	title: "Informaci&oacute;n",
							  	html: "El archivo XML cargado no corresponde al de una nota de credito",
							  	icon: "info",
							  	button: "Aceptar",
							});
							document.getElementById(id).value = "";
							lbls.innerHTML = "Selecciona tu XML";
							return;
						};
					};
				};				
				
			}
		</script>
 	 </div>
   </div>
  		 <div class="copy-right">
				<p><a href="http://www.aparedes.com.mx">&copy; 2014 Agricola Paredes S.A.P.I. de C.V.</a> </p>
	 	 </div>   
</body>
</html>

