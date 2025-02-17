<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strategic2LevelMapProject extends Model
{
    public function stra2LV()
    {
        return $this->belongsTo(Strategic2Level::class, 'stra2LVID','stra2LVID');
    }
    public function SFA2LV()
    {
        return $this->belongsTo(StrategicIssues2Level::class, 'SFA2LVID','SFA2LVID');
    }
    public function tac2LV()
    {
        return $this->belongsTo(Tactic2Level::class, 'tac2LVID','tac2LVID');
    }
}
