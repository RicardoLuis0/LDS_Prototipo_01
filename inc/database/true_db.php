<?php
require_once('inc/database.php');
require_once("inc/random/rand_string.php");
class DB extends Database{
	private $db=null;

	public function connect():void{
		$host="localhost";
		$username="root";
		$password="";
		$database="lds_project";
		if($this->db==null||!$this->connected){
			$this->db=new mysqli($host,$username,$password,$database);
			if($this->db->connect_errno){
				throw new Exception("Failed to connect to database: ".$this->db->connect_error);
			}
			$this->connected=true;
		}
	}

	public function ping():bool{
		if($this->db!=null){
			return $mysqli->ping();
		}
	}

	public function disconnect():void{
		if($this->db!=null&&$this->connected){
			$this->db->close();
			$this->connected=false;
		}
	}

	private function getUser(string $conditions):?DBUser{
		$query="select user_id,account_activated,login,name,hash,account_type,email from users where ".$conditions.";";
		$result=$this->db->query($query);
		if($result->num_rows>0){
			if($result->num_rows>1)throw new Exception("Invalid Query Result");
			$data=$result->fetch_assoc();
			return new DBUser($data['user_id'],$data['account_activated'],$data['login'],$data['name'],$data['hash'],$data['account_type'],$data['email']);
		}
		return null;
	}

	protected function getUserByID(int $id):?DBUser{
		$conditions="user_id=".$id;
		return $this->getUser($conditions);
	}

	protected function getUserByLogin(string $login):?DBUser{
		$conditions="login='".$login."'";
		return $this->getUser($conditions);
	}

	private function generateKey():string{
		return randomString(60);
	}

	private function getAddUserValues(DBUserAdd $data,string $key):string{
		//login,name,hash,account_type,email
		return "'".$data->getLogin()."','".$data->getName()."','".password_hash($key,PASSWORD_DEFAULT)."','".$data->getAccountType()."','".$data->getEmail()."'";
	}

	protected function addUser(DBUserAdd $data):?string{
		$key=$this->generateKey();
		$sql="insert into users(login,name,hash,account_type,email) values (".$this->getAddUserValues($data,$key).");";
		if($this->db->query($sql)===true){
			return $key;
		}
		return null;
	}

	protected function changeEmail(string $login,string $new_email):bool{
		return false;
	}

	protected function regenKey(string $login):?string{
		return null;
	}

	protected function activateUser(string $login,string $password):bool{
		$sql="update users set hash='".password_hash($password,PASSWORD_DEFAULT)."',account_activated=true where login='$login';";
		return ($this->db->query($sql)===true);
	}
}
?>