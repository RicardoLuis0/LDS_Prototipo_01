<?php
require_once("inc/access_control.php");
AccessControl::requireLoggedOff();
require_once("inc/get_database.php");
if(isset($_GET['user'])){
    if(isset($_GET['key'])){
        include("inc/pages/activation/activate_main.php");
    }
}
AccessControl::requireLoggedIn();