<?php
require_once("user_data.php");
if(session_status()==PHP_SESSION_NONE)session_start();
if(!isset($_SESSION['logged']))$_SESSION['logged']=false;
if(!isset($_SESSION['user_data']))$_SESSION['user_data']=null;
function do403(string $message,bool $absolute_message=false){
    $_SESSION['403_message_absolute']=$absolute_message;
    $_SESSION['403_message']=$message;
    header("location:/access_denied.php");
    exit();
}
function is_logged():bool{
    return $_SESSION['logged'];
}
function get_account_type():string{//None, Student, Teacher, Admin
    if(is_logged())return $_SESSION['user_data']->getAccountType();
    else return "None";
}
function get_name():string{
    if(is_logged())return $_SESSION['user_data']->getName();
    else return "None";
}
function session_login(int $id,string $accountType,string $name){
    $_SESSION["logged"]=true;
    $_SESSION['user_data']=new UserData($id,$accountType,$name);
}
function session_logoff(){
    $_SESSION["logged"]=false;
    $_SESSION['user_data']=null;
}
?>