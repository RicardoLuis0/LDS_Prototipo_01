<?php
	include("require_logged");
	if(!$_SESSION["is_admin"]){
		$_SESSION['403_message']="N�vel de Acesso Insuficiente";
		header("location:access_denied.php");
		exit();
	}
?>