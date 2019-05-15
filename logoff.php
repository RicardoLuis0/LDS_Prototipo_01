<?php
use Session\Session,
    Pages\AccessControl;

require_once('inc/autoload.php');

Session::initSession();

AccessControl::requireLoggedIn(true);
Session::doUserLogoff();
header("Location:login.php");
?>