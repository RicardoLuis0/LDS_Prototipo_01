<?php
use Session\Session,
    Pages\AccessControl;

require_once('inc/autoload.php');

Session::initSession();

AccessControl::requireLoggedOff(true);

if(isset($_POST["proccess"])&&$_POST["proccess"]){
	include("inc/pages/login/login_proccess.php");
}else{
	include("inc/pages/login/login_form.php");
}

?>
