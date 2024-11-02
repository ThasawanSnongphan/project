<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $primaryKey = 'proID';
    // public function objectiveProjects()
    // {
    //     return $this->hasMany(ObjectiveProjects::class,'proID');
    // }
    // // กำหนดความสัมพันธ์กับ Objective
    // public function objectives()
    // {
    //     return $this->belongsToMany(Objectives::class, 'objective_projects', 'proID', 'objID'); // เชื่อมโยงกับ objective_projects
    // }

    // public function strategics()
    // {
    //     return $this->belongsToMany(strategics::class, 'strategic_maps', 'proID', 'straID');
    // }
}
