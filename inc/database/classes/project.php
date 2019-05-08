<?php
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
class DBProject{
    private $student_id;
    private $teacher_id;
    private $project_id;
    private $project_name;
    private $project_description;
    private $project_status;
    public function __construct(int $student_id,int $teacher_id,int $project_id,string $project_name,string $project_description,string $project_status){
        $this->student_id=$student_id;
        $this->teacher_id=$teacher_id;
        $this->project_id=$project_id;
        $this->project_name=$project_name;
        $this->project_description=$project_description;
        $this->project_status=$project_status;
    }
    public function getStudentId():int{
        return $this->student_id;
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