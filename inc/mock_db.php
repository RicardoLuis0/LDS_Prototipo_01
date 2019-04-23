<?php
require_once("database.php");
class MockDB extends Database{
	public function connect():void{
		//check session status
		if(!session_status())throw "Session not initialized";
		//check session data, create mock database if necessary
		if(!isset($_SESSION["mock_db"])){
			$_SESSION["mock_db"]=[
				"last_id"=>1,
				"users"=>[
					"admin"=>[
						"id"=>1,
						"name"=>"Administrador",
						"pass_hash"=>password_hash("admin",PASSWORD_DEFAULT),
						"account_type"=>"Admin",
					],
				],
				"projects"=>[],
			];
		}
		$this->connected=true;
	}

	public function disconnect():void{
		$this->connected=false;
	}

	public function checkLogin(LoginData $loginData):bool{
		if(!$this->connected)throw "Database not Connected";
		$login=$loginData->getLogin();
		$pass=$loginData->getPassword();
		if(isset($_SESSION["mock_db"]["users"][$login])){
			$user_data=$_SESSION["mock_db"]["users"][$login];
			if(password_verify($pass,$user_data["pass_hash"])){
				session_login($user_data['id'],$user_data['account_type'],$user_data['name']);
				return true;
			}else{
				$_SESSION["login_error"]="wrong_pass";
			}
		}else{
			$_SESSION["login_error"]="wrong_user";
		}
		return false;
	}

	public function registerUser(RegisterData $registerData):bool{
		if(!$this->connected)throw "Database not Connected";
		$login=$registerData->getLogin();
		$name=$registerData->getName();
		$pass=$registerData->getPassword();
		$account_type=$registerData->getAccountType();
		if(!isset($_SESSION["mock_db"]["users"][$login])){
			$_SESSION["mock_db"]["users"][$login]=[
				"id"=>++$_SESSION['mock_db']['last_id'],
				"name"=>$name,
				"pass_hash"=>password_hash($pass,PASSWORD_DEFAULT),
				"account_type"=>$account_type,
			];
			return true;
		}else{
			$_SESSION["register_error"]="duplicate_user";
		}
		return false;
	}
}
?>