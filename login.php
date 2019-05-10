<?php
require_once("inc/access_control.php");
AccessControl::requireLoggedOff(true);

if(isset($_POST["proccess"])&&$_POST["proccess"]){
	include("inc/pages/login/login_proccess.php");
}else{
	include("inc/pages/login/login_form.php");
}

?>
