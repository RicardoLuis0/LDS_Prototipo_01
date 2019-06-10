<?php
use Session\Session,
    Pages\AccessControl,
    Database\DB;

require_once('inc/autoload.php');

Session::initSession();

AccessControl::requireType("Student");

if(isset($_POST['teacher_id_ajax'])){
    if(isset($_POST['q'])){
        $db=new DB();
        $db->connect();
        $arr=$db->searchTeachers($_POST['q']);
        if($arr){
            echo(json_encode($arr));
        }else{
            echo("<center><p>Nenhum Resultado</p></center>");
        }
    }
}else{
    $id="projects";
    $title_name="Novo Projeto";
    include("inc/pages/top.php");
    include("inc/pages/nav/nav_generic.php");
    include("inc/pages/projects/new_project.php");
    include("inc/pages/bottom.php");
}

?>