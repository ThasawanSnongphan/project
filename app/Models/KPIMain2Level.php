<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KPIMain2Level extends Model
{
    protected $primaryKey = 'KPIMain2LVID';
    public function SFA()
    {
        return $this->belongsTo(StrategicIssues2Level::class, 'SFA2LVID','SFA2LVID');
    }

    public function director()
    {
        return $this->belongsTo(Users::class, 'directorID','userID');
    }

    public function recorder()
    {
        return $this->belongsTo(Users::class, 'recorderID','userID');
    }

    public function MapTactics() {
        return $this->hasMany(Tactic2LevelMapKPIMain2Level::class, 'KPIMain2LVID');
    }
}
