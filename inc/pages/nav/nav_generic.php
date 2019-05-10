<?php
require_once("session_setup.php");
if(Session::isLoggedIn()){
	switch(Session::getUserData()->getAccountType()){
	default:
	case "None":
		include("nav_unregistered.php");
		break;
	case "Student":
		include("nav_student.php");
		break;
	case "Teacher":
		include("nav_teacher.php");
		break;
	case "Admin":
		include("nav_admin.php");
		break;
	}
}else{
	include("nav_unregistered.php");
}
?>