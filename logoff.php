<?php
require_once("inc/access_control.php");
AccessControl::requireLoggedIn(true);
Session::doUserLogoff();
header("Location:login.php");
?>