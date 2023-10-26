<?php
@session_start();

if($_SESSION["autentica"] != "OK"){
	header("Location: log.php");
	exit();
}


?>
