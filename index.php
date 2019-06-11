<?php
use Session\Session;

require_once('inc/autoload.php');

Session::initSession();

$id="index";
$title_name="Index";

include("inc/pages/top.php");
include("inc/pages/nav/nav_generic.php");
echo "<div class=maindiv>";
if(Session::isLoggedIn()){
	include("inc/pages/index/index_logged_in.php");
}else{
	include("inc/pages/index/index_logged_off.php");
}
echo "</div>";
include("inc/pages/bottom.php");
?>
