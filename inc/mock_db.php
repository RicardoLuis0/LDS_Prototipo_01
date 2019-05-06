<?php
require_once('database.php');
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
				return new DBUser($user['id'],$login,$user['name'],$user['hash'],$user['account_type']);
			}
		}
		return null;
	}
	protected function getUserByLogin(string $login):?DBUser{
		if(isset($_SESSION['mock_db']['users'][$login])){
			$data=$_SESSION['mock_db']['users'][$login];
			return new DBUser($data['id'],$login,$data['name'],$data['hash'],$data['account_type']);
		}else{
			return null;
		}
	}

	protected function addUser(DBUserAdd $data):bool{
		if(!isset($_SESSION['mock_db']['users'][$data->getLogin()])){
			$_SESSION['mock_db']['users'][$data->getLogin()]=[
				'id'=>++$_SESSION['mock_db']['meta']['users_last_id'],
				'name'=>$data->getName(),
				'hash'=>$data->makeHash(),
				'account_type'=>$data->getAccountType(),
			];
			return true;
		}else{
			return false;
		}
	}
}
?>