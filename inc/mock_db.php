<?php
require_once("database.php");
class MockDB extends Database{
	public function connect():void{
		//check session status
		if(!session_status())throw "Session not initialized";
		//check session data, create mock database if necessary
		if(!isset($_SESSION["mock_db"])){
			$_SESSION["mock_db"]=[
				"users"=>[
					"admin"=>[
						"name"=>"Administrador",
						"pass_hash"=>password_hash("admin",PASSWORD_DEFAULT),
						"is_admin"=>true,
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
				$_SESSION["logged"]=true;
				$_SESSION["is_admin"]=$user_data["is_admin"];
				$_SESSION["name"]=$user_data["name"];
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
		if(!isset($_SESSION["mock_db"]["users"][$login])){
			$_SESSION["mock_db"]["users"][$login]=[
				"name"=>$name,
				"pass_hash"=>password_hash($pass,PASSWORD_DEFAULT),
				"is_admin"=>false,
			];
			return true;
		}else{
			$_SESSION["register_error"]="duplicate_user";
		}
		return false;
	}
}
?>