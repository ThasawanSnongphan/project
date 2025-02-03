<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $primaryKey = 'proID';

    public function year()
    {
        return $this->belongsTo(Year::class, 'yearID', 'yearID'); 
        // 'year_id' คือคอลัมน์ FK ในตาราง projects, 'id' คือ PK ในตาราง years
    }
    
    public function target()
    {
        return $this->belongsTo(Targets::class, 'tarID','tarID');
    }

    public function step()
    {
        return $this->belongsTo(Steps::class, 'stepID','stepID');
    }

    public function strategic3LVMap()
    {
        return $this->hasMany(StrategicMap::class,'proID'); // หรือ hasOne ตามความสัมพันธ์
    }
    // public function objectiveProjects()
    // {
    //     return $this->hasMany(ObjectiveProjects::class,'proID');
    // }
    // // กำหนดความสัมพันธ์กับ Objective
    public function objectives()
    {
        return $this->belongsToMany(Objectives::class,  'objID', 'objID'); // เชื่อมโยงกับ objective_projects
    }

    // public function strategics()
    // {
    //     return $this->belongsToMany(strategics::class, 'strategic_maps', 'proID', 'straID');
    // }

    public function KPIMain()
    {
        return $this->belongsToMany(KPIMains::class, 'k_p_i_main_map_projects', 'proID', 'KPIMain3LVID');
    }
}
