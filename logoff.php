<?php
require_once("inc/session_setup.php");
include("inc/require_logged.php");
Session::doUserLogoff();
header("Location:login.php");
?>