<?php
require_once("inc/session_setup.php");
include("inc/require_logged.php");
session_logoff();
header("Location:login.php");
?>