<?php
@session_start();

if($_SESSION["security"] != "OK"){
	header("Location: log.php");
	exit();
}
?>
