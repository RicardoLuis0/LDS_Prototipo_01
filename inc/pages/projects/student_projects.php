<?php
use Database\DB,
    Session\Session;

$db=new DB();
$db->connect();
$prjs=$db->getAllStudentProjects();
$userdata=Session::getUserData();
?>


<script>

function sendHttpPost(url,method,data){
    try{
        var request = new XMLHttpRequest();
        request.addEventListener("load",method);
        request.open("POST",url,true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(data);
        return true;
    }catch(e){
        return false;
    }
}

class Teacher{
    constructor(id,name){
        this.id=id;
        this.name=name;
    }
}

class Student{
    constructor(id,name,is_leader,is_pending){
        this.id=id;
        this.name=name;
        this.is_leader=is_leader;
        this.is_pending=is_pending;
    }
}

class UserData{
    constructor(id,name){
        this.id=id;
        this.name=name;
    }
}

class Project{
    constructor(id,title,desc,is_leader,is_pending,teacher){
        this.id=id;
        this.title=title;
        this.desc=desc;
        this.is_leader=is_leader;
        this.is_pending=is_pending;
        this.teacher=teacher;
    }
}

var user_data=new UserData(<?=$userdata->getID()?>,'<?=$userdata->getName()?>');
var project_data=new Map([
<?php
    foreach($prjs as $prj){
        $teacher=$db->getUserFromId($prj->getTeacherId());
        echo "\t[".$prj->getProjectId().",new Project(".$prj->getProjectId().",'".$prj->getProjectName()."','".$prj->getProjectDescription()."',".$prj->isStudentManager().",".(!$prj->hasStudentAccepted()).",new Teacher(".$teacher->getId().",'".$teacher->getName()."'))],\n";
    }
?>
]);

var modal=null;
var modal_title=null;
var modal_desc=null;

function open_modal(id){
    if(modal===null)modal=document.getElementById("modal_id");
    prj=project_data.get(id);
    if(prj===undefined)return;
    setup_modal(prj);
    modal.style.display="block";
}

function setup_modal(prj){
    if(modal_title===null)modal_title=document.getElementById("modal_title");
    if(modal_desc===null)modal_desc=document.getElementById("modal_desc");
    modal_title.innerHTML=prj.title;
    modal_desc.innerHTML=prj.desc;
}

function close_modal(){
    if(modal===null)modal=document.getElementById("modal_id");
    modal.style.display="none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        close_modal();
    }
}

</script>

<div class='modal' id="modal_id">
    <div class="modal_content">
        <div class=top><span class="close" onclick="close_modal();">&times;</span></div>
        <h1 id='modal_title'></h1>
        <p id='modal_desc'></p>
    </div>
</div>

<a href="new_project.php">Adicionar Projeto</a>
<ul>
<?php
foreach($prjs as $prj){
    echo "\t<li>\n\t\t<button onclick='open_modal(".$prj->getProjectId().");'>".$prj->getProjectName()."</button>\n\t</li>\n";
}
?>
</ul>