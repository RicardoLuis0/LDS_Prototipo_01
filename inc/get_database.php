<?php
require_once("database.php");
require_once("mock_db.php");
function getDatabase():Database{
    return new MockDB();
}
?>