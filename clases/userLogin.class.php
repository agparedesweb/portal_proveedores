<?php 
include_once("conexion.class.php");

class UserLogin{
 //constructor	
 	var $con;
 	function UserLogin(){
 		$this->con=new DBManager;
 	}

	function obtener_user($user,$pass){
		if($this->con->conectar()==true){
			return mysql_query("SELECT * FROM users WHERE id='".$user."' AND pass='".md5($pass)."'");
		}
	}
	
	function obtener_user_cntrl($user,$pass){
		if($this->con->conectar()==true){
			return mysql_query("SELECT * FROM control WHERE usuario='".$user."' AND pass='".md5($pass)."'");
		}
	}

	
}
?>
