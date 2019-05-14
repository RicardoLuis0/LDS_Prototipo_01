<?php
require_once('inc/database/abstract_database.php');
require_once("inc/random/rand_string.php");
class DB extends Database{
	private $db=null;
//TODO prevent sql injection
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
			//if($result->num_rows>1)throw new Exception("Invalid Query Result");
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
		throw new Exception("Not implemented");
		return false;
	}

	protected function regenKey(string $login):?string{
		throw new Exception("Not implemented");
		return null;
	}

	protected function activateUser(string $login,string $password):bool{
		$sql="update users set hash='".password_hash($password,PASSWORD_DEFAULT)."',account_activated=true where login='$login';";
		return ($this->db->query($sql)===true);
	}

	protected function addProject(DBProjectAdd $proj):bool{

	}

	private function getProjectStudents(int $id):array{
		$sql="select student_id,accepted from project_student where project_id=".$id.";";
		$result=$db->query($sql);
		if($result->num_rows>0){
			$output=[];
			while($row=$result->fetch_assoc()){
				array_push($output,new DBProjectStudent($row['student_id'],$id,$row['accepted']));
			}
			return $output;
		}
		return [];
	}
	protected function getProjectByID(int $id):?DBProject{
		$sql="select project_id,name,description,teacher_id,status from projects where id=".$id.";";
		$result=$db->query($sql);
		if($result->num_rows>0){
			$data=$result->fetch_assoc();
			return new DBProject(getProjectStudents($data['project_id']),$data['project_id'],$data['teacher_id'],$data['name'],$data['description'],$data['status']);
		}
		return null;
	}

	protected function getStudentProjects(int $id):array{
		//$sql="select project_id,accepted from project_student where student_id=".$id.";";
		$sql="select ps.accepted,p.project_id,p.name,p.description,p.teacher_id,p.status from project_student as ps inner join projects as p on ps.project_id=p.project_id where ps.student_id=".$id.";";
		$result=$db->query($sql);
		if($result->num_rows>0){
			$output=[];
			while($row=$result->fetch_assoc()){
				array_push($output,new DBStudentProject(getProjectStudents($data['project_id']),$data['project_id'],$data['teacher_id'],$data['name'],$data['description'],$data['status'],$data['accepted']));
			}
			return $output;
		}
		return [];
	}

	protected function getTeacherProjects(int $id):array{
		$sql="select project_id,name,description,teacher_id,status from projects where teacher_id=".$id.";";
		$result=$db->query($sql);
		if($result->num_rows>0){
			$output=[];
			while($row=$result->fetch_assoc()){
				array_push($output,new DBProject(getProjectStudents($data['project_id']),$data['project_id'],$data['teacher_id'],$data['name'],$data['description'],$data['status']));
			}
			return $output;
		}
		return [];
	}

	protected function studentAcceptProject(int $user_id,int $project_id):bool{
		$sql="update project_student set accepted=true where student_id=".$user_id." and project_id=".$project_id.";";
		return ($this->db->query($sql)===true);
	}

	protected function teacherAcceptProject(int $user_id,int $project_id):bool{
		$sql="update projects set status='Accepted' where teacher_id=".$user_id." and project_id=".$project_id." and status='Pending';";
		return ($this->db->query($sql)===true);
	}
}
?>