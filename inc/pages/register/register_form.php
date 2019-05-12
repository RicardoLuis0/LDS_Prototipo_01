<?php
$id="register";
$title_name="Registro";
include("inc/pages/top.php");
include("inc/pages/nav/nav_generic.php");
if(isset($_SESSION['register_error'])){
    echo "<h1 class=error>";
    switch($_SESSION['register_error']){
        case "duplicate_user";
            echo "Usuário já Existente";
            break;
        case "missing_type":
        case "missing_user":
        case "missing_name":
        case "missing_pass":
        case "missing_email":
            echo "Favor Preencher todos campos";
            break;
        default:
            echo "Erro em Registro";
            break;
    }
    echo "</h1>";
    unset($_SESSION['register_error']);
}
echo '<div class=formwrapper>
<form action=register.php method=POST>
    <input type="hidden" name="proccess" value="true">
    <p><label for="user">Usuário: </label><input type="text" id="user" name="user"></p>
    <p><label for="name">Nome: </label><input type="text" id="name" name="name"></p>
    <p><label for="email">E-Mail: </label><input type="text" id="email" name="email"></p>
    <p><label for="type">Tipo de Conta: </label><select id="type" name="type">
        <option value="Student">Estudante</option>
        <option value="Teacher">Professor</option>
    </select></p>
    <input type="submit" value="Registrar">
</form></div>';
include("inc/pages/bottom.php");