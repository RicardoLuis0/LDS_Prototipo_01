<?php
namespace Mail;
define("ACTIVATION_LINK","http://localhost/activate.php");
class Mailer {
    public static function sendActivation(string $email,string $login,string $key){
        $subject="Activation link";
        $message="activate your account: ".ACTIVATION_LINK."?user=".$login."&key=".$key;
        $header="From: sendmailtest123456789@gmail.com";
        mail($email,$subject,$message,$header);
    }
}