<?php
	include("require_logged");
	if($_SESSION["is_admin"]){
		$_SESSION['403_message']="Funcionalidade n�o dispon�vel para administradores";
		header("location:access_denied.php");
		exit();
	}
?>