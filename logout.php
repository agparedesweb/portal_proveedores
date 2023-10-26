<?php

session_start();

// Destruir todas las variables de sesión.
$_SESSION = array();

// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión.
session_destroy();
session_unset();
$_SESSION = [];
	header( "location: log.php" );

	/*session_start();
	$_SESSION = array();
	$parametros_cookies = session_get_cookie_params(); 
	setcookie(session_name(),0,1,$parametros_cookies["path"]);
	session_destroy();
	session_unset();
	header( "location: log.php" ); */

?>