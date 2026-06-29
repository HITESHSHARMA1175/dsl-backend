<?php
namespace App\Classes;

class MakeProjectId
{
    public function makeProjectId($project_id)
    {
        $createProjectId = 'SNB' . $project_id;
        return $createProjectId;
    }
}
