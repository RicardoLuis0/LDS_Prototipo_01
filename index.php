<?php
$id="index";
$title_name="Index";
include("inc/session_setup.php");
include("inc/top.php");
include("inc/nav_generic.php");
echo "<div class=maindiv>";
if($_SESSION["logged"]){
	echo "<p>Bem Vindo, ".$_SESSION["name"]."</p>";
}else{
	echo "<p>Bem Vindo ao Sistema de TCC do IF</p>";
}
echo "</div>";
include("inc/bottom.php");
?>
