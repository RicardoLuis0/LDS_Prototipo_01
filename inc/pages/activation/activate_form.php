<?php
$id=-1;
$title_name="Ativação de Conta";
include("inc/top.php");
include("inc/pages/nav/nav_generic.php");
if($db->checkActivationKey($login,$key)){
    echo '<form action="?user='.$login.'&key='.$key.'" method="POST">
    <p><label for="pass">Nova Senha: </label><input type="password" id="pass" name="newpass"></p>
    <input type="submit" value="Confirmar Ativação">
    </form>';
}else{
    echo '<p>Usuário ou chave inválidas</p>';
}
include("inc/bottom.php");