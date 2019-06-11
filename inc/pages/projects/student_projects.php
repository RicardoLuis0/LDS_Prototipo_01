<?php
use Database\DB;

$db=new DB();
$db->connect();
$prjs=$db->getAllStudentProjects();
?>
<script>
class teacher{

}
class student{

}
class project{

}
</script>
<a href="new_project.php">Adicionar Projeto</a>
<ul>
<?php
foreach($prjs as $prj){
    echo "<li>".$prj->getProjectName()."</li>";
}
?>
</ul>