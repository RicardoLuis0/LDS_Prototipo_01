<?php
require_once("inc/access_control.php");
AccessControl::requireType("Student");
$id="projects";
$title_name="Novo Projeto";
include("inc/pages/top.php");
include("inc/pages/nav/nav_generic.php");
include("inc/pages/projects/new_project.php");
include("inc/pages/bottom.php");
?>