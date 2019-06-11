<?php
namespace Database\DBResult;
class DBStudentProject extends DBProject{
    private $accepted;
    private $manager;
    public function __construct(array $students,int $project_id,int $teacher_id,string $project_name,string $project_description,string $project_status,bool $accepted,bool $manager){
        parent::__construct($students,$project_id,$teacher_id,$project_name,$project_description,$project_status);
        $this->accepted=$accepted;
        $this->manager=$manager;
    }
    public function hasStudentAccepted():bool{
        return $this->accepted;
    }
    public function isStudentManager():bool{
        return $this->manager;
    }
}