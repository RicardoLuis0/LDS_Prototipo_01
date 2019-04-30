<?php
$id="index";
$title_name="Index";
require_once("inc/session_setup.php");
include("inc/top.php");
include("inc/nav_generic.php");
echo "<div class=maindiv>";
if(Session::isLoggedIn()){
	echo "<p>Bem Vindo, ".Session::getUserData()->getName()."</p>";
}else{
	echo "<p>Bem Vindo ao Sistema de TCC do IF</p>";
}
echo "</div>";
include("inc/bottom.php");
?>
