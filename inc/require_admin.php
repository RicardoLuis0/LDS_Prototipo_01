<?php
	include("require_logged.php");
	if(Session::isLoggedIn()&&Session::getUserData()->getAccountType()!="Admin"){
		Session::do403Error("Nível de Acesso Insuficiente");
	}
?>
