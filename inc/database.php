<?php
require_once("database/classes.php");
require_once("session_setup.php");

class ProjectProposalData{//dados necessarios para proposta de projeto

}

class ProjectIDData{//dados de identificacao do projeto

}

abstract class Database{
	protected $connected;
	protected abstract function getUserByID(int $id):?DBUser;
	protected abstract function getUserByLogin(string $login):?DBUser;
	protected abstract function addUser(DBUserAdd $data):bool;
	/*
	protected abstract function addProject(DBProjectAdd $proj):bool;
	protected abstract function getProjectByID(int $id):?DBProject;
	protected abstract function getUserProjects(int $user_id):?array;
	protected abstract function acceptProject(int $id):bool;
	*/
	public abstract function connect():void;
	public abstract function disconnect():void;
	protected function __construct__(){
		$this->connected=false;
	}
	public function isConnected():bool{
		return $this->connected;
	}
	public function checkLogin(string $login,string $password):?UserData{
		if(!$this->isConnected()){
			$_SESSION['login_error']='db_error';
			return null;
		}
		$user=$this->getUserByLogin($login);
		if($user===null){
			$_SESSION['login_error']='wrong_user';
		}else if(!$user->check_password($password)){
			$_SESSION['login_error']='wrong_pass';
		}else{
			//session_login($user->makeUserData());
			return $user->makeUserData();
		}
		return null;
	}
	public function registerUser(string $login,string $name,string $password,string $account_type):bool{
		if($this->addUser(new DBUserAdd($login,$name,$password,$account_type))){
			return true;
		}else{
			$_SESSION['register_error']='duplicate_user';
			return false;
		}
	}
	public function registerProjectProposal(int $teacher_id,string $project_name,string $project_description):bool{
		if(Session::isLoggedIn()){
			return addProject(Session::getUserData()->getId(),$teacher_id);
		}else{
			return false;
		}
	}
	/*
	public function registerProjectProposal(ProjectProposalData $projectData):bool{
		return false;
	}
	public function resendProjectProposal(ProjectProposalData $projectData):bool{
		return false;
	}
	public function acceptProjectProposal(ProjectIDData $acceptData):bool{
		return false;
	}
	public function rejectProjectProposal(ProjectIDData $rejectData):bool{
		return false;
	}
	public function removeProjectProposal(ProjectIDData $rejectData):bool{
		return false;
	}
	*/
}
?>