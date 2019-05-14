<?php
require_once("database/db.php");
function getDatabase():Database{
    return new DB();
}
?>