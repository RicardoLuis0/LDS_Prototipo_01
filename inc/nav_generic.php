<?php
require_once("session_setup.php");
switch(get_account_type()){
default:
case "None":
	include("nav_unregistered.php");
	break;
case "Student":
case "Teacher":
	include("nav_logged_in.php");
	break;
case "Admin":
	include("nav_admin.php");
	break;
}
?>