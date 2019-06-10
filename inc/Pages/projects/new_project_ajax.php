<?php
use Database\DB;
switch($_POST['ajax']){
case 'teacher_id':
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
    break;
default:
    break;
}
