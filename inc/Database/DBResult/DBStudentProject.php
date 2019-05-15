<?php
namespace Database\DBResult;
class DBStudentProject extends DBProject{
    private $accepted;
    public function __construct(array $students,int $project_id,int $teacher_id,string $project_name,string $project_description,string $project_status,bool $accepted){
        super::__construct($students,$project_id,$teacher_id,$project_name,$project_description,$project_status);
        $this->accepted=$accepted;
    }
    public function hasStudentAccepted():bool{
        return $this->accepted;
    }
}