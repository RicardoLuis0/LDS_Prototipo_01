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

var modal_1_1=null;//project info modal
var modal_1_2=null;//student select modal
var modal_1_1_title=null;
var modal_1_1_desc=null;
var modal_1_1_orient=null;
var modal_1_1_student_list=null;
var search_input=null;
var search_button=null;
var search_results=null;

function modal_search(){
}

function open_modal_1_1(id){
    if(modal_1_1===null)modal_1_1=document.getElementById("modal_1_1_id");
    prj=project_data.get(id);
    if(prj===undefined)return;
    setup_prj_modal(prj);
    modal_1_1.style.display="block";
}

function open_modal_1_2(id){
    if(modal_1_1===null)modal_1_1=document.getElementById("modal_1_1_id");
    if(modal_1_2===null)modal_1_2=document.getElementById("modal_1_2_id");
    if(search_input===null)search_input=document.getElementById("modal_searchinput");
    search_input.value="";
    close_modal_1_1();
    modal_search();
    modal_1_2.style.display="block";
    document.getElementById("reverse_top").style['flex-direction']='row';
}

function setup_prj_modal(prj){
    if(modal_1_1_title===null)modal_1_1_title=document.getElementById("modal_1_1_title_id");
    if(modal_1_1_desc===null)modal_1_1_desc=document.getElementById("modal_1_1_desc_id");
    if(modal_1_1_orient===null)modal_1_1_orient=document.getElementById("modal_1_1_orient_id");
    if(modal_1_1_student_list===null)modal_1_1_student_list=document.getElementById("student_list");
    modal_1_1_title.textContent=prj.title;
    modal_1_1_desc.textContent=prj.desc;
    modal_1_1_orient.textContent=prj.teacher.name;
    if(!sendHttpPost("student_projects.php",function(){
        if (this.readyState == 4) {
            try{
                var output=JSON.parse(this.responseText);
                if(Array.isArray(output)){
                    var html="";
                    for(var i=0;i<output.length;i++){
                        if(Array.isArray(output[i])){
                            html+="<li>"+output[i][0]+"<button>&#x270E</button></li>";
                        }
                    }
                    modal_1_1_student_list.innerHTML=html;
                }else{
                    modal_1_1_student_list.innerHTML=this.responseText;
                }
            }catch(e){
                modal_1_1_student_list.innerHTML=this.responseText;
            }
        }else{
            modal_1_1_student_list.innerHTML="<p>Ajax fail</p>";
        }
    },"ajax=get_students&project_id="+prj.id)){
        alert("Ajax fail");
        modal_1_1_student_list.innerHTML="<p>Ajax fail</p>";
    }
}

function close_modal_1_1(){
    if(modal_1_1===null)modal_1_1=document.getElementById("modal_1_1_id");
    modal_1_1.style.display="none";//close modal 1_1
}

function close_modal_1_2(){
    if(modal_1_1===null)modal_1_1=document.getElementById("modal_1_1_id");
    if(modal_1_2===null)modal_1_2=document.getElementById("modal_1_2_id");
    modal_1_2.style.display="none";//close modal 1_2
    modal_1_1.style.display="block";//reopen modal 1_1
}

window.onclick = function(event) {
    if (event.target == modal_1_1) {
        close_modal_1_1();
    }else if(event.target == modal_1_2){
        close_modal_1_2();
    }
}

function modal_search(){
    if(search_input===null)search_input=document.getElementById("modal_searchinput");
    if(search_button===null)search_button=document.getElementById("modal_seachbutton");
    if(search_results===null)search_results=document.getElementById("search_results");
    var encoded_input=encodeURIComponent(search_input.value);
    search_button.disabled=true;
    if(!sendHttpPost("new_project.php",function(){
        search_button.disabled=false;
        if (this.readyState == 4) {
            try{
                var output=JSON.parse(this.responseText);
                if(Array.isArray(output)){
                    var html="";
                    for(var i=0;i<output.length;i++){
                        if(Array.isArray(output[i])){
                            html+="<li>"+output[i][0]+"<button onclick=\"add_student('"+output[i][0]+"',"+output[i][1]+")\">&#x271A</button></li>";
                        }
                    }
                    search_results.innerHTML=html;
                }else{
                    search_results.innerHTML=this.responseText;
                }
            }catch(e){
                search_results.innerHTML=this.responseText;
            }
        }else{
            search_results.innerHTML="";
        }
    },"ajax=student_id&q="+encoded_input)){
        search_button.disabled=false;
        search_results.innerHTML="";
    }
}

function add_student(a,b){
    //TODO
}

</script>

<div class='modal' id="modal_1_1_id">
    <div class="modal_content">
        <div class=top><span class="close" onclick="close_modal_1_1();">&times;</span></div>
        <h1 id='modal_1_1_title_id'></h1>
        <p id='modal_1_1_desc_id'></p>
        <h4>Orientador: <span id='modal_1_1_orient_id'></span></h4>
        <h4>Participantes:</h4>
        <div class='scrollbox scrollbox_short'>
            <ul id='student_list'>
            </ul>
        </div>
        <button onclick='open_modal_1_2(0)'>Adicionar Participante</button>
    </div>
</div>
<div class='modal' id="modal_1_2_id">
    <div class="modal_content">
        <div class=top id='reverse_top'><span class="back" onclick="close_modal_1_2();">&#x25c4;</span></div>
        <div class='searchbox'><input type="text" id="modal_searchinput"><button type=button id="modal_seachbutton" onclick="modal_search();"><img src="img/search.png"></button></div>
        <div class='scrollbox'>
            <ul id='search_results'>
            </ul>
        </div>
    </div>
</div>

<a href="new_project.php">Adicionar Projeto</a>
<ul>
<?php
foreach($prjs as $prj){
    echo "\t<li>\n\t\t<button onclick='open_modal_1_1(".$prj->getProjectId().");'>".$prj->getProjectName()."</button>\n\t</li>\n";
}
?>
</ul>