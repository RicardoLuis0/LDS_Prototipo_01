<?php
include("inc/session_setup.php");
$id=-1;
$title_name="Acesso Negado";
if(isset($_SESSION["403_message_absolute"])){
	$message="<p>".$_SESSION["403_message_absolute"].".</p>";
	unset($_SESSION["403_message_absolute"]);
}else if(isset($_SESSION["403_message"])){
	$message='<p>Acesso não Autorizado,<br>'.$_SESSION["403_message"].'.</p>';
	unset($_SESSION["403_message"]);
}else{
	$message='<p>Acesso não Autorizado</p>';
}
$body_class="error";
header('HTTP/1.1 403 Forbidden');
include("inc/top.php");
include("inc/nav_unregistered.php");
echo '<h1 class=error><p class=error_type>403 Forbidden</p>'.$message.'</h1>';
include("inc/bottom.php");
?>
