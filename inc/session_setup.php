<?php
require_once("user_data.php");
class Session{
    public static function do403Error(string $message,bool $absolute_message=false){
        $_SESSION['403_message_absolute']=$absolute_message;
        $_SESSION['403_message']=$message;
        header("location:/access_denied.php");
        exit();
    }
    public static function initSession(){
        if(session_status()==PHP_SESSION_NONE)session_start();
        if(!isset($_SESSION['logged']))$_SESSION['logged']=false;
        if(!isset($_SESSION['user_data']))$_SESSION['user_data']=null;
    }
    public static function isLoggedIn():bool{
        return $_SESSION['logged'];
    }
    public static function getUserData():UserData{
        if(Session::isLoggedIn())return $_SESSION['user_data'];
        throw new Exception('not logged in');
    }
    public static function doUserLogin(UserData $data):bool{
        if($data!=null&&!Session::isLoggedIn()){
            $_SESSION["logged"]=true;
            $_SESSION['user_data']=$data;
            return true;
        }else{
            return false;
        }
    }
    public static function doUserLogoff():bool{
        if(Session::isLoggedIn()){
            $_SESSION["logged"]=false;
            $_SESSION['user_data']=null;
            return true;
        }else{
            return false;
        }
    }
}
//autoinit
Session::initSession();
?>