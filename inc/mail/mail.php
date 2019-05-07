<?php
require_once(realpath(__DIR__."/../database/classes.php"));
class Mailer {
    public static function sendActivation(DBUser $user){
        if(!$user->isActivated()){//TODO
            //$title;
            //$msg;
            //mail($sender);
        }
    }
}