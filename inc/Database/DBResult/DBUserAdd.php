<?php
namespace Database\DBResult;
class DBUserAdd{
	private $login;
	private $name;
	private $account_type;
	private $email;

	public function __construct(string $login,string $name,string $account_type,string $email){
		$this->login=$login;
		$this->name=$name;
		$this->account_type=$account_type;
		$this->email=$email;
	}

	public function getLogin():string{
		return $this->login;
	}

	public function getName():string{
		return $this->name;
	}

	public function getAccountType():string{
		return $this->account_type;
	}

	public function getEMail():string{
		return $this->email;
	}
}