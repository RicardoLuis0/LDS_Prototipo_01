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

    var modal=null;
    var search_input=null;
    var search_button=null;
    var search_results=null;

    window.onclick = function(event) {
        if (event.target == modal) {
            close_modal();
        }
    }

    function open_modal(){
        if(modal===null)modal=document.getElementById("modal_id");
        modal.style.display="block";
    }

    function close_modal(){
        modal.style.display="none";
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
                search_results.innerHTML=this.responseText;
            }else{
                search_results.innerHTML="";
            }
        },"teacher_id_ajax&q="+encoded_input)){
            search_button.disabled=false;
            search_results.innerHTML="";
        }
    }

</script>
<div class='modal' id="modal_id">
    <div class="modal_content">
        <div class=top><span class="close" onclick="close_modal();">&times;</span></div>
        <div class='searchbox'><input type="text" id="modal_searchinput"><button type=button id="modal_seachbutton" onclick="modal_search();"><img src="img/search.png"></button></div>
        <div class='searchresult'>
            <ul id='search_results'>
            </ul>
        </div>
    </div>
</div>
<div class=formwrapper>
    <form>
        <p><input type=text name="title"></p>
        <p><textarea name="description" cols="40" rows="5"></textarea></p>
        <p><span id="orientador">Nenhum Orientador Selecionado</span> <button type="button" onclick="open_modal();" >Selecionar Orientador</button></p>
        <p><input type=submit></p>
        <input type="hidden" name="teacher_id">
    </form>
</div>