<?php
require_once("inc/access_control.php");
AccessControl::requireType("Student");
$id="projects";
$title_name="Meus Projetos";
include("inc/top.php");
include("inc/pages/nav/nav_generic.php");
include("inc/pages/projects/student_projects.php");
include("inc/bottom.php");
?>
