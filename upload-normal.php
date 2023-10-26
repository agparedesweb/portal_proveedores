<?php
//solo se puede acceder si es una peticion post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    /*$conexion = mysql_connect("localhost", "root", "12345");
    $date = date_create(); 
    mysql_select_db("system_validator", $conexion);*/
    //llamamos a la clase multiupload
    require_once("multiupload-normal.php");
    //array de campos file del formulario
    $files = $_FILES['xml']['name'];
    $pdfs = $_FILES['pdf']['name'];
    //array de campos oc del form
    $purcho = $_POST['oc'];
    $newfiles=array_filter($files);
    $newpdfs=array_filter($pdfs);
    
    
    //creamos una nueva instancia de la clase multiupload
    $upload = new Multiupload();
    //llamamos a la funcion upFiles y le pasamos el array de campos file del formulario
    $isUpload = $upload->upFiles($newpdfs,$newfiles,$purcho);
    
    
}else{
    throw new Exception("Error Processing Request", 1);
}
	
?>	
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style type="text/css">
        
        @import url(https://fonts.googleapis.com/css?family=Roboto+Condensed);

        * {
          box-sizing: border-box;
          overflow: hidden;
        }

        body {
          padding-top: 10em;
          text-align: center;
        }

        .loader {
          position: relative;
          margin: auto;
          width: 400px;
          color: white;
          font-family: "Roboto Condensed", sans-serif;
          font-size: 250%;
          background: linear-gradient(180deg, #222 0, #444 100%);
          box-shadow: inset 0 5px 20px black;
          text-shadow: 5px 5px 5px rgba(0,0,0,0.3);
        }

        .loader:after {
          content: "";
          display: table;
          clear: both;
        }

        span {
          float: left;
          height: 100px;
          line-height: 120px;
          width: 50px;
        }

        .loader > span {
          border-left: 1px solid #444;
          border-right: 1px solid #222;
        }

        .covers {
          position: absolute;
          height: 100%;
          width: 100%;
        }

        .covers span {
          background: linear-gradient(180deg, white 0, #ddd 100%);
          animation: up 2s infinite;
        }

        @keyframes up {
          0%   { margin-bottom: 0; }
          16%  { margin-bottom: 100%; height: 20px; }
          50% { margin-bottom: 0; }
          100% { margin-bottom: 0; }
        }

        .covers span:nth-child(2) { animation-delay: .142857s; }
        .covers span:nth-child(3) { animation-delay: .285714s; }
        .covers span:nth-child(4) { animation-delay: .428571s; }
        .covers span:nth-child(5) { animation-delay: .571428s; }
        .covers span:nth-child(6) { animation-delay: .714285s; }
        .covers span:nth-child(7) { animation-delay: .857142s; }
        .covers span:nth-child(8) { animation-delay: .957142s; }

    </style>
</head>
<body>
    <div class="loader">
        <span>C</span>
        <span>A</span>
        <span>R</span>
        <span>G</span>
        <span>A</span>
        <span>N</span>
        <span>D</span>
        <span>O</span>

        <div class="covers">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</body>
</html>