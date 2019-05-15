<?php
namespace Database\DBResult;
class DBProjectStudent{
    private $student_id;
    private $project_id;
    private $accepted;

    public function __construct(int $student_id,int $project_id,bool $accpted){
        $this->student_id=$student_id;
        $this->project_id=$project_id;
        $this->accepted=$accepted;
    }

    public function getStudentId():int{
        return $this->student_id;
    }

    public function getProjectId():int{
        return $this->project_id;
    }

    public function hasStudentAccepted():bool{
        return $this->accepted;
    }
}