<?php
$pass=$_POST['newpass'];
if($db->activateAccount($login,$pass,$key)){
    header("Location:login.php");
    die();
}else{
    $id=-1;
    $title_name="Ativação de Conta";
    include("inc/pages/top.php");
    include("inc/pages/nav/nav_generic.php");
    echo '<p>Usuário ou chave inválidas</p>';
    include("inc/pages/bottom.php");
}