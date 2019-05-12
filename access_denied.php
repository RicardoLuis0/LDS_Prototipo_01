<?php
require_once("inc/session_setup.php");
$id=-1;
if(isset($_SESSION["401_message"])){
	$title_name="Acesso não Autorizado";
}else{
	$title_name="Acesso Negado";
}
$body_class="error";
include("inc/pages/top.php");
include("inc/pages/nav/nav_generic.php");
include("inc/pages/access_denied.php");
include("inc/pages/bottom.php");
?>
