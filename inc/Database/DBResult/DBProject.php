<?php
namespace Database\DBResult;
class DBProject{
    private $students;//array of DBProjectStudent
    private $teacher_id;
    private $project_id;
    private $project_name;
    private $project_description;
    private $project_status;
    public function __construct(array $students,int $project_id,int $teacher_id,string $project_name,string $project_description,string $project_status){
        $this->students=$students;
        $this->project_id=$project_id;
        $this->teacher_id=$teacher_id;
        $this->project_name=$project_name;
        $this->project_description=$project_description;
        $this->project_status=$project_status;
    }
    public function getProjectStudents():array{
        return $this->students;
    }
    public function getTeacherId():int{
        return $this->teacher_id;
    }
    public function getProjectId():int{
        return $this->project_id;
    }
    public function getProjectName():string{
        return $this->project_name;
    }
    public function getProjectDescription():string{
        return $this->project_description;
    }
    public function getProjectStatus():string{
        return $this->project_status;
    }
}