<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goals extends Model
{
    use HasFactory;
    protected $primaryKey = 'goal3LVID';
    public function SFA()
    {
        return $this->belongsTo(StrategicIssues::class, 'SFA3LVID','SFA3LVID');
    }

    public function Tactics() {
        return $this->hasMany(Tactics::class, 'goal3LVID');
    }

    public function KPI() {
        return $this->hasMany(KPIMains::class, 'goal3LVID');
    }
}
