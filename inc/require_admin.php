<?php
	include("require_logged.php");
	if(get_account_type()!="Admin"){
		do403("Nível de Acesso Insuficiente");
	}
?>
