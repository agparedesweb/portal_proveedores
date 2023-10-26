<?php
date_default_timezone_set('America/Chihuahua');
$date = date_create($row[0]);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Fechas en PHP</title>
    </head>
    <body>
        <?php
        // Establecer la zona horaria predeterminada a usar. Disponible desde PHP 5.1
        //Imprimimos la fecha actual dandole un formato
        echo date_format($date, 'Y-m-d H:i A');
        ?>
    </body>
</html>