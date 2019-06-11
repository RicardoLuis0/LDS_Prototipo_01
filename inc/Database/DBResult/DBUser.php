<?php
namespace Database\DBResult;
use Session\UserData;
class DBUser{
	private $id;//int
	private $activated;//bool
	private $login;//string
	private $name;//string
	private $hash;//string/hash
	private $account_type;//string
	private $email;//string
	public function __construct(int $id,bool $activated,string $login,string $name,string $hash,string $account_type,string $email){
		$this->id=$id;
		$this->login=$login;
		$this->name=$name;
		$this->hash=$hash;
		$this->account_type=$account_type;
		$this->email=$email;
		$this->activated=$activated;
	}
	public function check_password(string $pass):bool{
		return password_verify($pass,$this->hash);
	}
	public function getID(){
		return $this->id;
	}
	public function getLogin(){
		return $this->login;
	}
	public function getName(){
		return $this->name;
	}
	public function getHash(){
		return $this->hash;
	}
	public function getAccountType(){
		return $this->account_type;
	}
	public function getEMail(){
		return $this->email;
	}
	public function isActivated(){
		return $this->activated;
	}
	public function makeUserData():UserData{
		return new UserData($this->id,$this->account_type,$this->name);
	}
}