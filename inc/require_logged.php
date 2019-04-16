<?php
	if(!$_SESSION["logged"]){
		$_SESSION['403_message']="Você precisa estar logado para acessar esta página";
		header("location:access_denied.php");
		exit();
	}
?>