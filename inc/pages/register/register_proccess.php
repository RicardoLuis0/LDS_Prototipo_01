<?php
use Database\DB,
    Mail\Mailer;
if(isset($_POST["user"])&&strlen($_POST["user"])>0){
    if(isset($_POST['email'])&&strlen($_POST["email"])>0){
        if(isset($_POST["name"])&&strlen($_POST["name"])>0){
            if(isset($_POST["type"])&&strlen($_POST["type"])>0){
                $type=$_POST["type"];
                if($type=="Student"||$type=="Teacher"){
                    $login=$_POST["user"];
                    $name=$_POST["name"];
                    $email=$_POST['email'];
                    $db=new DB();
                    $db->connect();
                    $key=$db->registerUser($login,$name,$type,$email);
                    if($key!=null){
                        Mailer::sendActivation($email,$login,$key);
                        header("Location:register.php");
                        exit();
                    }else if(!isset($_SESSION['register_error'])){
                        $_SESSION['register_error']="???";
                    }
                }else{
                    $_SESSION['register_error']="invalid_type";

                }
            }else{
                $_SESSION['register_error']="missing_type";
            }
        }else{
            $_SESSION['register_error']="missing_name";
        }
    }else{
        $_SESSION['register_error']="missing_email";
    }
}else{
    $_SESSION['register_error']="missing_user";
}
header("Location:register.php");
exit();