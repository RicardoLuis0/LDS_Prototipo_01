<?php
include("inc/session_setup.php");
include("inc/require_logged.php");
$_SESSION["logged"]=false;
$_SESSION["is_admin"]=false;
$_SESSION["name"]="";
header("Location:login.php");
?>