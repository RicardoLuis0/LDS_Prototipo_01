<?php
use Database\DB;
switch($_POST['ajax']){
case 'student_id':
    if(isset($_POST['q'])){//search students
        $db=new DB();
        $db->connect();
        $arr=$db->searchStudents($_POST['q']);
        if($arr){
            echo(json_encode($arr));
        }else{
            echo("<center><p>Nenhum Resultado</p></center>");
        }
    }
    break;
case 'get_students':
    if(isset($_POST['project_id'])){
        $db=new DB();
        $db->connect();
        $arr=$db->getAllProjectStudents($_POST['project_id']);
        if($arr){
            echo(json_encode($arr));
        }else{
            echo("<center><p>Nenhum Integrante</p></center>");
        }
    }
    break;
default:
    break;
}
