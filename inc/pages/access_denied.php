<h1 class=error><p class=error_type>403 Forbidden</p>
<?php
if(isset($_SESSION["403_message"])){
    header('HTTP/1.1 403 Forbidden');
    if(isset($_SESSION["403_message_absolute"])&&$_SESSION["403_message_absolute"]){
        echo "<p>".$_SESSION["403_message"].".</p>";
        unset($_SESSION["403_message_absolute"]);
    }else{
        echo '<p>Acesso Negado,<br>'.$_SESSION["403_message"].'.</p>';
    }
    unset($_SESSION["403_message"]);
}else if(isset($_SESSION["401_message"])){
    header('HTTP/1.1 401 Unauthorized');
    if(isset($_SESSION["401_message_absolute"])&&$_SESSION["401_message_absolute"]){
        echo "<p>".$_SESSION["401_message"].".</p>";
        unset($_SESSION["401_message_absolute"]);
    }else{
        echo '<p>Acesso não Autorizado,<br>'.$_SESSION["401_message"].'.</p>';
    }
    unset($_SESSION["401_message"]);
}else{
    header('HTTP/1.1 403 Forbidden');
    echo '<p>Acesso Negado</p>';
}
?>
</h1>
