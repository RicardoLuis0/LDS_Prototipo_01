<?php
	include("require_logged.php");
	if(get_account_type()!="Teacher"||get_account_type()!="Student"){
		do403("Funcionalidade não disponível para administradores");
	}
?>
