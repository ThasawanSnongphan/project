<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectiveProjects extends Model
{
    use HasFactory;
    protected $table = 'objective_projects';
    protected $primaryKey = 'objProID';
    // public function project()
    // {
    //     return $this->belongTo(Projects::class,'proID');
    // }

    // public function objective()
    // {
    //     return $this->belongTo(Objectives::class,'objID');
    // }
}
