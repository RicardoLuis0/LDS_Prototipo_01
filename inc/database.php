<?php
class LoginData{//dados necessarios para login
	private $login;
	private $password;
	public function __construct(string $login,string $password){
		$this->login=$login;
		$this->password=$password;
	}

	public function getLogin():string{
		return $this->login;
	}

	public function getPassword():string{
		return $this->password;
	}
}

class RegisterData{//dados necessarios para registro
	private $login;
	private $name;
	private $password;

	public function __construct(string $login,string $name,string $password){
		$this->login=$login;
		$this->name=$name;
		$this->password=$password;
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
}

abstract class Database{
	private $connected;
	public abstract function connect():void;
	public abstract function disconnect():void;
	public function isConnected():bool{
		return $this->connected;
	}
	public abstract function checkLogin(LoginData $loginData):bool;
	public abstract function registerUser(RegisterData $registerData):bool;
}
?>