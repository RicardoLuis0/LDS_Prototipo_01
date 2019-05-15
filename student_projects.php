<?php
use Session\Session,
    Pages\AccessControl;

require_once('inc/autoload.php');

Session::initSession();

AccessControl::requireType("Student");
$id="projects";
$title_name="Meus Projetos";
include("inc/pages/top.php");
include("inc/pages/nav/nav_generic.php");
include("inc/pages/projects/student_projects.php");
include("inc/pages/bottom.php");
?>
