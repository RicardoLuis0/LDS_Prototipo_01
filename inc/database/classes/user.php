<?php
require_once(realpath(__DIR__."/../../user_data.php"));
class DBUserAdd{
	private $login;
	private $name;
	private $password;
	private $account_type;
	private $email;

	public function __construct(string $login,string $name,string $password,string $account_type,string $email){
		$this->login=$login;
		$this->name=$name;
		$this->password=$password;
		$this->account_type=$account_type;
		$this->email=$email;
	}

	public function getLogin():string{
		return $this->login;
	}

	public function getName():string{
		return $this->name;
	}

	public function getPassword():string{
		return $this->password;
	}

	public function getAccountType():string{
		return $this->account_type;
	}

	public function makeHash():string{
		return password_hash($this->password,PASSWORD_DEFAULT);
	}

	public function getEMail(){
		return $this->email;
	}
}
class DBUser{
	private $id;//int
	private $activated;//bool
	private $activation_key;//string
	private $login;//string
	private $name;//string
	private $hash;//string/hash
	private $account_type;//string
	private $email;//string
	public function __construct(int $id,bool $activated,string $activation_key,string $login,string $name,string $hash,string $account_type,string $email){
		$this->id=$id;
		$this->login=$login;
		$this->name=$name;
		$this->hash=$hash;
		$this->account_type=$account_type;
		$this->email=$email;
		$this->activated=$activated;
		$this->activation_key=$activation_key;
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
	public function getActivationKey(){
		return $this->activation_key;
	}
	public function makeUserData():UserData{
		return new UserData($this->id,$this->account_type,$this->name);
	}
}
