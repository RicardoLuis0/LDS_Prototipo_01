<?php
	if(!Session::isLoggedIn()){
		Session::do403Error("Você precisa estar logado para acessar esta página");
	}
?>