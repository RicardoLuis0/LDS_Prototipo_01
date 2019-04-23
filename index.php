<?php
$id="index";
$title_name="Index";
require_once("inc/session_setup.php");
include("inc/top.php");
include("inc/nav_generic.php");
echo "<div class=maindiv>";
if(is_logged()){
	echo "<p>Bem Vindo, ".get_name()."</p>";
}else{
	echo "<p>Bem Vindo ao Sistema de TCC do IF</p>";
}
echo "</div>";
include("inc/bottom.php");
?>
