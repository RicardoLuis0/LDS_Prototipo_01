<?php
require_once("inc/access_control.php");
AccessControl::requireType("Admin");
$id="manage";
$title="Administrar Usuários";
include("inc/top.php");
include("inc/pages/nav/nav_generic.php");
include("inc/pages/manage/manage_accounts.php");
include("inc/bottom.php");