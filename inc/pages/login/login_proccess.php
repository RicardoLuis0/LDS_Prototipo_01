<?php
use Database\DB,
    Session\Session;
if(isset($_POST["user"])){
    if(isset($_POST["pass"])){
        $db=new DB();
        $db->connect();
        $data=$db->checkLogin($_POST["user"],$_POST["pass"]);
        if($data!=null){
            Session::doUserLogin($data);
        }
    }else{
        $_SESSION['login_error']="missing_pass";
    }
}else{
    $_SESSION['login_error']="missing_user";
}
header("Location:login.php");