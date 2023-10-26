function ocs(p) {
    var x = "<?php echo $rqrd?>";
    if (x == "true") {
        document.getElementById('valores' + p).setAttribute("required", "true");
    }
}

function changename(v, p) {
    v = v.split('\\');
    var nom = v[v.length - 1];
    var pdfs = document.getElementsByName('pdf[]');
    var lbls = document.getElementById('lbl[' + p + ']');
    lbls.innerHTML = nom;
}

function ocobliga(p) {
    var oc = "<?php echo $_SESSION['oc_r'];?>";
    if (oc == 'S') {
        document.getElementById('valores' + p).setAttribute("required", "true");
        document.getElementById('loading').style.display = 'none';
    }
}

function loadOcs(prmProveedor, prmSucursal) {
    //alert(prmProveedor+" "+prmSucursal);
    $.ajax({
        url: 'https://api.aparedes.com.mx:9000/api/traeocproveedor',
        //url: 'http://192.168.132.123:8000/api/traeocproveedor',
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        json: true,
        cache: false,
        //processData: false,
        //data: JSON.stringify(param),
        data: "cProveedor=" + prmProveedor + "&cSucursal=" + prmSucursal + "",
        success: function(data, textStatus, xhr) {
            for (var i = data.length - 1; i >= 0; i--) {
                $('.ocpendiente').append(`<option value="${data[i]}">${data[i]}</option>`);
            }
        },
        error: function(jq, status, message) {
            console.log('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
        }
    });
}

function traeDatosOc(prmOrden, prmValor) {
    var index = prmValor;
    var res = "";
    //var prmOrden = "20-210000000184";     
    return $.ajax({
        url: 'https://api.aparedes.com.mx:9000/api/traevalorespagooc',
        //url: 'http://192.168.132.123:8000/api/traevalorespagooc',
        type: "GET",
        contentType: "application/json; charset=utf-8",
        async: false,
        dataType: 'json',
        data: "prmOrden=" + prmOrden,
        success: function(data, textStatus, xhr) {
            return data[index];
        },
        error: function(jq, status, message) {
            console.log('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
        }
    });

}

  

/*function fgTraeValoresPago(prmValor, prmSelect) {
    var vcOrden = $('#valores' + prmSelect).val();
    var ocDatos = traeDatosOc(vcOrden, 0);
    var nImporte = traeImporteOc(vcOrden,prmValor);
    //console.log(ocDatos["responseJSON"][0]);
    if ($('#' + prmValor).val().length == 0) {
        $.MessageBox('Ingrese el xml correspondiente');
        $('#valores' + prmSelect).val("");
        return false;
    } else {
        var file = $('#' + prmValor).prop('files')[0];
        if (file) {
            var reader = new FileReader();
            reader.readAsText(file, "UTF-8");
            reader.onload = function(evt) {
                var json = xmlToJson($.parseXML(evt.target.result));
                var xmlMetPago = json['cfdi:Comprobante']["@attributes"]["MetodoPago"];
                var xmlForPago = json['cfdi:Comprobante']["@attributes"]["FormaPago"];
                var xmlUsoCFDI = json['cfdi:Comprobante']['cfdi:Receptor']["@attributes"]["UsoCFDI"];
                var xmlMoneda = json['cfdi:Comprobante']["@attributes"]["Moneda"];
                var xmlTotal = json['cfdi:Comprobante']["@attributes"]["Total"];
                if (ocDatos["responseJSON"][0] != xmlMetPago) {
                    $.MessageBox("El metodo de pago de tu CFDI no coincide con el de la orden de compra seleccionada");
                    $('#valores' + prmSelect).val("");
                    return false;
                }
                if (ocDatos["responseJSON"][1] != xmlForPago) {
                    $.MessageBox("La forma de pago de tu CFDI no coincide con el de la orden de compra seleccionada");
                    $('#valores' + prmSelect).val("");
                    return false;
                }
                if (ocDatos["responseJSON"][2] != xmlUsoCFDI) {
                    $.MessageBox("El Uso del CFDI no coincide con el de la orden de compra seleccionada");
                    $('#valores' + prmSelect).val("");
                    return false;
                }
                if (ocDatos["responseJSON"][3] != xmlMoneda) {
                    $.MessageBox("El valor moneda no coincide con el de la orden de compra seleccionada");
                    $('#valores' + prmSelect).val("");
                    return false;
                }
                comparaImportes(nImporte,xmlTotal);
            }
            reader.onerror = function(evt) {
                console.log("error reading file");
            }
        }
    }

}*/

async function fgTraeValoresPago(prmValor, prmSelect) {
    var vcOrden = $('#valores' + prmSelect).val();
    try {
        var ocDatos = await traeDatosOc(vcOrden, 0);
        var nImporte = await traeImporteOc(vcOrden, prmValor);
        
        if ($('#' + prmValor).val().length == 0) {
            $.MessageBox('Ingrese el xml correspondiente');
            $('#valores' + prmSelect).val("");
            return false;
        } else {
            var file = $('#' + prmValor).prop('files')[0];
            if (file) {
                var reader = new FileReader();
                reader.readAsText(file, "UTF-8");
                reader.onload = function(evt) {
                    var json = xmlToJson($.parseXML(evt.target.result));
                    var xmlMetPago = json['cfdi:Comprobante']["@attributes"]["MetodoPago"];
                    var xmlForPago = json['cfdi:Comprobante']["@attributes"]["FormaPago"];
                    var xmlUsoCFDI = json['cfdi:Comprobante']['cfdi:Receptor']["@attributes"]["UsoCFDI"];
                    var xmlMoneda = json['cfdi:Comprobante']["@attributes"]["Moneda"];
                    var xmlTotal = json['cfdi:Comprobante']["@attributes"]["Total"];

                    if (ocDatos[0] != xmlMetPago) {
                        $.MessageBox("El método de pago de tu CFDI no coincide con el de la orden de compra seleccionada");
                        $('#valores' + prmSelect).val("");
                        return false;
                    }
                    if (ocDatos[1] != xmlForPago) {
                        $.MessageBox("La forma de pago de tu CFDI no coincide con el de la orden de compra seleccionada");
                        $('#valores' + prmSelect).val("");
                        return false;
                    }
                    if (ocDatos[2] != xmlUsoCFDI) {
                        $.MessageBox("El Uso del CFDI no coincide con el de la orden de compra seleccionada");
                        $('#valores' + prmSelect).val("");
                        return false;
                    }
                    if (ocDatos[3] != xmlMoneda) {
                        $.MessageBox("El valor moneda no coincide con el de la orden de compra seleccionada");
                        $('#valores' + prmSelect).val("");
                        return false;Ñ
                    }      
                    comparaImportes(nImporte, xmlTotal);      
                }
                reader.onerror = function(evt) {
                console.log("error reading file");
                }
            }
            
        }
    } catch (error) {
        console.log('An error has occurred:', error);
        return false;
    }
}
  


function fgVerificaValoresPago(prmValor) {
    if ($('#' + prmValor).val().length == 0) {
        Swal.fire({
            title: "Información",
            html: "Ingresa el XML",
            icon: "info",
            button: "Aceptar",
        });
        return false;
    } else {
        var file = $('#' + prmValor).prop('files')[0];
        var lbls = document.getElementById('lbl[' + prmValor + ']');
        if (file) {
            var reader = new FileReader();
            reader.readAsText(file, "UTF-8");
            reader.onload = function(evt) {
                var json = xmlToJson($.parseXML(evt.target.result));
                var xmlMetPago = json['cfdi:Comprobante']["@attributes"]["MetodoPago"];
                var xmlForPago = json['cfdi:Comprobante']["@attributes"]["FormaPago"];
                var xmlUsoCFDI = json['cfdi:Comprobante']['cfdi:Receptor']["@attributes"]["UsoCFDI"];
                if (xmlMetPago == "PPD" && xmlForPago != "99") {
                    document.getElementById(prmValor).value = "";
                    lbls.innerHTML = "Selecciona tu XML";
                    Swal.fire({
                        title: "Información",
                        html: "El metodo de pago del CFDI es PPD y la forma de pago es distinta de por definir(99).",
                        icon: "info",
                        button: "Aceptar",
                    });

                    return false;
                }
                if (xmlMetPago == "PUE" && xmlForPago == "99") {
                    Swal.fire({
                        title: "Información",
                        html: "El metodo de pago del CFDI es PUE y la forma de pago es por definir(99).",
                        icon: "info",
                        button: "Aceptar",
                    });
                    document.getElementById(prmValor).value = "";
                    lbls.innerHTML = "Selecciona tu XML";
                    return false;
                }
                reader.onerror = function(evt) {
                    console.log("error reading file");
                }
            }
        }
    }
}
var oc = "";

function fgActivaOrdenesForm() {
    for (var i = 0; i <= 9; i++) {
        $("#valores" + i + " option").removeAttr('disabled');
    }
}

function fgDesactivaOc(prmOc, prmValor) {
    var datos = [];
    var valorOc = "";
    //seleccionamos las oc que esten seleccionadas 
    for (var i = 0; i <= prmValor; i++) {
        oc = String($("#valores" + i + " option:selected").val());
        datos.push(oc);

    }
    for (var i = 0; i <= 9; i++) {
        $("#valores" + i + " option").removeAttr('disabled');
        for (var j = 0; j < datos.length; j++) {
            if (prmValor != i) {
                valorOc = String($("#valores" + i + " option:selected").val());
                if (valorOc != datos[j]) {
                    $("#valores" + i + " option[value=" + datos[j] + "]").attr('disabled', 'disabled');
                }

            }

        }
    }
}

function fgVerificaImporteOc(prmOc) {
    return $.ajax({
        url: 'consultaimporte.php',
        type: "GET",
        contentType: "application/json; charset=utf-8",
        data: "prmOrden=" + prmOc,
        success: function(data, textStatus, xhr) {            
            return data;
        },
        error: function(jq, status, message) {
            return 0;
            console.log('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
        }
    });
}


function xmlToJson(xml) {

    var obj = {};

    if (xml.nodeType == 1) { // element
        // do attributes
        if (xml.attributes.length > 0) {
            obj["@attributes"] = {};
            for (var j = 0; j < xml.attributes.length; j++) {
                var attribute = xml.attributes.item(j);
                obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
            }
        }
    } else if (xml.nodeType == 4) { // cdata section
        obj = xml.nodeValue
    }

    // do children

    if (xml.hasChildNodes()) {
        for (var i = 0; i < xml.childNodes.length; i++) {
            var item = xml.childNodes.item(i);
            var nodeName = item.nodeName;
            if (typeof(obj[nodeName]) == "undefined") {
                obj[nodeName] = xmlToJson(item);
            } else {
                if (typeof(obj[nodeName].length) == "undefined") {
                    var old = obj[nodeName];
                    obj[nodeName] = [];
                    obj[nodeName].push(old);
                }
                if (typeof(obj[nodeName]) === 'object') {
                    obj[nodeName].push(xmlToJson(item));
                }
            }
        }
    }
    return obj;
};

function validando() {
    var suma = 0;
    var f = document.frm_index;
    var pdfs = document.getElementsByName('pdf[]');
    var xmls = document.getElementsByName('xml[]');
    var flag = false;
    var ext_xml = "";
    var ext_pdf = "";
    var s = 0;
    var pdf_actual = "";
    var xml_actual = "";
    var no_hay = false;
    var m_pdfs = [];
    var m_xmls = [];
    var results = [];
    for (var i = 0, j = pdfs.length; i < j; i++) {
        results[i] = "";
        pdf_actual = pdfs[i].value;
        xml_actual = xmls[i].value;
        ext_pdf = (pdf_actual.substring(pdf_actual.lastIndexOf("."))).toLowerCase();
        ext_xml = (xml_actual.substring(xml_actual.lastIndexOf("."))).toLowerCase();
        if (pdf_actual != '' & xml_actual != '') {
            if (ext_pdf == ".pdf" && ext_xml == ".xml") {
                s = 1;
                flag = false;
            } else {
                $.MessageBox("Hay un problema con tus archivos favor de verificar");
                document.getElementById('loading').style.display = 'none';
                return false;
            }
        } else if (pdf_actual != '' & xml_actual == '') {
            s = 1;
            //si pdf es diferente de nulo y xml es igual a nulo    		
            if (ext_pdf == ".pdf") {
                results[i] += 'Falta el XML del archivo ' + pdf_actual;
                document.getElementById('loading').style.display = 'none';
                flag = true;
            } else {
                results[i] += 'El documento ' + pdf_actual + ' no es un archivo PDF favor de verificar';
                document.getElementById('loading').style.display = 'none';
                flag = true;
            }
        } else if (pdf_actual == '' && xml_actual != '') {
            s = 1;
            //si pdf es igual a nulo y si xml es diferente de nulo    		
            if (ext_xml == ".xml") {
                results[i] += 'Falta el PDF del archivo ' + xml_actual;
                document.getElementById('loading').style.display = 'none';
                flag = true;
            } else {
                results[i] += 'El documento ' + xml_actual + ' no es un archivo XML favor de verificar';
                document.getElementById('loading').style.display = 'none';
                flag = true;
            }
        } else {
            if (s > 0) {
                continue;
            } else {
                results[i] += 'No has capturado ningun archivo';
                document.getElementById('loading').style.display = 'none';
                flag = true;
            }
        }
    }
    if (flag == true) {
        alert(results.join("\n"));
        return false;
    } else {
        return true;
    }
}

function copiarUltimaFila() {
    var tbody = document.getElementById("tbmodalnotas");
    var ultimaFila = tbody.lastElementChild;
  
    if (ultimaFila !== null) {
      var nuevaFila = ultimaFila.cloneNode(true);
      tbody.appendChild(nuevaFila);
    } else {
      var renglonTabla = '<tr>' +
      '<td>' +
      '<p class="file">' +
      '<input type="file" id="file" name="pdf[]" accept=".pdf" onchange="changename(this.value,0);ocobliga(0);">' +
      '<label id="" style="width: 12em;padding: 0.6em;" for="file">PDF</label>' +
      '</p>' +
      '</td>' +
      '<td>' +
      '<p class="file">' +
      '<input type="file" class="xmlnotas" name="xml[]" accept=".xml">' +
      '<label id="" style="width: 12em;padding: 0.6em;" for="file">XML</label>' +
      '</p>' +
      '</td>' +
      '<td>' +
      '<p id="eliminanota" class="file"><label class="Delete" style="width: 1em;padding: 0.6em;background: red;color: white;font-weight: bold;cursor: pointer;">X</label></p>' +
      '<div id="uploadnota" style="width: 30px; height: 30px; ">' +
      '<div class="loading loading--full-height"></div>' +
      '</div>' +
      '</td>' +
      '</tr>';      
      tbody.innerHTML = renglonTabla;
    }
}
  

$(document).on("click", '.Delete',function(){
    $(this).closest('tr')
        .children('td')
        .animate({ padding: 0 })
        .wrapInner('<div />')
        .children()
        .slideUp(function() { $(this).closest('tr').remove(); });
    return false;
}); 

$(document).on("change", ".xmlnotas", function() {
    var fileInput = $(this);
    var file = $(this).prop('files')[0];
    if (file) {
        var reader = new FileReader();
        reader.readAsText(file, "UTF-8");
        reader.onload = function(evt) {
            var json = xmlToJson($.parseXML(evt.target.result));
            var xmlTipo = json['cfdi:Comprobante']["@attributes"]["TipoDeComprobante"];
            if (xmlTipo != "E") {
                Swal.fire({
                    title: "Información",
                    html: "El documento CFDI no pertenece a una nota de credito.",
                    icon: "info",
                    button: "Aceptar",
                });
                fileInput.val(null);
                return false;
            }
            reader.onerror = function(evt) {
                console.log("error reading file");
            }

        }
    }
    
});

$(document).ready(function() {
    // Capturar el valor seleccionado en el primer formulario y asignarlo al campo oculto en el segundo formulario
    $(".ocpendiente").change(function() {
      var ocSeleccionada = $(this).val();
      $("#ocSeleccionada").val(ocSeleccionada);
    });
});
  

$(document).ready(function() {
    $("#formNotas").submit(function(event) {
        event.preventDefault(); // Evita que el formulario se envíe de forma predeterminada
        var eliminaNota = document.getElementById("eliminanota");
        var uploadNota = document.getElementById("uploadnota");
        eliminaNota.style.display = "none";
        uploadNota.style.display = "inline";
        var form = $(this);
        var url = "upload-notas.php";
        var formData = new FormData(form[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                
                var response = JSON.parse(data);                
                var title = "Información";
                var icon = "info";
                var resetForm = true;
                var closeModal = true;
                if (response.status !== "success") {
                    title = "Error";
                    icon = "error";
                    resetForm = false;
                    closeModal = false;
                }
                Swal.fire({
                    title: title,
                    html: response.message,
                    icon: icon,
                    button: "Aceptar",
                }).then(() => { 
                    if (resetForm) {
                        $('#formNotas')[0].reset();
                    }    
                    if (closeModal) {
                        //$("#ex1").modal('hide');
                        $.modal.close();
                    }
                    console.log("Alerta cerrada");
                });

                /*if (resetForm) {
                    $('#formNotas')[0].reset();
                }

                if (closeModal) {
                    $("#ex1").modal('hide');
                }*/

                eliminaNota.style.display = "inline";
                uploadNota.style.display = "none";
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    $('.ocpendiente').on('change', async function() {
        var selectedValue = $(this).val();
        const flagEntrada = await traeFlagEntradaOC();
        if(flagEntrada == true){
            const verificaEntrada = await verificaEntradaOC(selectedValue);
            if(verificaEntrada == "0"){
                Swal.fire({
                    title: "Información",
                    html: "La orden de compra seleccionada no ha sido recibida en nuestros almacenes.",
                    icon: "info",
                    button: "Aceptar",
                }).then(() => { 
                    $(this).val("");
                    $.modal.close();                    
                });
            }
        }        
    });      
});


async function traeImporteOc(prmOrden, prmValor) {
    try {
        //const response = await fetch('http://192.168.132.123:8000/api/obtenimporteordendecompra?prmOrden=' + prmOrden);
        const response = await fetch('https://api.aparedes.com.mx:9000/api/obtenimporteordendecompra?prmOrden=' + prmOrden);
        const data = await response.json();
        var nImporte = data["NIMPORTE"];
        return nImporte;
    } catch (error) {
        console.log('An error has occurred:', error);
        return 0;
    }
}
  

async function traeFactorOc(prmSucursal) {
    try {
        //const response = await fetch('http://192.168.132.123:8000/api/obtenfactorordendecompra?prmSucursal=' + prmSucursal);
        const response = await fetch('https://api.aparedes.com.mx:9000/api/obtenfactorordendecompra?prmSucursal=' + prmSucursal);
        const data = await response.json();
        
        return data["NFACTORORDENDECOMPRA"];
        
    } catch (error) {
        console.log('An error has occurred:', error);
        return 0;
    }
}

async function traeFlagEntradaOC() {
    try {
        //const response = await fetch('http://192.168.132.123:8000/api/obtenflagentradaalmacen');
        const response = await fetch('https://api.aparedes.com.mx:9000/api/obtenflagentradaalmacen');
        const data = await response.json();
        return data["bFlagEntradaOC"];
    } catch (error) {
        console.log('An error has occurred:', error);
        return false;
    }
}

async function verificaEntradaOC(prmOrden) {
    try {
        //const response = await fetch('http://192.168.132.123:8000/api/verificaentradaalmacen?prmOrden=' + prmOrden);
        const response = await fetch('https://api.aparedes.com.mx:9000/api/verificaentradaalmacen?prmOrden=' + prmOrden);
        const data = await response.json();
        console.log(data["RESULTADO"]);
        return data["RESULTADO"];
    } catch (error) {
        console.log('An error has occurred:', error);
        return false;
    }
}
  

async function comparaImportes(prmTotalOC, prmTotalXML) {
    try {
        const nFactor = await traeFactorOc("001");
        //var diferencia = prmTotalOC - prmTotalXML < 0 ? (prmTotalOC - prmTotalXML) * -1 : prmTotalOC - prmTotalXML;
        const difference = Math.abs(prmTotalOC - prmTotalXML);
        if (difference <= nFactor ) {
            console.log("Los valores son permitidos.");
        } else {
            $("#ex1").modal();
        }       
    } catch (error) {
        console.log('An error has occurred:', error);
    }
}
  