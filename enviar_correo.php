<?php
$para      = 'jegandarillaa@gmail.com';
$titulo    = 'El título';
$mensaje   = 'Hola';
$cabeceras = 'From: jesusga@aparedes.com.mx' . "\r\n" .
    'Reply-To: jesusga@aparedes.com.mx' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($para, $titulo, $mensaje, $cabeceras);
?>