<?php
//require_once("inc/database/classes.php");
//require_once("inc/session_setup.php");
namespace Database;
use Session\Session,
	Session\UserData,
	Database\DBResult\DBUser,
    Database\DBResult\DBUserAdd,
    Database\DBResult\DBProject,
    Database\DBResult\DBProjectAdd,
    Database\DBResult\DBStudentProject,
	Database\DBResult\DBProjectStudent;
abstract class AbstractDatabase{
	protected $connected;
	public abstract function connect():void;
	public abstract function disconnect():void;
//user
	protected abstract function getUserByID(int $id):?DBUser;//returns found user
	protected abstract function getUserByLogin(string $login):?DBUser;//returns found user
	protected abstract function activateUser(string $login,string $password):bool;
	protected abstract function changeEmail(string $login,string $new_email):bool;
	protected abstract function addUser(DBUserAdd $data):?string;//returns activation key
	protected abstract function regenKey(string $login):?string;//regenerate activation key, returns null if user is inexistent or already activated
//project
	protected abstract function addProject(DBProjectAdd $proj):bool;
	protected abstract function studentSendDraft(int $user_id,int $project_id):bool;
	protected abstract function studentMakeDraft(int $user_id,int $project_id):bool;
	protected abstract function modifyDraft(int $id,?string $name,?string $desc,?int $teacher):bool;
	protected abstract function getProjectByID(int $id):?DBProject;
	protected abstract function getStudentProjects(int $id):array;
	protected abstract function getTeacherProjects(int $id):array;
	protected abstract function studentAcceptProject(int $user_id,int $project_id):bool;
	protected abstract function teacherAcceptProject(int $user_id,int $project_id):bool;
	protected abstract function studentRejectProject(int $user_id,int $project_id):bool;
	protected abstract function teacherRejectProject(int $user_id,int $project_id):bool;
//---
	public function __construct(){
		$this->connected=false;
	}

	public function isConnected():bool{
		return $this->connected;
	}

	public function checkActivationKey(string $login,string $key):bool{
		if(!$this->isConnected()){
			return false;
		}
		$user=$this->getUserByLogin($login);
		return($user&&(!$user->isActivated())&&password_verify($key,$user->getHash()));
	}

	public function checkLogin(string $login,string $password):?UserData{
		if(!$this->isConnected()){
			$_SESSION['login_error']='db_error';
			return null;
		}
		$user=$this->getUserByLogin($login);
		if($user===null){
			$_SESSION['login_error']='wrong_user';
		}else if(!$user->isActivated()){
			$_SESSION['login_error']='inactive_account';
		}else if(!$user->check_password($password)){
			$_SESSION['login_error']='wrong_pass';
		}else{
			return $user->makeUserData();
		}
		return null;
	}

	public function activateAccount(string $login,string $password,string $key):bool{
		if($this->checkActivationKey($login,$key)){
			return $this->activateUser($login,$password);
		}
		return false;
	}

	public function registerUser(string $login,string $name,string $account_type,string $email):?string{
		if(!$this->isConnected()){
			return null;
		}
		$key=$this->addUser(new DBUserAdd($login,$name,$account_type,$email));
		if($key!=null){
			return $key;
		}else{
			$_SESSION['register_error']='duplicate_user';
			return null;
		}
	}

	public function isActivated(string $login):bool{
		if(!$this->isConnected()){
			return false;
		}
		$user=$this->getUserByLogin($login);
		if($user){
			return $user->isActivated();
		}
		return false;
	}

	public function resendKey(string $login,?string $email=null):?string{
		if(!$this->isActivated($login)){
			//$user=getUserByLogin($login);
			$key=$this->regenKey($login);
			if($key&&$email!=null){
				$this->changeEmail($login,$email);
			}
			return $key;
		}
	}

	public function registerProjectDraft(int $teacher_id,string $project_name,string $project_description):bool{
		if($this->isConnected()&&Session::isLoggedIn()){
			return addProject(new DBProjectAdd(Session::getUserData()->getId(),$teacher_id,$project_name,$project_description));
		}else{
			return false;
		}
	}

	public function sendProjectDraft(int $project_id){
		if($this->isConnected()&&Session::isLoggedIn()){
			return $this->studentSendDraft(Session::getUserData()->getId(),$project_id);
		}else{
			return false;
		}
	}

	public function modifyProjectDraft(int $project_id,?string $new_description,?string $new_name):bool{
		if(!$this->isConnected()){
			return false;
		}
		return false;
	}
	/*
	public function acceptProjectProposal(???):bool{
		return false;
	}
	public function rejectProjectProposal(???):bool{
		return false;
	}
	public function removeProjectProposal(???):bool{
		return false;
	}
	*/
}
?>