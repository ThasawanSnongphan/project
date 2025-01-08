<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objectives extends Model
{
    use HasFactory;
    protected $primaryKey = 'objID';
    // public function objectiveProjects()
    // {
    //     return $this->hasMany(ObjectiveProjects::class,'objID');
    // }
    //  // กำหนดความสัมพันธ์กับ Project
    //  public function projects()
    //  {
    //      return $this->belongsToMany(Projects::class, 'objective_projects', 'objID', 'proID'); // เชื่อมโยงกับ objective_projects
    //  }
}
