<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strategic3Level extends Model
{
    protected $primaryKey = 'stra3LVID'; 
    use HasFactory;
    public function year()
    {
        return $this->belongsTo(Year::class, 'yearID','yearID');
    }

    public function SFA() {
        return $this->hasMany(StrategicIssues::class, 'stra3LVID');
    }


   

    // public function projects()
    // {
    //     return $this->belongsToMany(Projects::class, 'strategic_maps', 'straID', 'proID');
    // }


}
