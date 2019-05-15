<?php
use Session\Session,
    Pages\AccessControl;

require_once('inc/autoload.php');

Session::initSession();

AccessControl::requireType("Admin");
$id="manage";
$title="Administrar Usuários";
include("inc/pages/top.php");
include("inc/pages/nav/nav_generic.php");
include("inc/pages/manage/manage_accounts.php");
include("inc/pages/bottom.php");