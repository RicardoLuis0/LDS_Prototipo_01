<?php
use Database\DB;

$login=$_GET['user'];
$key=$_GET['key'];
$db=new DB();
$db->connect();
if(isset($_POST['newpass'])){
    include("inc/pages/activation/activate_proccess.php");
}else{
    include("inc/pages/activation/activate_form.php");
}
die();