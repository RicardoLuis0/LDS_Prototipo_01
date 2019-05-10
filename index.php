<?php
$id="index";
$title_name="Index";
require_once("inc/session_setup.php");
include("inc/top.php");
include("inc/pages/nav/nav_generic.php");
echo "<div class=maindiv>";
if(Session::isLoggedIn()){
	include("inc/pages/index/index_logged_in.php");
}else{
	include("inc/pages/index/index_logged_off.php");
}
echo "</div>";
include("inc/bottom.php");
?>
