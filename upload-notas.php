<?php
//solo se puede acceder si es una peticion post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    /*$conexion = mysql_connect("localhost", "root", "12345");
    $date = date_create(); 
    mysql_select_db("system_validator", $conexion);*/
    //llamamos a la clase multiupload
    require_once("multiupload-notas.php");
    //array de campos file del formulario
    $files = $_FILES['xml']['name'];
    $pdfs = $_FILES['pdf']['name'];
    //array de campos oc del form
    $purcho =  explode(",", $_POST['ocSeleccionada']);
    $newfiles=array_filter($files);
    $newpdfs=array_filter($pdfs);
    
    
    //creamos una nueva instancia de la clase multiupload
    $upload = new Multiupload();
    //llamamos a la funcion upFiles y le pasamos el array de campos file del formulario
    $isUpload = $upload->upFilesNC($newpdfs,$newfiles,$purcho);
    
    
}else{
    throw new Exception("Error Processing Request", 1);
}
	
?>	
