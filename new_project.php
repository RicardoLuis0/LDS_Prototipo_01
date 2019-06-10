<?php
use Session\Session,
    Pages\AccessControl;

require_once('inc/autoload.php');

Session::initSession();

AccessControl::requireType("Student");

if(isset($_POST['ajax'])){
    include("inc/pages/projects/new_project_ajax.php");
}else{
    $id="projects";
    $title_name="Novo Projeto";
    include("inc/pages/top.php");
    include("inc/pages/nav/nav_generic.php");
    include("inc/pages/projects/new_project.php");
    include("inc/pages/bottom.php");
}

?>