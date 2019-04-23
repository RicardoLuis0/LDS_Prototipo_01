<?php
	if(!is_logged()){
		do403("Você precisa estar logado para acessar esta página");
	}
?>