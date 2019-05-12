<?php
require_once('database.php');
require_once("random/rand_string.php");
class MockDB extends Database{
	public function connect():void{
		//check session status
		if(session_status()!=PHP_SESSION_ACTIVE)throw new Exception('Session error');
		//check session data, create mock database if necessary
		if(!isset($_SESSION['mock_db'])){
			$_SESSION['mock_db']=[
				'meta'=>[
					'users_last_id'=>1,
				],
				'users'=>[
					'admin'=>[
						'id'=>1,
						'name'=>'Administrador',
						'hash'=>password_hash('admin',PASSWORD_DEFAULT),
						'account_type'=>'Admin',
						'email'=>'ricolvs123@gmail.com',
						'activated'=>true,
					],
				],
				'projects'=>[
					/*
					*/
				],
			];
		}
		$this->connected=true;
	}

	public function disconnect():void{
		$this->connected=false;
	}

	protected function getUserByID(int $id):?DBUser{
		foreach($_SESSION['mock_db']['users'] as $login => $user){
			if($user['id']==$id){
				return new DBUser($user['id'],$user['activated'],$user['activation_key'],$login,$user['name'],$user['hash'],$user['account_type'],$user['email']);
			}
		}
		return null;
	}
	protected function getUserByLogin(string $login):?DBUser{
		if(isset($_SESSION['mock_db']['users'][$login])){
			$data=$_SESSION['mock_db']['users'][$login];
			return new DBUser($data['id'],$data['activated'],$login,$data['name'],$data['hash'],$data['account_type'],$data['email']);
		}
		return null;
	}

	protected function addUser(DBUserAdd $data):?string{
		if(!isset($_SESSION['mock_db']['users'][$data->getLogin()])){
			$_SESSION['mock_db']['users'][$data->getLogin()]=[
				'id'=>++$_SESSION['mock_db']['meta']['users_last_id'],
				'name'=>$data->getName(),
				//'hash'=>password_hash($key,PASSWORD_DEFAULT),
				//'hash'=>$data->makeHash(),
				'account_type'=>$data->getAccountType(),
				'email'=>$data->getEMail(),
				'activated'=>false,
				//'activation_key'=>randomString(60),
			];
			return $this->regenKey($data->getLogin());
		}
		return null;
	}
	protected function changeEmail(string $new_email):bool{
		if(isset($_SESSION['mock_db']['users'][$login])){
			$_SESSION['mock_db']['users'][$login]['email']=$new_email;
			return true;
		}
		return false;
	}
	protected function regenKey(string $login):?string{
		if(isset($_SESSION['mock_db']['users'][$login])){
			if(!$_SESSION['mock_db']['users'][$login]['activated']){
				$key=randomString(60);//random string
				$_SESSION['mock_db']['users'][$login]['hash']=password_hash($key,PASSWORD_DEFAULT);
				return $key;
			}
		}
		return null;
	}
	protected function activateUser(string $login,string $password):bool{
		if(isset($_SESSION['mock_db']['users'][$login])){
			$_SESSION['mock_db']['users'][$login]['activated']=true;
			$_SESSION['mock_db']['users'][$login]['hash']=password_hash($password,PASSWORD_DEFAULT);
			return true;
		}
		return false;
	}
}
?>