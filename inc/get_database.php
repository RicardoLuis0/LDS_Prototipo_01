<?php
require_once("database.php");
require_once("database/mock_db.php");
require_once("database/true_db.php");
function getDatabase():Database{
    //return new MockDB();
    return new DB();
}
?>