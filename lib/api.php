<?php

header('Content-Type: text/plain');
error_reporting(~0); ini_set('display_errors', 1);

$data = json_decode(file_get_contents('http://177.244.36.158:7373/api/traevalorespagooc?prmOrden=20-210000000184'), FILE_USE_INCLUDE_PATH);

//$data=require_once('http://localhost/apiprueba/metodos.php?prmOrden=20-210000000184');
var_dump($data);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Prueba</title>
    <script src="js/jquery-1.11.1.min.js"></script>
</head>
<body>
<div id="demo">
    <button type="button" onclick="traeDatos()">Probar</button>
    <select id="" name="" class="ocpendiente">
        <option></option>
    </select>
    <select id="" name="" class="ocpendiente">
        <option></option>
    </select>
</div>

<script>
function traeDatos(prmOrden,prmValor){
    var param = new Object();  
    //var prmOrden = "20-210000000184";     
    $.ajax({        
        url: 'http://192.168.1.22:8000/api/traevalorespagooc',
        //url: 'http://177.244.36.158:7373/api/traeocproveedornotas',
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        json: true, 
        cache:false,
        data: "prmOrden="+prmOrden,
        success: function (data, textStatus, xhr) {  
            return data[prmValor];
        },  
        error: function(jq,status,message) {
            console.log('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
        }
    });
}
function loadData() {
    var xhttp = new XMLHttpRequest();
    const json = {
        "prmTipo": "1",
        "prmOrden": "17-180000010300",
        "prmSucursal": "001"
    };
    xhttp.onreadystatechange = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            // parse JSON
            const response = xhttp.responseText;
            console.log(response);
        }  else{
            console.log("error", xhttp.responseText);    
        }    
    };
    // Set the request URL and request method
    xhttp.open("GET","http://192.168.1.22:8000/api/actualizaocportal",true);
    // Set the `Content-Type` Request header
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    console.log(JSON.stringify(json));
    // Send the requst with Data
    xhttp.send(JSON.stringify(json));
}

function getOcs() {
    var xhttp = new XMLHttpRequest();
    const json = {
        cProveedor: "000015",
        cSucursal: "001"
    };
    xhttp.onreadystatechange = function() {
         if (xhttp.status >= 200 && xhttp.status < 300) {
            // parse JSON
            const response = xhttp.responseText;
            console.log(response);
        }  else{
            console.log("Error", xhttp.statusText);    
        }
        
    };
    // Set the request URL and request method
    xhttp.open("GET", "http://192.168.1.22:8000/api/traeocproveedor");
    // Set the `Content-Type` Request header
    xhttp.setRequestHeader("Content-Type", "application/json");
    console.log(JSON.stringify(json));
    // Send the requst with Data
    xhttp.send(JSON.stringify(json));
}
</script>
</body>
</html>