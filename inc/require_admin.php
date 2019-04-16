<?php
	include("require_logged.php");
	if(!$_SESSION["is_admin"]){
		$_SESSION['403_message']="Nível de Acesso Insuficiente";
		header("location:access_denied.php");
		exit();
	}
?>
