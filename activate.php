<?php
if(isset($_GET['user'])){
    if(isset($_GET['key'])){
        require_once("inc/get_database.php");
        $login=$_GET['user'];
        $key=$_GET['key'];
        $db=getDatabase();
        $db->connect();
        if(isset($_POST['newpass'])){
            $pass=$_POST['newpass'];
            if($db->activateAccount($login,$pass,$key)){
                header("Location:login.php");
            }else{
                echo '<p>Usuario ou chave invalidas</p>';
            }
        }else{
            if($db->checkActivationKey($login,$key)){
                //show password creation form
                echo '<form action="?user='.$login.'&key='.$key.'" method="POST">
                <p><label for="pass">Nova Senha: </label><input type="password" id="pass" name="newpass"></p>
                <input type="submit" value="Confirmar Ativação">
                </form>';
            }else{
                echo '<p>Usuario ou chave invalidas</p>';
            }
        }
        die();
    }
}
header("Location:index.php");
die();