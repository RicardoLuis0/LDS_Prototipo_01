<?php
require_once('database.php');
require_once("random/rand_string.php");
class DB extends Database{
	private $db=null;
	public function connect():void{
		$host="localhost";
		$username="root";
		$password="";
		$database="lds_project";
		if($db==null){
			$db=new mysqli($host,$username,$password,$database);
			if($db->connect_errno){
				throw new Exception("Failed to connect to database: ".$mysqli->connect_error);
			}
			$this->connected=true;
		}
	}

	public function disconnect():void{
	}

	protected function getUserByID(int $id):?DBUser{
		return null;
	}
	protected function getUserByLogin(string $login):?DBUser{
		return null;
	}

	protected function addUser(DBUserAdd $data):?string{
		return null;
	}
	protected function changeEmail(string $new_email):bool{
		return false;
	}
	protected function regenKey(string $login):?string{
		return null;
	}
	protected function activateUser(string $login,string $password):bool{
		return false;
	}
}
?>