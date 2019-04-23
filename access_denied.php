<?php
require_once("inc/session_setup.php");
$id=-1;
$title_name="Acesso Negado";
function get_message():string{
	if(isset($_SESSION["403_message"])){
		if(isset($_SESSION["403_message_absolute"])&&$_SESSION["403_message_absolute"]){
			$message="<p>".$_SESSION["403_message"].".</p>";
			unset($_SESSION["403_message_absolute"]);
		}else{
			$message='<p>Acesso não Autorizado,<br>'.$_SESSION["403_message"].'.</p>';
		}
		unset($_SESSION["403_message"]);
	}else{
		$message='<p>Acesso não Autorizado</p>';
	}
	return $message;	
}
$body_class="error";
header('HTTP/1.1 403 Forbidden');
include("inc/top.php");
include("inc/nav_generic.php");
echo '<h1 class=error><p class=error_type>403 Forbidden</p>'.get_message().'</h1>';
include("inc/bottom.php");
?>
