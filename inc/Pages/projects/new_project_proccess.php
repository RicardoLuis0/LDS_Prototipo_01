<?php
use Database\DB;
$error="none";
if(isset($_POST['title'])&&$_POST['title']!=""){
    if(isset($_POST['desc'])&&$_POST['desc']!=""){
        if(isset($_POST['teacher_id'])&&$_POST['teacher_id']!=""&&$_POST['teacher_id']!="null"){
            $title=$_POST['title'];
            $desc=$_POST['desc'];
            $teacher_id=$_POST['teacher_id'];
            $db=new DB();
            $db->connect();
            $db->registerProjectDraft($teacher_id,$title,$desc);
            header("Location:student_projects.php");
            die();
        }else{
            $error="Faltando Orientador";
        }
    }else{
        $error="Faltando Descrição";
    }
}else{
    $error="Faltando Título";
}
if($error!="none"){
    $id="projects";
    $title_name="Novo Projeto";
    $body_class="error";
    include("inc/pages/top.php");
    include("inc/pages/nav/nav_generic.php");
    echo "<h1 class=error>$error</h1>";
    include("inc/pages/bottom.php");
}