<?php
require_once("session_setup.php");
class AccessControl{
    public static function requireTypes(array $types,bool $soft=false,string $soft_target="index.php"){
        if(Session::isLoggedIn()){
            $type=Session::getUserData()->getAccountType();
            foreach($types as $t){
                if($t==$type)return;
            }
        }
        if($soft){
            header("Location:".$soft_target);
            die();
        }else{
            Session::do403Error("Nível de Acesso Insuficiente");
        }
    }
    public static function requireType(string $type,bool $soft=false,string $soft_target="index.php"){
        if(!(Session::isLoggedIn()&&Session::getUserData()->getAccountType()==$type)){
            if($soft){
                header("Location:".$soft_target);
                die();
            }else{
                Session::do403Error("Nível de Acesso Insuficiente");
            }
        }
    }
    public static function forbidType(string $type,bool $soft=false,string $soft_target="index.php"){
        if(!(Session::isLoggedIn()&&Session::getUserData()->getAccountType()==$type)){
            if($soft){
                header("Location:".$soft_target);
                die();
            }else{
                Session::do403Error("Nível de Acesso Insuficiente");
            }
        }
    }
    public static function forbidTypes(array $types,bool $soft=false,string $soft_target="index.php"){
        if(Session::isLoggedIn()){
            $type=Session::getUserData()->getAccountType();
            foreach($types as $t){
                if($t==$type){
                    if($soft){
                        header("Location:".$soft_target);
                        die();
                    }else{
                        Session::do403Error("Nível de Acesso Insuficiente");
                    }
                }
            }
        }
    }
    public static function requireLoggedOff(bool $soft=false,string $soft_target="index.php"){
        if(Session::isLoggedIn()){
            if($soft){
                header("Location:".$soft_target);
                die();
            }else{
                Session::do403Error("Nível de Acesso Insuficiente");
            }
        }

    }
    public static function requireLoggedIn(bool $soft=false,string $soft_target="index.php"){
        if(!Session::isLoggedIn()){
            if($soft){
                header("Location:".$soft_target);
                die();
            }else{
                Session::do403Error("Nível de Acesso Insuficiente");
            }
        }
    }
}