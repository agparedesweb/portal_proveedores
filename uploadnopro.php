<?php
//solo se puede acceder si es una peticion post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //llamamos a la clase multiupload
    include("multiupload.php");
    //array de campos file del formulario
    $files = $_FILES['xml']['name'];
    $pdfs = $_FILES['pdf']['name'];
    $manif = $_POST['mfto'];
    $newfiles=array_filter($files);
    $newpdfs=array_filter($pdfs);
    $newmanif=array_filter($manif);
    /*if(count($manif)>0){
        foreach ($manif as $selectedOption){        
            foreach ($selectedOption as $opt){
                $upd = "UPDATE eye_maniffacturados SET CRELACIONADO='S' WHERE CFOLIO_REMIS='$opt'";
                mysql_query($upd); 
            }
        }    
    }*/
    
    //creamos una nueva instancia de la clase multiupload
    $upload = new Multiupload();
    //llamamos a la funcion upFiles y le pasamos el array de campos file del formulario
    $isUpload = $upload->upFiles($pdfs,$files,$manif);        
    
    
}else{
    throw new Exception("Error Processing Request", 1);
}
	
?>	