<?php
	include("require_logged");
	if($_SESSION["is_admin"]){
		$_SESSION['403_message']="Funcionalidade não disponível para administradores";
		header("location:access_denied.php");
		exit();
	}
?>