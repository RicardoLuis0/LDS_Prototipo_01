<?php
use Session\Session,
    Pages\AccessControl;

require_once('inc/autoload.php');

Session::initSession();

AccessControl::requireType("Admin");
if(isset($_POST["proccess"])&&$_POST["proccess"]){
	include("inc/pages/register/register_proccess.php");
}else{
	include("inc/pages/register/register_form.php");
}
?>
