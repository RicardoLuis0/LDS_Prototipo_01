<?php
namespace Database\DBResult;
class DBProjectAdd{
    private $student_id;
    private $teacher_id;
    private $project_name;
    private $project_description;
    public function __construct(int $student_id,int $teacher_id,string $project_name,string $project_description){
        $this->student_id=$student_id;
        $this->teacher_id=$teacher_id;
        $this->project_name=$project_name;
        $this->project_description=$project_description;
    }
    public function getStudentId():int{
        return $this->student_id;
    }
    public function getTeacherId():int{
        return $this->teacher_id;
    }
    public function getProjectName():string{
        return $this->project_name;
    }
    public function getProjectDescription():string{
        return $this->project_description;
    }
}