<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tactic2Level extends Model
{
    protected $primaryKey = 'tac2LVID';
    public function SFA()
    {
        return $this->belongsTo(StrategicIssues2Level::class, 'SFA2LVID','SFA2LVID');
    }
    public function KPIMain()
    {
        return $this->belongsToMany(KPIMain2Level::class, 'tactic2_level_map_k_p_i_main2_levels', 'tac2LVID', 'KPIMain2LVID');
    }
}
