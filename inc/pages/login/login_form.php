<?php
$id="login";
$title_name="Login";
include("inc/pages/top.php");
include("inc/pages/nav/nav_generic.php");
if(isset($_SESSION['login_error'])){
    echo "<h1 class=error>";
    switch($_SESSION['login_error']){
        case "wrong_pass":
            echo "Senha Incorreta";
            break;
        case "wrong_user":
            echo "Usuário Inexistente";
            break;
        case "missing_user":
        case "missing_pass":
            echo "Favor Preencher todos campos";
            break;
        case "inactive_account":
            echo "Favor Ativar a Conta";
        default:
            echo "Erro em Login";
            break;
    }
    echo "</h1>";
    unset($_SESSION['login_error']);
}
echo '<div class=formwrapper>
<form action=login.php method=POST>
    <input type="hidden" name="proccess" value="true">
    <p><label for="user">Usuário: </label><input type="text" id="user" name="user"></p>
    <p><label for="pass">Senha: </label><input type="password" id="pass" name="pass"></p>
    <input type="submit" value="Logar">
</form></div>';
include("inc/pages/bottom.php");