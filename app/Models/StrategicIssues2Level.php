<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrategicIssues2Level extends Model
{
    protected $primaryKey = 'SFA2LVID';
    public function strategic()
    {
        return $this->belongsTo(Strategic2Level::class, 'stra2LVID','stra2LVID');
    }

    public function Tactics() {
        return $this->hasMany(Tactic2Level::class, 'SFA2LVID');
    }

    public function KPI() {
        return $this->hasMany(KPIMain2Level::class, 'SFA2LVID');
    }
}
