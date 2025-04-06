<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class StrategicMap extends Model
{
    use HasFactory;
    public function Stra3LV()
    {
        return $this->belongsTo(Strategic3Level::class, 'stra3LVID', 'stra3LVID');
    }
    public function SFA3LV()
    {
        return $this->belongsTo(StrategicIssues::class, 'SFA3LVID', 'SFA3LVID');
    }
    public function goal3LV()
    {
        return $this->belongsTo(Goals::class, 'goal3LVID', 'goal3LVID');
    }
    public function tac3LV()
    {
        return $this->belongsTo(Tactics::class, 'tac3LVID', 'tac3LVID');
    }
}
