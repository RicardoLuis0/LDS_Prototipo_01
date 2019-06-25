<?php
//TODO prevent sql injection
namespace Database;
use \mysqli,
	Database\AbstractDatabase,
	Random\RandomString,
	Database\DBResult\DBUser,
	Database\DBResult\DBUserAdd,
	Database\DBResult\DBProject,
	Database\DBResult\DBProjectAdd,
	Database\DBResult\DBStudentProject,
	Database\DBResult\DBProjectStudent;
class DB extends AbstractDatabase{
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
		$login=$this->db->real_escape_string($login);
		$conditions="login='".$login."'";
		return $this->getUser($conditions);
	}

	private function generateKey():string{
		return RandomString::get(60);
	}

	private function getAddUserValues(DBUserAdd $data,string $key):string{
		return "'".$data->getLogin()."','".$data->getName()."','".password_hash($key,PASSWORD_DEFAULT)."','".$data->getAccountType()."','".$data->getEmail()."'";
	}

	protected function addUser(DBUserAdd $data):?string{
		$data->escape($this->db);
		$key=$this->generateKey();
		$sql="insert into users(login,name,hash,account_type,email) values (".$this->getAddUserValues($data,$key).");";
		if($this->db->query($sql)>0){
			return $key;
		}
		return null;
	}

	protected function changeEmail(string $login,string $new_email):bool{
		$login=$this->db->real_escape_string($login);
		$new_email=$this->db->real_escape_string($new_email);
		$sql="update users set email='".$new_email."' where login='$login';";
		return ($this->db->query($sql)>0);
	}

	protected function regenKey(string $login):?string{
		$login=$this->db->real_escape_string($login);
		//TODO
		throw new Exception("Not implemented");
		return null;
	}

	protected function activateUser(string $login,string $password):bool{
		$login=$this->db->real_escape_string($login);
		$password=$this->db->real_escape_string($password);
		$sql="update users set hash='".password_hash($password,PASSWORD_DEFAULT)."',account_activated=true where login='$login';";
		return ($this->db->query($sql)>0);
	}

	protected function addProject(DBProjectAdd $proj):bool{
		$proj->escape($this->db);
		$sql="insert into projects (name,description,teacher_id) values ('".$proj->getProjectName()."','".$proj->getProjectDescription()."',".$proj->getTeacherId().");";
		if($this->db->query($sql)>0){
			$id=$this->db->insert_id;
			$sql="insert into project_student (project_id,student_id,manager) values (".$id.",".$proj->getStudentId().",true);";
			if($this->db->query($sql)>0){
				return true;
			}else{
				$sql="delete from projects where project_id=".$id.";";
				$this->db->query($sql);
			}
		}
		return false;
	}

	protected function studentSendDraft(int $user_id,int $project_id):bool{
		$sql="select manager from project_student where project_id = ".$project_id." and student_id = ".$user_id.";";
		$result=$this->db->query($sql);
		if($result->num_rows>0&&$result->fetch_assoc()['manager']==true){
			$sql="update projects set status='Pending' where project_id = ".$project_id." and status = 'Draft';";
			return ($this->db->query($sql)>0);
		}
		return false;
	}
	protected function studentMakeDraft(int $user_id,int $project_id):bool{
		$sql="select manager from project_student where project_id = ".$project_id." and student_id = ".$user_id.";";
		$result=$this->db->query($sql);
		if($result->num_rows>0&&$result->fetch_assoc()['manager']==true){
			$sql="update projects set status='Draft' where project_id = ".$project_id." and ( status = 'Pending' or status = 'Rejected' );";
			return ($this->db->query($sql)>0);
		}
		return false;
	}

	protected function getProjectStudents(int $id):array{
		$sql="select student_id,accepted,manager from project_student where project_id=".$id.";";
		$result=$this->db->query($sql);
		if($result->num_rows>0){
			$output=[];
			while($row=$result->fetch_assoc()){
				array_push($output,new DBProjectStudent($row['student_id'],$id,$row['accepted'],$row['manager']));
			}
			return $output;
		}
		return [];
	}
	protected function getProjectByID(int $id,bool $get_students=false):?DBProject{
		$sql="select project_id,name,description,teacher_id,status from projects where id=".$id.";";
		$result=$this->db->query($sql);
		if($result->num_rows>0){
			$data=$result->fetch_assoc();
			return new DBProject($get_students?$this->getProjectStudents($data['project_id']):null,$data['project_id'],$data['teacher_id'],$data['name'],$data['description'],$data['status']);
		}
		return null;
	}

	protected function getStudentProjects(int $id,bool $get_students=false):array{
		//$sql="select project_id,accepted from project_student where student_id=".$id.";";
		$sql="select ps.accepted,ps.manager,p.project_id,p.name,p.description,p.teacher_id,p.status from project_student as ps inner join projects as p on ps.project_id=p.project_id where ps.student_id=".$id.";";
		$result=$this->db->query($sql);
		if($result->num_rows>0){
			$output=[];
			while($row=$result->fetch_assoc()){
				array_push($output,new DBStudentProject($get_students?$this->getProjectStudents($row['project_id']):null,$row['project_id'],$row['teacher_id'],$row['name'],$row['description'],$row['status'],$row['accepted'],$row['manager']));
			}
			return $output;
		}
		return [];
	}

	protected function getTeacherProjects(int $id,bool $get_students=false):array{
		$sql="select project_id,name,description,teacher_id,status from projects where teacher_id=".$id.";";
		$result=$this->db->query($sql);
		if($result->num_rows>0){
			$output=[];
			while($row=$result->fetch_assoc()){
				array_push($output,new DBProject($get_students?$this->getProjectStudents($data['project_id']):null,$data['project_id'],$data['teacher_id'],$data['name'],$data['description'],$data['status']));
			}
			return $output;
		}
		return [];
	}

	protected function studentAcceptProject(int $user_id,int $project_id):bool{
		$sql="update project_student set accepted=true where student_id=".$user_id." and project_id=".$project_id.";";
		return ($this->db->query($sql)>0);
	}

	protected function teacherAcceptProject(int $user_id,int $project_id):bool{
		$sql="update projects set status='Accepted' where teacher_id=".$user_id." and project_id=".$project_id." and status='Pending';";
		return ($this->db->query($sql)>0);
	}
	protected function studentRejectProject(int $user_id,int $project_id):bool{
		$sql="delete from project_student where student_id=".$user_id." and project_id=".$project_id.";";
		return ($this->db->query($sql)>0);
	}
	protected function teacherRejectProject(int $user_id,int $project_id):bool{
		$sql="update projects set status='Rejected' where teacher_id=".$user_id." and project_id=".$project_id." and status='Pending';";
		return ($this->db->query($sql)>0);
	}

	protected function modifyDraft(int $id,?string $name,?string $desc,?int $teacher):bool{
		if($name||$desc||$teacher){
			$sql="update projects set ";
			if($name){
				$sql.="name = '".$this->db->real_escape_string($name)."'".(($desc||$teacher)?", ":" ");
			}
			if($desc){
				$sql.="description = '".$this->db->real_escape_string($desc)."'".($teacher?", ":" ");
			}
			if($teacher){
				$sql.="teacher_id = ".$teacher." ";
			}
			$sql.=" where project_id = ".$id." and status = 'Draft';";
			return ($this->db->query($sql)>0);
		}else{
			return false;
		}
	}
	
	protected function searchUsersTeachers(array $q):?array{
		$sql="select name,user_id from users where account_activated = true and account_type = 'Teacher' ";
		foreach($q as $st){
			$sql.="and name like \"%".$this->db->real_escape_string($st)."%\" ";
		}
		$sql.=";";
		$result=$this->db->query($sql);
		if($result->num_rows>0){
			return $result->fetch_all(MYSQLI_NUM);
		}else{
			return null;
		}
	}
	
	protected function searchUsersStudents(array $q):?array{
		$sql="select name,user_id from users where account_activated = true and account_type = 'Student' ";
		foreach($q as $st){
			$sql.="and name like \"%".$this->db->real_escape_string($st)."%\" ";
		}
		$sql.=";";
		$result=$this->db->query($sql);
		if($result->num_rows>0){
			return $result->fetch_all(MYSQLI_NUM);
		}else{
			return null;
		}
	}
}
?>