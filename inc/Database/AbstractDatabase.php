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
	protected abstract function activateUser(string $login,string $password):bool;//activate user account
	protected abstract function changeEmail(string $login,string $new_email):bool;//change user email
	protected abstract function addUser(DBUserAdd $data):?string;//returns activation key
	protected abstract function regenKey(string $login):?string;//regenerate activation key, returns null if user is inexistent or already activated
	protected abstract function searchUsersTeachers(array $q):?array;
//project
	protected abstract function addProject(DBProjectAdd $proj):bool;
	protected abstract function studentSendDraft(int $user_id,int $project_id):bool;//send draft to teacher as proposal
	protected abstract function studentMakeDraft(int $user_id,int $project_id):bool;//turn proposal/rejection into draft
	protected abstract function modifyDraft(int $id,?string $name,?string $desc,?int $teacher):bool;
	protected abstract function getProjectByID(int $id,bool $get_students=false):?DBProject;
	protected abstract function getStudentProjects(int $id,bool $get_students=false):array;
	protected abstract function getTeacherProjects(int $id,bool $get_students=false):array;
	protected abstract function studentAcceptProject(int $user_id,int $project_id):bool;//accept project invitation
	protected abstract function teacherAcceptProject(int $user_id,int $project_id):bool;//accept project proposal
	protected abstract function studentRejectProject(int $user_id,int $project_id):bool;//reject project invitation/leave project
	protected abstract function teacherRejectProject(int $user_id,int $project_id):bool;//reject project proposal
//---
	public function __construct(){
		$this->connected=false;
	}

	public function isConnected():bool{
		return $this->connected;
	}

	public function getUserFromId(int $id):?DBUser{
		if(!$this->isConnected()){
			return null;
		}
		return $this->getUserByID($id);
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
		return null;
	}
	
	public function searchTeachers(string $terms):?array{
		if(!$this->isConnected()){
			return null;
		}
		$arr=explode(" ",$terms);
		return $this->searchUsersTeachers($arr);
	}

	public function registerProjectDraft(int $teacher_id,string $project_name,string $project_description):bool{
		if($this->isConnected()&&Session::isLoggedIn()){
			return $this->addProject(new DBProjectAdd(Session::getUserData()->getId(),$teacher_id,$project_name,$project_description));
		}else{
			return false;
		}
	}

	public function sendProjectDraft(int $project_id):bool{
		if($this->isConnected()&&Session::isLoggedIn()){
			return $this->studentSendDraft(Session::getUserData()->getId(),$project_id);
		}else{
			return false;
		}
	}

	public function modifyProjectDraft(int $project_id,?string $new_description,?string $new_name,?int $teacher_id):bool{
		if(!$this->isConnected()){
			return false;
		}
		return $this->modifyDraft($project_id,$new_description,$new_name,$teacher_id);
	}

	public function getAllStudentProjects(bool $get_students=false):?array{
		if(!$this->isConnected()){
			return null;
		}
		return $this->getStudentProjects(Session::getUserData()->getId(),$get_students);
	}

	public function getProject(int $id,bool $get_students=false):?DBProject{
		if(!$this->isConnected()){
			return null;
		}
		return $this->getProjectByID($id,$get_students);
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