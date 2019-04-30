<?php
class UserData{
    private $id;
    private $accountType;
    private $name;
    public function __construct(int $id,string $accountType="None",string $name="None"){
        $this->id=$id;
        $this->accountType=$accountType;
        $this->name=$name;
    }
    public function getAccountType():string{
        return $this->accountType;
    }
    public function getName():string{
        return $this->name;
    }
    public function getID():int{
        return $this->id;
    }
}
?>