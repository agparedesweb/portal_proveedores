<?php 
session_start();
include("seguridad.php");
date_default_timezone_set('America/Chihuahua');
/*$conexion = mysql_connect("localhost", "root", "12345");
$date = date_create(); 
mysql_select_db("tspvcomm_proveedores", $conexion);*/
$conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
$date = date_create(); 
mysql_select_db("tspvcomm_proveedores", $conexion);
$cSucursal=@$_SESSION["sucursal"];
$prov = $_SESSION["cve_pro"]; 

$rqrd="";


?> 
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<title>Agricola Paredes :: Validaci&oacute;n de XML</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/nav.css" rel="stylesheet" type="text/css" media="all"/>
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-message-box@3.2.2/dist/messagebox.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<script type="text/javascript" src="js/Chart.js"></script>
<script type="text/javascript" src="js/jquery.easing.js"></script>
<script type="text/javascript" src="js/jquery.ulslide.js"></script>
<script type="text/javascript" src="js/bootstrap-filestyle.js"> </script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-message-box@3.2.2/dist/messagebox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
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
<script type="text/javascript" src="funciones/functions.js"></script>
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
	
	
	
//Funcion para validar XML y leerlo  --20-10-2023
function validaXML(index,lblID){
    //valida cada input del formulario por separado
    var inputXML = document.getElementById(index);
    
    if (inputXML.files.length != 0) {
        var archivoXML = inputXML.files[0];
     
        // Crea un objeto FileReader para leer el contenido del archivo XML
        var reader = new FileReader();
        reader.onload = function(e) {
        var contenidoXML = e.target.result;
        
       // console.log(contenidoXML);
       
        // Llama a una función para procesar el contenido del archivo XML
        procesarXML(contenidoXML,index,lblID);
     };
        // Lee el archivo XML como texto
         reader.readAsText(archivoXML);
    }else{
        console.log("### No se ha seleccionado ningún archivo XML.");
    }
    
    
}
//Procesa y convierte la respuesta del XML para recorrerlo
function procesarXML(xmlString,index,lblID) {
     
  var rfcParedes ="APA9707035N4";
  var regimenFiscalParedes="622";
    
  var parser = new DOMParser();
  var xmlDoc = parser.parseFromString(xmlString, 'text/xml');

  // se accede a los elementos del archivo XML y procesarlos
  var receptor = xmlDoc.getElementsByTagName('cfdi:Receptor')[0];

  // Acceder a atributos específicos del xml
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
                    resetInput(index,lblID);
  }else if(receptorRfc=='' || receptorRfc==null){
          //Mensaje Informativo
            Swal.fire({
                      icon: 'warning',
                      title: 'Datos incorrectos',
                      text: 'valida el XML ya que el RFC no corresponde al de la empresa o no esta incluido en el archivo.',
                      footer: 'Nuestros Datos:  RFC: '+ rfcParedes +' | Regimen Fiscal: '+ regimenFiscalParedes +' '    
                    })  
                    resetInput(index,lblID);
  }else{
            //Mensaje Informativo
            Swal.fire({
                      icon: 'warning',
                      title: 'Datos incorrectos',
                      text: 'valida el XML ya que no corresponde el RFC y Regimen fiscal con el de la empresa o no estan incluidos en el archivo. ',
                      footer: 'Nuestros Datos:  RFC: '+ rfcParedes +' | Regimen Fiscal: '+ regimenFiscalParedes +' '    
                    })        
                    resetInput(index,lblID);
    }
}
// Función para reiniciar el input y cambiar el mensaje de etiqueta
function resetInput(index,lblID) {
  var inputXML = document.getElementById('inputXML' + index);
  var label = document.getElementById('lbl[' + lblID + ']'); // Obtener la etiqueta por ID

  if (inputXML) {
    inputXML.value = ""; // Borra el valor del elemento input
  }
  if (label) {
    label.textContent = "Selecciona tu XML"; // Cambia el mensaje de etiqueta
  }
}	
	
</script>
</head>
<body onload="loadOcs(<?php echo "'".$prov."'"; ?>,<?php echo "'".$cSucursal."'"; ?>);traeFactorOc(<?php echo "'".$cSucursal."'"; ?>);">			       
	<div class="wrap">
		<div class="header">
			<div id="prueb">
				<span id="date"><?php echo date_format($date, 'd-M-Y H:i:s');?></span>
				<a id="cerrar" href="inicio-normal.php">Regresar</a>
				<a id="cerrar" href="logout.php">Cerrar sesi&oacute;n</a>
			</div>
		<a href="http://www.aparedes.com.mx" target="_blank"><img id="logo" src="img/logo2.png"></a>	
		</div>	    					     
	</div>
	  <div class="main">  
	    <div class="wrap">  		 
	       <div class="column_left">
	    		 <div class="menu_box">
	    		 	 <h3>Recepci&oacute;n de Comprobantes</h3>
	    		 	   <div class="menu_box_list">
							<form name="frm_index" action="upload-normal.php" enctype="multipart/form-data" method="post" onsubmit="javascript:return validando();">
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
												<input type="file" id="1" name="xml[]" accept=".xml" onchange="fgVerificaValoresPago(1);changename(this.value,1);loadData(this,1);validaXML(1,1);">
												<label id="lbl[1]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores0" name="oc[]" onchange="fgTraeValoresPago(1,0);fgDesactivaOc($(this).val(),0);fgVerificaImporteOc($(this).val());traeImporteOc($(this).val(),0);" class="ocpendiente">
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
												<input type="file" id="3" name="xml[]" accept=".xml" onchange="changename(this.value,3);loadData(this,3);fgVerificaValoresPago(3);validaXML(3,3);">
												<label id="lbl[3]" for="file">Selecciona tu XML</label>
											</p>
											
										</td> 
										<td>
											<select id="valores1" name="oc[]" onchange="fgTraeValoresPago(3,1);fgDesactivaOc(this.value,1);" class="ocpendiente">
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
												<input type="file" id="5" name="xml[]" accept=".xml" onchange="changename(this.value,5);loadData(this,5);fgVerificaValoresPago(5);validaXML(5,5);">
												<label id="lbl[5]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores2" name="oc[]" onchange="fgTraeValoresPago(5,2);fgDesactivaOc(this.value,2);" class="ocpendiente">
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
												<input type="file" id="7" name="xml[]" accept=".xml" onchange="changename(this.value,7);loadData(this,7);fgVerificaValoresPago(7);validaXML(7,7);">
												<label id="lbl[7]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores3" name="oc[]" onchange="fgTraeValoresPago(7,3);fgDesactivaOc(this.value,3);" class="ocpendiente">
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
												<input type="file" id="9" name="xml[]" accept=".xml" onchange="changename(this.value,9);loadData(this,9);fgVerificaValoresPago(9);validaXML(9,9);">
												<label id="lbl[9]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores4" name="oc[]" onchange="fgTraeValoresPago(9,4);fgDesactivaOc(this.value,4);" class="ocpendiente">
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
												<input type="file" id="11" name="xml[]" accept=".xml" onchange="changename(this.value,11);loadData(this,11);fgVerificaValoresPago(11);validaXML(11,11);">
												<label id="lbl[11]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores5" name="oc[]" onchange="fgTraeValoresPago(11,5);fgDesactivaOc(this.value,5);" class="ocpendiente">
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
												<input type="file" id="13" name="xml[]" accept=".xml" onchange="changename(this.value,13);loadData(this,13);fgVerificaValoresPago(13);validaXML(13,13);">
												<label id="lbl[13]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores6" name="oc[]" onchange="fgTraeValoresPago(13,6);fgDesactivaOc(this.value,6);" class="ocpendiente">
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
												<input type="file" id="15" name="xml[]" accept=".xml" onchange="changename(this.value,15);loadData(this,15);fgVerificaValoresPago(15);validaXML(15,15);">
												<label id="lbl[15]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores7" name="oc[]" onchange="fgTraeValoresPago(15,7);fgDesactivaOc(this.value,7);" class="ocpendiente">
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
												<input type="file" id="17" name="xml[]" accept=".xml" onchange="changename(this.value,17);loadData(this,17);fgVerificaValoresPago(17);validaXML(17,17);">
												<label id="lbl[17]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores8" name="oc[]" onchange="fgTraeValoresPago(17,8);fgDesactivaOc(this.value,8);" class="ocpendiente">
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
												<input type="file" id="19" name="xml[]" accept=".xml" onchange="changename(this.value,19);loadData(this,19);fgVerificaValoresPago(19);validaXML(19,19);">
												<label id="lbl[19]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores9" name="oc[]" onchange="fgTraeValoresPago(19,9);fgDesactivaOc(this.value,9);" class="ocpendiente">
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
			<div id="ex1" data-dismiss="modal" class="modal">
				<form id="formNotas" enctype="multipart/form-data" method="post">
					<table id="modalnotas" style="width: 100%;text-align: center;">
						<thead>
							<tr>
								<td id="modalnota" colspan="3"><span>Carga tus notas de cr&eacute;dito</span><div class=""></div></td>
							</tr>
						</thead>
						<tbody id="tbmodalnotas">
							<tr>
								<td>
									<p class="file">
										<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="changename(this.value,0);ocobliga(0);">
										<label id="" style="width: 12em;padding: 0.6em;" for="file">PDF</label>
									</p>
								</td>
								<td>
									<p class="file">
										<input type="file" class="xmlnotas" name="xml[]" accept=".xml" >
										<label id="" style="width: 12em;padding: 0.6em;" for="file">XML</label>
									</p>
								</td>	
								<td>
									<p id="eliminanota" class="file"><label class="Delete" style="width: 1em;padding: 0.6em;background: red;color: white;font-weight: bold;cursor: pointer;">X</label></p>
									<div id="uploadnota" style="width: 30px; height: 30px; ">
										<div class="loading loading--full-height"></div>
									</div>
								</td>								
							</tr>	
						</tbody>											
					</table>	
					<input type="hidden" id="ocSeleccionada" name="ocSeleccionada">
					<input type="submit" id="btnval" style="width: 7em;" value="Enviar">		
				</form>	
				<span><button id="addnotemodal" onclick="copiarUltimaFila();">Agregar Nota +</button></span>
			</div>
			<!-- Link to open the modal -->
			<p style="display:none;"><a href="#ex1" rel="modal:open">Open Modal</a></p>
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
					if ('tipodecomprobante' == res) {
						ret=root.attributes[i];
						cTipo=ret.nodeValue;
						cTipo=cTipo.toLowerCase();
						if (cTipo=="egreso" && cTipo=="e") {
							$.MessageBox("El archivo "+namexml+" no corresponde a una factura");
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

