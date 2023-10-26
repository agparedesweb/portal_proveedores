<?php session_start();
include("seguridad.php");
date_default_timezone_set('America/Chihuahua');
/*$conexion = mysql_connect("localhost", "root", "12345");
$date = date_create(); 
mysql_select_db("system_validator", $conexion);*/
$conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
$date = date_create(); 
mysql_select_db("tspvcomm_proveedores", $conexion);
@$valor = $_GET['valor'];
$trans = $_SESSION['trans']; 
$sql_temporada=mysql_query("SELECT CCVE_TEMPORADA FROM CTL_TEMPORADAS WHERE NACTIVO=1 AND CSUCURSAL in ('001')");
$temporada=mysql_result($sql_temporada,0);
//$temporada="18-19";
 
function consulta(){
	global $trans;
	global $rqrd;
	global $temporada;
	$query=mysql_query("SELECT * FROM eye_maniffacturados WHERE CRELACIONADO='N' and  CCVE_PROVEEDOR='".$trans."' ORDER BY CFOLIO_REMIS");
	$totalRows = mysql_num_rows($query);
	$row = 0;
	if(@$query){
		$rqrd="true";
		while (@$row = mysql_fetch_assoc(@$query)){
		echo "<option value=".$row['CMERCADO'].$row['CFOLIO_REMIS'].">".$row['CFOLIO_REMIS']."</option>";
		}

	}	
}
?> 
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Agricola Paredes :: Validaci&oacute;n de XML</title>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/nav.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/select2.css" rel="stylesheet" type="text/css" media="all"/>
<link href='https://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/select2.min.js"></script>
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
<script src="js/sweet-alert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="js/sweet-alert.css">
<script type="text/javascript" src="js/moment.js"></script>
<script>
$(function() {
	var now = moment().format("DD-MMM-YYYY, h:MM A");
	//$('#date').append(now);
});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		x="<?php echo $_SESSION['flag']; ?>";
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
$(document).ready(function() {
	function recargar(){
	    var x[] = '<?php consulta();?>';
	    
		//realizo la call via jquery ajax
	    $.ajax({
			url: 'index.php',
			type: "GET",
       		data: x,
			success: function(data){
				$('.e1').html(data);
			}
		});
	}
	/*xmlhttp.open("GET","index.php?valor="true);
  	xmlhttp.send();*/
});
</script>
<script type="text/javascript">
function ocs(p) {
	var x = "<?php echo $rqrd?>";
	alert(x);
	if (x == "true"){
		document.getElementById('valores' + p).setAttribute("required", "true");	
 	}
}


var selval='';
var f=false;
var pos=[];
$(function(){
	$('#valores0').select2()
        .on("change", function(e) {
        pos[0]=1;
    })
	$('#valores1').select2()
        .on("change", function(e) {
        pos[1]=1;
    })
    $('#valores2').select2()
        .on("change", function(e) {
        pos[2]=1;
    })
    $('#valores3').select2()
        .on("change", function(e) {
        pos[3]=1;
    })
    $('#valores4').select2()
        .on("change", function(e) {
        pos[4]=1;
    })
    $('#valores5').select2()
        .on("change", function(e) {
        pos[5]=1;
    })
	$('#valores6').select2()
        .on("change", function(e) {
        pos[6]=1;
    })
    $('#valores7').select2()
        .on("change", function(e) {
        pos[7]=1;
    })
    $('#valores8').select2()
        .on("change", function(e) {
        pos[8]=1;
    })
    $('#valores9').select2()
        .on("change", function(e) {
        pos[9]=1;
    })
});

//Funcion para validar XML y leerlo  --20-10-2023
function validaXML(index,lblID){
    //valida cada input del formulario por separado
    var inputXML = document.getElementById('inputXML' + index);
    
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
                      footer: 'Nuestros Datos:  RFC: '+ rfcParedes +' | Regimen Fiscal: '+ regimenFiscalParedes +' '    
                    })    
                     resetInput(index,lblID);
  }else if(receptorRfc=='' || receptorRfc==null){
          //Mensaje Informativo
            Swal.fire({
                      icon: 'warning',
                      title: 'Datos incorrectos',
                      text: 'valida el XML ya que el RFC no corresponde al de la empresa o no esta incluido en el archivo.',
                      footer: 'Nuestros Datos: RFC: '+ rfcParedes +' | Regimen Fiscal: '+ regimenFiscalParedes +' '    
                    })     
                    resetInput(index,lblID);
  }else{
            //Mensaje Informativo
            Swal.fire({
                      icon: 'warning',
                      title: 'Datos incorrectos',
                      text: 'valida el XML ya que no corresponde el RFC y Regimen fiscal con el de la empresa o no estan incluidos en el archivo. ',
                      footer: 'Nuestros Datos: RFC: '+ rfcParedes +' | Regimen Fiscal: '+ regimenFiscalParedes +' '    
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


function changename(v,p){
    
	v = v.split('\\');
 	var nom = v[v.length-1];
	var pdfs = document.getElementsByName('pdf[]');
	var lbls = document.getElementById('lbl['+p+']');
	lbls.innerHTML = nom;
}

function validando(p){		
	var suma = 0;
	//var f = document.frm_index;
	var pdfs = document.getElementsByName('pdf[]');
	var xmls = document.getElementsByName('xml[]');
	var posicion=document.getElementById('valores[]');
	var out = '';
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
 		if(pdf_actual != '' & xml_actual != '' && pos[i]==1)
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
    	else if (pdf_actual != '' && xml_actual != '' && pos[i]!=1) {
    		s=1;
    		results[i]+='Selecciona porfavor el manifiesto correspondiente a la factura '+pdf_actual;
    		document.getElementById('loading').style.display = 'none';
    		flag=true;
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
   		f=false;
   	}
 }</script>

</head>
<body>			       
	<div class="wrap">
		<div class="header">
			<div id="prueb">
				<span id="date"><?php echo date_format($date, 'd-M-Y H:i:s');?></span>
				<a id="cerrar" href="inicio.php">Regresar</a>
				<a id="cerrar" href="logout.php">Cerrar sesi&oacute;n</a>
			</div>
		<a href="https://www.aparedes.com.mx" target="_blank"><img id="logo" src="img/logo2.png"></a>	
		</div>	    					     
	</div>
	  <div class="main">  
	    <div class="wrap">  		 
	       <div class="column_left">	       	          
	    		 <div class="menu_box">
	    		 	 <h3>Recepci&oacute;n y Validaci&oacute;n de XML</h3>
	    		 	   <div class="menu_box_list">
	    		 	   	<!--onsubmit="javascript:return validando();"-->
							<form name="frm_index" action="upload.php" enctype="multipart/form-data" method="post" onsubmit="javascript:return validando();">
								<table id="lineas" style="width: 100%;text-align: center;">
									<tr>
										<td><span>Selecciona tus PDF</span><div class="clear"></div></td>
										<td><span>Selecciona tus XML</span><div class="clear"></div></td>
										<td><span>Selecciona el manifiesto correspondiente</span><div class="clear"></div></td> 								    
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="javascript:return changename(this.value,0);">
												<label id="lbl[0]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="inputXML0" name="xml[]" accept=".xml" onchange="changename(this.value,1);validaXML(0,1);">
												<label id="lbl[1]" for="file">Selecciona tu XML</label>
											</p>
										</td>
										<td>
											<select id="valores0" data-placeholder="Escoge manifiesto(s)" name="mfto[0][]" onclick='datosP()' onchange="recargar()"  multiple="multiple" class="valsel e1">
												<?php echo consulta(); ?>
											</select>
										    <div class="clear"></div>
									    </td> 								    
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="javascript:return changename(this.value,2);">
												<label id="lbl[2]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file"> 
												<input type="file" id="inputXML1" name="xml[]" accept=".xml" onchange="changename(this.value,3);validaXML(1,3);">
												<label id="lbl[3]" for="file">Selecciona tu XML</label>
											</p>
											
										</td> 
										<td>
											<select id="valores1" data-placeholder="Escoge manifiesto(s)" name="mfto[1][]" onchange="recargar()" multiple class="e1">
												<?php echo consulta($valor); ?>
											</select>
										    <div class="clear"></div>
									    </td> 								    
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="javascript:return changename(this.value,4);">
												<label id="lbl[4]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="inputXML2" name="xml[]" accept=".xml" onchange="changename(this.value,5);validaXML(2,5);">
												<label id="lbl[5]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores2" data-placeholder="Escoge manifiesto(s)" name="mfto[2][]" onchange="recargar()" multiple class="e1">
												<?php echo consulta($valor); ?>
											</select>
										    <div class="clear"></div>
									    </td> 
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf"onchange="changename(this.value,6);">
												<label id="lbl[6]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="inputXML3" name="xml[]" accept=".xml" onchange="changename(this.value,7);validaXML(3,7);">
												<label id="lbl[7]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores3" data-placeholder="Escoge manifiesto(s)" name="mfto[3][]" onchange="recargar()" multiple class="e1">
												<?php echo consulta($valor); ?>
											</select>
										    <div class="clear"></div>
									    </td> 
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="javascript:return changename(this.value,8);">
												<label id="lbl[8]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="inputXML4" name="xml[]" accept=".xml" onchange="changename(this.value,9);validaXML(4,9);">
												<label id="lbl[9]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores4" data-placeholder="Escoge manifiesto(s)" name="mfto[4][]" onchange="recargar()" multiple class="e1">
												<?php echo consulta($valor); ?>
											</select>
										    <div class="clear"></div>
									    </td> 
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="javascript:return changename(this.value,10);">
												<label id="lbl[10]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="inputXML5" name="xml[]" accept=".xml" onchange="changename(this.value,11);validaXML(5,11);">
												<label id="lbl[11]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores5" data-placeholder="Escoge manifiesto(s)" name="mfto[5][]" onchange="recargar()" multiple class="e1">
												<?php echo consulta($valor); ?>
											</select>
										    <div class="clear"></div>
									    </td> 
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="javascript:return changename(this.value,12);">
												<label id="lbl[12]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="inputXML6" name="xml[]" accept=".xml" onchange="changename(this.value,13);validaXML(6,13);">
												<label id="lbl[13]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores6" data-placeholder="Escoge manifiesto(s)" name="mfto[6][]" onchange="recargar()" multiple class="e1">
												<?php echo consulta($valor); ?>
											</select>
										    <div class="clear"></div>
									    </td> 
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="javascript:return changename(this.value,14);">
												<label id="lbl[14]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="inputXML7" name="xml[]" accept=".xml" onchange="changename(this.value,15);validaXML(7,15);">
												<label id="lbl[15]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores7" data-placeholder="Escoge manifiesto(s)" name="mfto[7][]" onchange="recargar()" multiple class="e1">
												<?php echo consulta($valor); ?>
											</select>
										    <div class="clear"></div>
									    </td> 
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="javascript:return changename(this.value,16);">
												<label id="lbl[16]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="inputXML8" name="xml[]" accept=".xml" onchange="changename(this.value,17);validaXML(8,17);">
												<label id="lbl[17]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores8" data-placeholder="Escoge manifiesto(s)" name="mfto[8][]" onchange="recargar()" multiple class="e1">
												<?php echo consulta($valor); ?>
											</select>
										    <div class="clear"></div>
									    </td> 
									</tr>
									<tr>
										<td>
											<p class="file">
												<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="javascript:return changename(this.value,18);">
												<label id="lbl[18]" for="file">Selecciona tu PDF</label>
											</p>
  										</td>
										<td>
											<p class="file">
												<input type="file" id="inputXML9" name="xml[]" accept=".xml" onchange="changename(this.value,19);validaXML(9,19);">
												<label id="lbl[19]" for="file">Selecciona tu XML</label>
											</p>
											
										</td>
										<td>
											<select id="valores9" data-placeholder="Escoge manifiesto(s)" name="mfto[9][]" onchange="recargar()" multiple class="e1">
												<?php echo consulta($valor); ?>
											</select>
										    <div class="clear"></div>
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
 	 </div>
   </div>
  		 <div class="copy-right">
				<p><a href="https://www.aparedes.com.mx">&copy; 2014 Agricola Paredes S.A.P.I. de C.V.</a> </p>
	 	 </div>   
</body>
</html>

