<?php
use Session\Session,
    Pages\AccessControl;

require_once('inc/autoload.php');

Session::initSession();

AccessControl::requireLoggedOff();

if(isset($_GET['user'])){
    if(isset($_GET['key'])){
        include("inc/pages/activation/activate_main.php");
    }
}
AccessControl::requireLoggedIn();